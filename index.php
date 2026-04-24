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
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="stylesheet" href="./styles.css">
        
        <title>Register Student Details</title>
    </head>
    <body>
        
        
        <main>
            <div id="form-container">
                <!-- FORM HEADER -->
                <div id="form-header" class="form-sections">
                    <h1>Student Registration</h1>
                    <p>All fields marked * are required</p>
                </div>
                

                <!-- FORM MAIN BODY -->
                <div id="form-body">

                    <!-- PERSONAL INFORMATION SECTION -->
                    <div id="personal-info-section" class="form-sections">
                        <h3>Personal Information</h3>
                        <label for="name-input">Name <span>*</span></label>
                        <input type="text" name="name" id="name-input" placeholder="Enter student name">
                        
                        <label for="age-input">Age <span>*</span></label>
                        <input type="number" name="age" id="age-input" placeholder="Enter student age (0-99)">
                        
                        <label for="email-input">E-mail <span>*</span></label>
                        <input type="email" name="email" id="email-input" placeholder="Enter student e-mail">
                        <p>Must be a valid e-mail address (max 40 characters).</p>
                        
                    </div>
                    
                    
                    <div id="academic-info-panel" class="form-sections">
                        <h3>Academic Information</h3>
                        <label for="course-select">Course <span>*</span></label>
                        <select id="course-select" name="course">
                            <option>COURSE 1</option>
                            <option>COURSE 2</option>
                            <option>COURSE 3</option>
                        </select>
                        
                        <label for="year-level-select">Year Level <span>*</span></label>
                        <select id="year-level-select" name="year_level">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>Nth</option>
                        </select>
                        
                        <p>Graduating this year? </p><span>*</span>
                        <input type="checkbox" id="grad-status-input" name="graduation_status">
                        <label for="grad-status-input"></label>
                    </div>
                    
                    
                    <div id="profile-photo-section">
                        <h3>Profile Photo</h3>
                        <p>Profile Image </p><span>*</span>

                    </div>

                    <input type="submit">
                </div>

            <!-- END OF STUDENT REGISTRATION FORM -->
            </div>


            <!-- SEARCH STUDENT -->
            <div id="search-student-body">
                <form method="GET" action = "search_studentID.php">
                    <label for="student-number">Search Student Number:</label>
                    <input type="text" name="student_number" id="student-number" placeholder="Enter student number">
                    <button type="submit" onclick = "searchStudent()">Search</button>
                </form>
            </div>
        
        </main>
        <?php
            ob_start();
            include 'initializedb.php';
            $output = ob_get_clean();
            $plain  = strip_tags($output);
        ?>
        <script>console.log(<?= json_encode($plain) ?>)</script>
        <script src = "search_studentID.js"></script>
    </body>
</html>