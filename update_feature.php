<?php
    // FILENAME: update_feature.php
    // Handles the updating logic of the system

    // connecting to database
    $conn = new mysqli("localhost", "root", "", "lab_7");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    // main logic block
    if ($_POST["action"] === "update") {
        // collect HTML inputs
        $id     =   $_POST["student_id"];
        $name   =   $_POST["name"];
        $age    =   $_POST["age"];
        $email  =   $_POST["email"];
        $course =   $_POST["course"];
        $year   =   $_POST["year_level"];
        $grad   =   $_POST["graduation_status"] ? 1 : 0;
    
        // handle image upload
        // checls if a file or directory already exists 
        if (!empty($_FILES["profile_photo"]["name"])) {
            // new image incoming
            // mkdir creates a new directory named "uploads"
            if (!file_exists("uploads/")) mkdir("uploads/");

            // gets photo's file name, strips directory paths
            $image_path = "uploads/" . basename($_FILES["profile_photo"]["name"]);

            /*  specifically moves the uploaded file via HTTP POST from its temp storage
                to a permanent destination (uloads folder) */
            move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $image_path);
        }

        else {
            // user kept the old image. fetch current path db
            $res = $conn ->  query("SELECT Image
                                    FROM top_level
                                    WHERE Student_id = $id");
            $temp = $res ->  fetch_assoc();
            $image_path = $temp['Image'];
        }
        /*
            prepared statements to avoid SQL injections -
            update top_level table
            */
            $stmt1   = $conn -> prepare("UPDATE top_level
                                        SET Name=?, Age=?, Image=?
                                        WHERE Student_id=?");
    
            // "sisi" -> string, int, string, int
            $stmt1 -> bind_param("sisi", $name, $age, $image_path, $id);
            $stmt1 -> execute(); // sends actual data to database
            $stmt1 -> close();   // free up system resources
            
            
            // update low_level table
            $stmt2   = $conn -> prepare("UPDATE lower_level
                                        SET Email=?, Course=?, Year_level=?, Graduation_status=?
                                        WHERE Student_id=?");
    
            $stmt2 -> bind_param("ssiii", $email, $course, $year, $grad, $id);
            $stmt2 -> execute();
            $stmt2 -> close();
            


        echo "<script>alert('Student updated successfully')</script>";
    }
?>

