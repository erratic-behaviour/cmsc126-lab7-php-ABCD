
<?php
    // FILENAME: insert_delete_feature.php
    
    $conn = new mysqli("localhost", "root", "", "lab_7");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);

    }

    if($_POST["action"] === "insert") {
        $id = date("Y") . rand(10000,99999); // geneerate random student ID so that no 2 ids are the same
        $name = $_POST["name"];
        $age = $_POST["age"];
        $email = $_POST["email"];
        $course = $_POST["course"];
        $year = $_POST["year_level"];
        $grad = isset($_POST["graduation_status"]) ? 1 : 0;

        if (!file_exists("uploads/")) mkdir("uploads/");
        $image_path = "uploads/" . basename($_FILES["profile_photo"]["name"]);
        move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $image_path);
        
        $conn->query("INSERT IGNORE INTO top_level (Student_id, Name, Age, Image) 
                    VALUES ($id, '$name', $age, '$image_path')");
        $conn->query("INSERT IGNORE INTO lower_level (Student_id, Email, Course, Year_level, Graduation_status) 
                    VALUES ($id, '$email', '$course', $year, $grad)");

        echo "<script>alert('Student registered successfully!');</script>";

    } else if($_POST["action"] === "delete") {
        $id = (int)$_POST["student_id"];

        $imagerow = $conn->query("SELECT Image FROM top_level WHERE Student_id = $id");
        if ($imagerow) {
            $row = $imagerow->fetch_assoc();
            if ($row) {
                $image_path = $row["Image"];
                if (!empty($image_path) && file_exists($image_path)) {
                    unlink($image_path);
                }
            }
        }

        $conn->query("DELETE FROM top_level WHERE Student_id = $id");
        $conn->query("DELETE FROM lower_level WHERE Student_id = $id");

        echo "<script>alert('Student deleted successfully!');</script>";
    }

    $conn->close();
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
                    <h1>Success!</h1>
                    <p>Student information has been successfully processed.</p>
                    <a href="index.php"><button class="return-btn">Register another student</button></a>
                </div>
            <!-- END OF STUDENT REGISTRATION FORM -->
            </div>
    </body>
</html>