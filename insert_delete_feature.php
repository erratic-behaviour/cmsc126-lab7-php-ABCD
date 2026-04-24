<?php
    $conn = new mysqli("localhost", "root", "", "lab_7");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);

    }

    if($_POST["action"] === "insert") {
        $id = $_POST["student_id"];
        $name = $_POST["name"];
        $age = $_POST["age"];
        $email = $_POST["email"];
        $course = $_POST["course"];
        $year = $_POST["year_level"];
        $grad = isset($_POST["graduation_status"]) ? 1 : 0;

        if (!file_exists("uploads/")) mkdir("uploads/");
        $image_path = "uploads/" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image_path);

        $conn->query("INSERT INTO top_level (Student_id, Name, Age, Image) 
                    VALUES ($id, '$name', $age, '$image_path')");
        $conn->query("INSERT INTO lower_level (Student_id, Email, Course, Year_level, Graduation_status) 
                    VALUES ($id, '$email', '$course', $year, $grad)");

        echo "<script>alert('Student registered successfully!');</script>";

    } else if($_POST["action"] === "delete") {
        $id = $_POST["student_id"];
        $conn->query("DELETE FROM top_level WHERE Student_id = $id");
        $conn->query("DELETE FROM lower_level WHERE Student_id = $id");

        echo "<script>alert('Student deleted successfully!');</script>";
    }

    $conn->close();
?>