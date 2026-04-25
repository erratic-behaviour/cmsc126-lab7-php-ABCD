
<?php
    // FILENAME: insert_delete_feature.php
    
    $conn = new mysqli("localhost", "root", "", "lab_7");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);

    }

    $update_delete = null;

    if($_POST["action"] === "insert") {
        $id = !empty($_POST["student_id"]) ? $_POST["student_id"] : date("Y") . rand(10000,99999); // generate random student ID so that no 2 ids are the same
        $name = trim($_POST["name"]);
        $age = (int)$_POST["age"];
        $email = trim($_POST["email"]);
        $course = trim($_POST["course"]);
        $year = (int)$_POST["year_level"];
        $grad = isset($_POST["graduation_status"]) ? 1 : 0;

        if (!file_exists("uploads/")) mkdir("uploads/");
        $image_path = "uploads/" . basename($_FILES["profile_photo"]["name"]);
        move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $image_path);
        
        $stmt1 = $conn->prepare("INSERT IGNORE INTO top_level (Student_id, Name, Age, Image) 
                    VALUES (?, ?, ?, ?)");
        $stmt1->bind_param("isis", $id, $name, $age, $image_path);
        $stmt1->execute();
        $stmt1->close();
        
        $stmt2 = $conn->prepare("INSERT IGNORE INTO lower_level (Student_id, Email, Course, Year_level, Graduation_status) 
                    VALUES (?, ?, ?, ?, ?)");
        $stmt2->bind_param("issis", $id, $email, $course, $year, $grad);
        $stmt2->execute();
        $stmt2->close();

        echo "<script>alert('Student registered successfully!');</script>";

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
                    <h1>Registration Success!</h1>
                    <p>Student information has been successfully registered.</p>
                    <a href="index.php"><button class="return-btn">Register another student</button></a>
                </div>
            <!-- END OF STUDENT REGISTRATION FORM -->
            </div>
    </body>
</html>