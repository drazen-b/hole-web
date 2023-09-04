<?php
    include("auth_session.php");
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
            <a href="../index.html" id="discover-link">discover</a>
            <a href="./profile.html" id="profile-link">profile</a>
        </div>
        <div id="login-container">
            <a href="#" id="login-link">log In</a>
        </div>
    </div>

    <div class="container">
        <div class="form-container">
            <form class="login-form">
                <h2>Login</h2>
                <input type="text" placeholder="Username" required>
                <input type="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        </div>
        <div class="form-container">
            <form class="register-form">
                <h2>Register</h2>
                <input type="text" placeholder="Full Name" required>
                <input type="email" placeholder="Email" required>
                <input type="text" placeholder="Username" required>
                <input type="password" placeholder="Password" required>
                <button type="submit">Register</button>
            </form>
        </div>
    </div>



</body>
</html>