<?php
// FILENAME : search_studentID.php
// searches for a student by their ID and displays their information 

$conn = new mysqli("localhost", "root", "", "lab_7");

if ($conn->connect_error) {
    die("Connection failed");
}

if (isset($_GET['search'])) {
    $student_number = $_GET['search'];


    // GETS STUDENTS FROM TOP + BOTTOM INNER JOIN

    $sql = "SELECT * 
        FROM top_level t
        INNER JOIN lower_level l ON t.Student_id = l.Student_id
        WHERE t.Student_id = '$student_number'";
    $result = $conn->query($sql);

    ob_start();
    if ($row = $result->fetch_assoc()) {
        echo "search working";
    } else {
        echo json_encode(["status" => "not_found"]);
    }
    ob_clean();
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
        <div id="form-container" class="containers">
            <!-- FORM HEADER -->
            <div id="form-header" class="container-header">
                <h1>Student Registration</h1>
                <p>All fields marked * are required</p>
            </div>

            <form method="POST" action="update_feature.php" enctype="multipart/form-data">

                <!-- FORM MAIN BODY -->
                <div id="form-body">

                    <!-- PERSONAL INFORMATION SECTION -->
                    <div id="personal-info-section" class="gen-sections">
                        <h3>Personal Information</h3>
                        <label for="student-id">Student ID: <strong><?php echo $row['Student_id'] ?></strong><span class="required"></span></label>

                        <label for="name-input">Name <span class="required">*</span></label>
                        <input type="text" name="name" id="name-input" placeholder="Enter student name"
                            value=<?php echo $row['Name'] ?> required>

                        <label for="age-input">Age <span class="required">*</span></label>
                        <input type="number" name="age" id="age-input" placeholder="Enter student age (0-99)"
                            value=<?php echo $row['Age'] ?> required>

                        <label for="email-input">E-mail <span class="required">*</span></label>
                        <p class="note">Must be a valid e-mail address (max 40 characters).</p>
                        <input type="email" name="email" id="email-input" placeholder="Enter student e-mail"
                            value=<?php echo $row['Email'] ?>
                            required>
                    </div>


                    <div id="academic-info-panel" class="gen-sections">
                        <h3>Academic Information</h3>
                        <label for="course-select">Course <?php echo $row['Course'] ?><span class="required">*</span></label>
                        <select id="course-select" name="course" required>
                            <option>COURSE 1</option>
                            <option>COURSE 2</option>
                            <option>COURSE 3</option>
                        </select>

                        <label for="year-level-select">Year Level <?php echo $row['Year_level'] ?><span class="required">*</span></label>
                        <select id="year-level-select" name="year_level" required>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>Nth</option>
                        </select>

                        <p>Graduating this year? (leave unchecked if not)<span class="required">*</span></p>
                        <input type="checkbox" id="grad-status-input" name="graduation_status"
                            <?php echo ($row['Graduation_status'] == 1) ? 'checked' : '' ?>>
                        <label for="grad-status-input"></label>
                    </div>


                    <div id="profile-photo-section" class="form-sections">
                        <h3>Profile Photo <span class="required">*</span></h3>
                        <div id="drop-area">
                            <p>Drag and drop an image here, or click to select a file.</p>
                            <input id="image-drop-inp" type="file" name="profile_photo" accept="image/*" required hidden>
                        </div>
                        <div id="preview">
                            <p style="text-align: center;">Preview:</p>
                            <img src=<?php echo $row['Image'] ?> alt="Image Preview" class="preview-img">
                        </div>

                    </div>

                    <br />
                    <button type="submit" name="action" value="update" class="submit-btn">Update</button>
                    <br />
                </div>
            </form>

            <!-- END OF STUDENT REGISTRATION FORM -->
        </div>

        <div id="search-container" class="containers">
        <div class="container-header">
            <h2>Search Student</h2>
        </div>
        <!-- SEARCH STUDENT -->
        <div id="search-student-body" class="gen-sections">
            <form method="GET" action="search_studentID.php">
                <label for="student-number">Search Student Number:</label>
                <input type="text" name="search" id="student-number" placeholder="Enter student number">
                <button type="submit">Search</button>
            </form>
        </div>
        </div>

    </main>
    <script src="image_handler.js"></script>
</body>

</html>