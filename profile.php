<?php
    session_start();
    $username = $_SESSION['username'] ?? 'Guest';
    $email = $_SESSION['email'] ?? 'Not available';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../styles/style.css" />
    <link rel="stylesheet" type="text/css" href="../styles/discover.css" />
    <link rel="stylesheet" type="text/css" href="../styles/profile.css" />
</head>
<body>


<div id="navigation">
        <a href="./index.php">
            <div id="logo-container">
                <img id="page-logo" src="../images/logo/holeiconwhite.png" alt="Page logo">
                <p id="page-name">hole</p>
            </div>
        </a>
        <div id="middle-links">
            <a href="./index.php" id="discover-link">discover</a>
            <a href="./profile.php" id="profile-link">profile</a>
        </div>
        <div id="login-container">
            <?php
            if (isset($_SESSION['username'])) {
                echo '<a href="logout.php" id="logout-link">Logout</a>';
            } else {
                echo '<a href="#myModal" id="login-link">Login</a>';
            }
            ?>
        </div>
    </div>
</div>


    <div class="profile-content">
        <img src="./images/logo/profile.png" alt="Profile image" id="profile-image">
        <div class="profile-container">
            <h2>My Profile</h2>
            <p>Name: <?php echo $username; ?></p>
            <p>Email: <?php echo $email; ?></p>
        </div>
    </div>

</body>
</html>