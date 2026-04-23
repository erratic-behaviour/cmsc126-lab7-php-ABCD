<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="stylesheet" href="./styles.css">
        
        <title>Register Student Details</title>
    </head>
    <body>
        <!-- Server status -->
        Welcome<br/>
        Status: <i ><?php include 'initializedb.php' ?></i>
        /*form here */
        
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
                        <input type="text" id="name-input" placeholder="Enter student name">
                        
                        <label for="age-input">Age <span>*</span></label>
                        <input type="number" id="age-input" placeholder="Enter student age (0-99)">
                        
                        <label for="email-input">E-mail <span>*</span></label>
                        <input type="email" id="email-input" placeholder="Enter student e-mail">
                        <p>Must be a valid e-mail address (max 40 characters).</p>
                        
                    </div>
                    
                    
                    <div id="academic-info-panel" class="form-sections">
                        <h3>Academic Information</h3>
                        <label for="course-select">Course <span>*</span></label>
                        <select id="course-select">
                            <option>COURSE 1</option>
                            <option>COURSE 2</option>
                            <option>COURSE 3</option>
                        </select>
                        
                        <label for="year-level-select">Year Level <span>*</span></label>
                        <select id="year-level-select">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>Nth</option>
                        </select>
                        
                        <p>Graduating this year? </p><span>*</span>
                        <input type="checkbox" id="grad-status-input">
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

        </div>
        
    </main>
    </body>
</html>