<?php
include 'db.php';

// check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $createdatetime = date('Y-m-d H:i:s');

    $query = "INSERT INTO UserAccounts (Username, Email, PasswordHash, CreateDateTime) VALUES ('$username', '$email', '$hashed_password', '$createdatetime')";

    if (mysqli_query($con, $query)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($con);
    }

    mysqli_close($con);
}
?>
