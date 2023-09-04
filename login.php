<?php
session_start();
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $query = "SELECT * FROM UserAccounts WHERE Username='$username'";
    $result = mysqli_query($con, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['PasswordHash'])) {
            $_SESSION['username'] = $row['Username'];
            $_SESSION['email'] = $row['Email'];
            $_SESSION['is_admin'] = $row['IsAdmin'];
            header('Location: profile.php');
            exit;
        } else {
            echo '<script type="text/javascript">
                alert("Wrong password!");
                window.location.href = "./index.php";
                </script>';
        }
    } else {
        echo '<script type="text/javascript">
            alert("Username does not exist!");
            window.location.href = "./index.php";
            </script>';
    }
}

mysqli_close($con);
?>
