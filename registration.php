<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./images/logo/holeiconwhite.png">
    <title>HoleV2</title>
    <link rel="stylesheet" type="text/css" href="./styles/style.css" />
    <link rel="stylesheet" type="text/css" href="./styles/title-screen.css" />
    <link rel="stylesheet" type="text/css" href="./styles/login.css" />
    <link rel="stylesheet" type="text/css" href="./styles/discover.css" />
</head>

<body>

    <div id="navigation">
        <a href="../index.php">
            <div id="logo-container">
                <img id="page-logo" src="../images/logo/holeiconwhite.png" alt="Page logo">
                <p id="page-name">hole</h1>
                </div>
            </a>
            <div id="middle-links">
                <a href="../index.php" id="discover-link">discover</a>
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

    <div class="container">
        <div class="form-container">
            <form class="register-form" action="register.php" method="POST">
                <h2>Register</h2>
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Register</button>
            </form>
        </div>
    </div>

    <footer>
        <div class="footer-holder">
            <p>Web LV3</p>
            <div>
                <p>Made by: Drazen Bertic</p>
                <a href="https://www.coingecko.com/en/api">Powered by CoinGecko API!</a>
            </div>
        </div>
    </footer>

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
