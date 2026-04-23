<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = new mysqli("localhost", "root", "", "lab_7");

    if ($_POST["action"] === "insert") {
        $id = $_POST["student_id"];
        $name = $_POST["name"];
        $age = $_POST["age"];
        $email = $_POST["email"];
        $course = $_POST["course"];
        $year = $_POST["year_level"];
        $grad = isset($_POST["graduation_status"]) ? 1 : 0;

        // handle image upload
        if (!file_exists("uploads/")) mkdir("uploads/");
        $image_path = "uploads/" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image_path);

        $conn->query("INSERT INTO top_level (Student_id, Name, Age, Image) 
                      VALUES ($id, '$name', $age, '$image_path')");
        $conn->query("INSERT INTO lower_level (Student_id, Email, Course, Year_level, Graduation_status) 
                      VALUES ($id, '$email', '$course', $year, $grad)");

        echo "<script>alert('Student registered successfully!');</script>";

    } else if ($_POST["action"] === "delete") {
        $id = $_POST["student_id"];
        $conn->query("DELETE FROM top_level WHERE Student_id = $id");
        $conn->query("DELETE FROM lower_level WHERE Student_id = $id");

        echo "<script>alert('Student deleted successfully!');</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        Status: <i><?php include 'initializedb.php'; ?></i>
        <form method="POST" enctype="multipart/form-data">
            <input type="number" name="student_id" placeholder="Student ID" required><br>
            <input type="text" name="name" placeholder="Name" maxlength="40" required><br>
            <input type="number" name="age" placeholder="Age" min="0" max="99" required><br>
            <input type="email" name="email" placeholder="Email" maxlength="40" required><br>
            <input type="text" name="course" placeholder="Course" maxlength="40" required><br>
            <select name="year_level" required>
                <option value="">Select Year Level</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select><br>
            <label>
                <input type="checkbox" name="graduation_status"> Graduating this year?
            </label><br>
            <input type="file" name="image" accept="image/*" required><br><br>

            <button type="submit" name="action" value="insert">Insert</button>
        </form>

        <h2>Delete Student</h2>
        <form method="POST">
            <input type="number" name="student_id" placeholder="Student ID" required>
            <button type="submit" name="action" value="delete">Delete</button>
        </form>
    </body>
</html>