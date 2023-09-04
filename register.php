<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $createdatetime = date('Y-m-d H:i:s');

    $query = "INSERT INTO UserAccounts (Username, Email, PasswordHash, CreateDateTime) VALUES ('$username', '$email', '$hashed_password', '$createdatetime')";

    if (mysqli_query($con, $query)) {
        echo '<script type="text/javascript">
        alert("Succesfully registered, please log in!");
        window.location.href = "./index.php";
        </script>';
    } else {
        $error = mysqli_error($con);

        if (strpos($error, 'Duplicate entry!') !== false) {
            if (strpos($error, 'UserAccounts.Email') !== false) {
                $errorMessage = "Email is already used!";
            } elseif (strpos($error, 'UserAccounts.Username') !== false) {
                $errorMessage = "Username is already used!";
            } else {
                $errorMessage = "Duplicate entry!";
            }
        } else {
            $errorMessage = "Error: " . $query . "<br>" . $error;
        }
        
        echo '<script type="text/javascript">
                alert("' . $errorMessage . '");
                window.location.href = "./index.php";
              </script>';

    }

    mysqli_close($con);
}
?>