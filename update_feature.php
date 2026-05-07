<?php
    // FILENAME: update_feature.php
    // Handles the updating logic of the system

    include 'initializedb.php';
    
    //text_value changes text depending if it was a deletion or update
    $text_value = null;

    // main logic conditional
    if ($_POST["action"] === "delete"){
        $text_value = false;
        $id = (int)$_POST["student_id"];

        $stmt = $conn->prepare("SELECT Image FROM top_level WHERE Student_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $imagerow = $stmt->get_result();
        if ($imagerow) {
            $row = $imagerow->fetch_assoc();
            if ($row) {
                $image_path = $row["Image"];
                if (!empty($image_path) && file_exists($image_path)) {
                    unlink($image_path);
                }
            }
        }
        $stmt->close();

        $stmt1 = $conn->prepare("DELETE FROM top_level WHERE Student_id = ?");
        $stmt1->bind_param("i", $id);
        $stmt1->execute();
        $stmt1->close();
        
        $stmt2 = $conn->prepare("DELETE FROM lower_level WHERE Student_id = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $stmt2->close();

        echo "<script>alert('Student deleted successfully!');</script>";
    }


    else if ($_POST["action"] === "update") {
        $text_value = true;
        // collect HTML inputs
        $id     =   $_POST["student_id"];
        $name = trim($_POST["name"]);
        $age = (int)$_POST["age"];
        $email = trim($_POST["email"]);
        $course = trim($_POST["course"]);
        $year = (int)$_POST["year_level"];
        $grad = isset($_POST["graduation_status"]) ? 1 : 0;
    
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

<!DOCTYPE html>
<html>
    <head>
        <title>Success!</title>
        <link rel="stylesheet" href="./styles.css">
    </head>
    <body>
        
        
        <main>
            <div id="form-container">
                <!-- FORM HEADER -->
                <div id="completed">
                    <h1><?php echo $text_value ? "Update Success!" : "Deletion Success!"; ?></h1>
                    <p>Student information has been successfully <?php echo $text_value ? "updated" : "deleted"; ?>.</p>
                    <a href="index.php"><button class="return-btn">Register another student</button></a>
                </div>
            <!-- END OF STUDENT REGISTRATION FORM -->
            </div>
    </body>
</html>