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
    

        // prepared statements to avoid SQL injections
        $stmt   = $conn -> prepare("UPDATE top_level
                                    SET Name=?, Age=?, Image=?
                                    WHERE Student_id=?");

        // "sisi" -> string, int, string, int
        $stmt -> bind_param("sisi", $name, $age, $image_path, $id);
        $stmt -> execute(); // sends actual data to database
        $stmt -> close();   // free up system resources

        echo "<script>alert('Student updated successfully')</script>";
    }


?>

