<?php

    require_once __DIR__ . './vendor/autoload.php';

    use Dotenv\Dotenv;

    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $servername = $_ENV("db_host"); // Name of the server
    $username = $_ENV("db_user"); // user
    $password = $_ENV("db_pass"); // poassword
    $dbname = $_ENV("db_name");  // db name
    $dbport = $_ENV("db_port"); // port
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname, $dbport);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    echo "Connected successfully!" . "<br/>";

    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS lab_7";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully (or already exists!)" . "<br/>";
    } else {
        echo "Error creating database: " . $conn->error . "<br/>";
    }

    $conn->select_db("lab_7");

    $top_level = "CREATE TABLE IF NOT EXISTS top_level (
        Student_id INT(9) UNSIGNED PRIMARY KEY,
        Name VARCHAR(40) NOT NULL,
        Age INT(2) UNSIGNED NOT NULL,
        Image VARCHAR(255) NOT NULL
    )";

    $lower_level = "CREATE TABLE IF NOT EXISTS lower_level (
        Student_id INT(9) UNSIGNED PRIMARY KEY,
        Email VARCHAR(40) NOT NULL,
        Course VARCHAR(40) NOT NULL,
        Year_level INT(1) UNSIGNED NOT NULL,
        Graduation_status BOOLEAN NOT NULL,
        FOREIGN KEY (Student_id) REFERENCES top_level(Student_id) ON DELETE CASCADE
    )";

    if ($conn->query($top_level) === TRUE) {
        echo "Top level table created successfully". "<br/>";
    } else {
        echo "Error creating table: " . $conn->error. "<br/>";
    }

    if ($conn->query($lower_level) === TRUE) {
        echo "Lower level table created successfully". "<br/>";
    } else {
        echo "Error creating table: " . $conn->error. "<br/>";
    }
    // Close the connection
    $conn->close();
?>