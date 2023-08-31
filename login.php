<?php
session_start();
include("db.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Query the database for the user
    $query = "SELECT * FROM UserAccounts WHERE Username='$username'";
    $result = mysqli_query($con, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['PasswordHash'])) {
            // Set session variables
            $_SESSION['username'] = $row['Username'];
            $_SESSION['email'] = $row['Email'];
            $_SESSION['is_admin'] = $row['IsAdmin'];
            header('Location: profile.php');
            exit;
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "Username does not exist";
    }
}

mysqli_close($con);
?>
