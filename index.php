<?php
    // FILENAME: index.php

    $conn = new mysqli("localhost", "root", "", "lab_7");
                        // address, username, password, database name
    
    // if connection fails
    if ($conn -> connect_error) {
        include 'initializedb.php';
        $conn = new mysqli("localhost", "root", "", "lab_7");
    }

    // initialize states (defualt for blank forms)
    $row = [
        'Student_id' => '', 'Name' => '', 'Age' => '',
        'Email' => '', 'Course' => '', 'Year_level' => '',
        'Graduation_status' => 0, 'Image' => ''
    ];

    $is_update = false;

    // SEARCH LOGIC
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search_id = $conn -> real_escape_string($_GET['search']);
        $sql = "SELECT * FROM top_level t
                INNER JOIN lower_level l ON t.Student_id = l.Student_id
                WHERE t.Student_id = 'search_id'";
        $result = $conn -> query($sql);

        if ($data = $result -> fetch_assoc()) {
            $row = $data;
            $is_update = true;
        }

        else {
            echo "<script>alert('Student ID $search_id not found.')</script>";
        }
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
            <!-- LEFT COLUMN: FORM CONTAINER -->
            <div id="form-container" class="containers">
                
                <!-- FORM HEADER -->
                <div id="form-header" class="container-header">
                    <h1><?php echo $is_update ? "Update Student Details" : "Student Registration"; ?></h1>
                    <p>All fields marked * are required</p>
                </div>
                

                <form method="POST" id="student-form" action="insert_delete_feature.php" enctype="multipart/form-data">
                    <!-- FORM MAIN BODY -->
                    <div id="form-body">

                        <!-- PERSONAL INFORMATION SECTION -->
                        <div id="personal-info-section" class="gen-sections">
                            <h3>Personal Information</h3>
                            
                            <?php if ($is_update): ?>
                                <label>Student ID: <strong><?php echo $row['Student_id']; ?></strong></label>
                                <input type="hidden" name="student_id" value="<?php echo $row['Student_id']; ?>">
                            <?php else: ?>
                                <label for="student-id-input">Student ID <span class="note">(Generated if left blank)</label>
                                <input type="text" name="student_id" id="student-id-input" placeholder="Enter ID">
                            <?php endif; ?>
                            
                            <label for="name-input">Name <span class="required">*</span></label>
                            <input type="text" name="name" id="name-input" value="<?php echo htmlspecialchars($row['Name']); ?>" placeholder="Enter student name" required>
                            
                            <label for="age-input">Age <span class="required">*</span></label>
                            <input type="number" name="age" id="age-input" value="<?php echo htmlspecialchars($row['Age']); ?>" min="0" max="99" placeholder="Enter student age (0-99)" required>
                            
                            <label for="email-input">E-mail <span class="required">*</span></label>
                            <input type="email" name="email" id="email-input" value="<?php echo htmlspecialchars($row['Email']); ?>" placeholder="Enter student e-mail" required>
                            <p class="note">Must be a valid e-mail address (max 40 characters).</p>
                        </div>
                        
                        <!-- ACADEMIC INFORMATION -->
                        <div id="academic-info-panel" class="gen-sections">
                            <h3>Academic Information</h3>
                            <label for="course-select">Course <span class="required">*</span></label>
                            <select id="course-select" name="course" required>
                                <option value="COMPUTER SCIENCE" <?php echo ($row['Course'] == 'COMPUTER SCIENCE') ? 'selected' : ''; ?>>COMPUTER SCIENCE</option>
                                <option value="MICROBIOLOGY" <?php echo ($row['Course'] == 'MICROBIOLOGY') ? 'selected' : ''; ?>>MICROBIOLOGY</option>
                                <option value="COMPUH TER ENGINEERING" <?php echo ($row['Course'] == 'COMPUH TER ENGINEERING') ? 'selected' : ''; ?>>COMPUH TER ENGINEERING</option>
                            </select>
                            
                            <label for="year-level-select">Year Level <span class="required">*</span></label>
                            <select id="year-level-select" name="year_level" required>
                                <option value="1" <?php echo ($row['Year_level'] == '1') ? 'selected' : ''; ?>>1</option>
                                <option value="2" <?php echo ($row['Year_level'] == '2') ? 'selected' : ''; ?>>2</option>
                                <option value="3" <?php echo ($row['Year_level'] == '3') ? 'selected' : ''; ?>>3</option>
                                <option value="4" <?php echo ($row['Year_level'] == '4') ? 'selected' : ''; ?>>4</option>
                                <option value="Nth" <?php echo ($row['Year_level'] == 'Nth') ? 'selected' : ''; ?>>Nth</option>
                            </select>
                            
                            <p>Graduating this year? (leave unchecked if not)<span class="required">*</span>
                                <input type="checkbox" id="grad-status-input" name="graduation_status">
                            </p>
                        </div>
                        
                        
                        <!-- PROFILE PHOTO -->
                        <div id="profile-photo-section" class="form-sections">
                            <h3>Profile Photo <span class="required">*</span></h3>
                            <div id="drop-area">
                                <p>Drag and drop an image here, or click to select a file.</p>
                                <input id="image-drop-inp" type="file" name="profile_photo" accept="image/*" <?php echo !$is_update ?> required>
                            </div>
                            <div id="preview">
                                <?php if($row['Image']): ?>
                                    <p>Current:</p>
                                    <img src="<?php echo $row['Image']; ?>" class="preview-img">
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- ACTION BUTTONS -->
                        <div class="gen-sections">
                            <button type="submit" name="action" value="<?php echo $is_update ? 'update' : 'insert'; ?>" class="submit-btn">
                                <?php echo $is_update ? "Update Student" : "Submit Registration"; ?>
                            </button>

                            <?php if($is_update): ?>
                                <button type="submit" name="action" value="delete" class="return-btn" onclick="return confirm('Delete this student?')">Delete Record</button>
                                <a href="index.php">Cancel & Add New</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>

            <!-- END OF STUDENT REGISTRATION FORM -->
            </div>

            
            <!-- RIGHT COLUMN: SEARCH STUDENT -->
            <div id="search-container" class="containers">
                <!-- SEARcH HEADER -->
                <div class="container-header">
                    <h2>Search Student</h2>
                </div>

                <div id="search-student-body" class="gen-sections">
                    <form method="GET" action = "search_studentID.php">
                        <label for="student-number">Search Student Number:</label>
                        <input type="text" name="search" id="student-number" placeholder="Enter student number">
                        <button type="submit">Search</button>
                    </form>
                </div>

            </div>
        
        </main>
        <?php
            ob_start();
            include 'initializedb.php';
            $output = ob_get_clean();
            $plain  = strip_tags($output);
        ?>
        <script>console.log(<?= json_encode($plain) ?>)</script>
        <script src = "image_handler.js"></script>
    </body>
</html>