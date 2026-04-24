<?php
    // FILENAME : search_studentID.php
    // searches for a student by their ID and displays their information 

    $conn = new mysqli("localhost", "root", "", "lab7");

    if ($conn->connect_error) {
        die("Connection failed");
    }

    if (isset($_GET['student_number'])) {
        $student_number = $_GET['student_number'];

        $sql = "SELECT * FROM students WHERE student_number = '$student_number'";
        $result = $conn->query($sql);

        if ($row = $result->fetch_assoc()) {
            echo json_encode($row);
        } 
        else {
            echo json_encode(["status" => "not_found"]);
        }
    }
?>