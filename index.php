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
                        <label for="name-input">Name <span class="required">*</span></label>
                        <input type="text" name="name" id="name-input" placeholder="Enter student name" required>
                        
                        <label for="age-input">Age <span class="required">*</span></label>
                        <input type="number" name="age" id="age-input" min="0" max="99" placeholder="Enter student age (0-99)" required>
                        
                        <label for="email-input">E-mail <span class="required">*</span></label>
                        <p class="note">Must be a valid e-mail address (max 40 characters).</p>
                        <input type="email" name="email" id="email-input" placeholder="Enter student e-mail" required>
                    </div>
                    
                    
                    <div id="academic-info-panel" class="gen-sections">
                        <h3>Academic Information</h3>
                        <label for="course-select">Course <span class="required">*</span></label>
                        <select id="course-select" name="course" required>
                            <option>COMPUTER SCIENCE</option>
                            <option>MICROBIOLOGY</option>
                            <option>COMPUH TER ENGINEERING</option>
                        </select>
                        
                        <label for="year-level-select">Year Level <span class="required">*</span></label>
                        <select id="year-level-select" name="year_level" required>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>Nth</option>
                        </select>
                        
                        <p>Graduating this year? (leave unchecked if not)<span class="required">*</span></p>
                        <input type="checkbox" id="grad-status-input" name="graduation_status">
                    </div>
                    
                    
                    <div id="profile-photo-section" class="form-sections">
                        <h3>Profile Photo <span class="required">*</span></h3>
                        <div id="drop-area">
                            <p>Drag and drop an image here, or click to select a file.</p>
                            <input id="image-drop-inp" type="file" name="profile_photo" accept="image/*" required>
                        </div>
                        <div id="preview"></div>
                        
                    </div>
                    
                    <br/>
                    <button type="submit" name="action" value="insert" class="submit-btn">Submit</button>
                    <br/>
                </div>
                </form>

            <!-- END OF STUDENT REGISTRATION FORM -->
            </div>

            
            <!-- SEARCH STUDENT -->
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