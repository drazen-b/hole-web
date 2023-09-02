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
                echo '<a href="logout.php" id="logout-link">logout</a>';
            } else {
                echo '<a href="#myModal" id="login-link">login</a>';
            }
            ?>
        </div>

    </div>

    <div id="loginModal" class="logModal">
        <div class="loginModal-content">
            <span class="close">&times;</span>
            <form action="login.php" method="POST">
                <input type="text" name="username" placeholder="Username">
                <input type="password" name="password" placeholder="Password">
                <button type="submit">login</button>
            </form>
            <p>Don't have an account? <a href="./registration.php">Register here</a>.</p>
        </div>
    </div>


    <div class="profile-content">
        <img src="./images/logo/profile.png" alt="Profile image" id="profile-image">
        <div class="profile-container">
            <h2>My Profile</h2>
            <p>Name:
                <?php echo $username; ?>
            </p>
            <p>Email:
                <?php echo $email; ?>
            </p>
        </div>
    </div>

    <script>
        var modal = document.getElementById("loginModal");
        var btn = document.getElementById("login-link");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function () {
            modal.style.display = "block";
        }

        span.onclick = function () {
            modal.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

</body>

</html>