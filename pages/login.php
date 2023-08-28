<?php
// Start the session
session_start();

include('../db.php'); //povezivanje s bazom

// Function to safely get POST data
function getPost($key) {
    return isset($_POST[$key]) ? htmlspecialchars($_POST[$key]) : '';
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && getPost('action') === 'login') {
    $username = getPost('username');
    $password = getPost('password');

    $stmt = $conn->prepare("SELECT UserID, PasswordHash FROM UserAccounts WHERE Username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($userId, $hashedPassword);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($password, $hashedPassword)) {
        $_SESSION['userId'] = $userId;
        header('Location: /profile.php');
        exit();
    } else {
        echo "Invalid username or password";
    }
}

// Handle registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && getPost('action') === 'register') {
    $fullName = getPost('fullName');
    $email = getPost('email');
    $username = getPost('username');
    $password = password_hash(getPost('password'), PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO UserAccounts (FullName, Email, Username, PasswordHash) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $fullName, $email, $username, $password);
    $stmt->execute();
    $stmt->close();

    echo "Registration successful!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HoleV2</title>
    <link rel="stylesheet" type="text/css" href="../styles/style.css" />
    <link rel="stylesheet" type="text/css" href="../styles/title-screen.css" />
    <link rel="stylesheet" type="text/css" href="../styles/login.css" />
</head>
<body>

    <div id="navigation">
        <a href="../index.html">
            <div id="logo-container">
                <img id="page-logo" src="../images/logo/holeiconwhite.png" alt="Page logo">
                <p id="page-name">hole</h1>
            </div>
        </a>
        <div id="middle-links">
            <a href="#" id="discover-link">discover</a>
            <a href="#" id="profile-link">profile</a>
        </div>
        <div id="login-container">
            <a href="#" id="login-link">log In</a>
        </div>
    </div>

    <div class="container">
        <div class="form-container">
            <form class="login-form" method="POST">
                <input type="hidden" name="action" value="login">
                <h2>Login</h2>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        </div>
        <div class="form-container">
            <form class="register-form" method="POST">
                <input type="hidden" name="action" value="register">
                <h2>Register</h2>
                <input type="text" name="fullName" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Register</button>
            </form>
        </div>
    </div>



</body>
</html>
