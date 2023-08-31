<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HoleV2</title>
    <link rel="stylesheet" type="text/css" href="../styles/style.css" />
    <link rel="stylesheet" type="text/css" href="../styles/title-screen.css" />
    <link rel="stylesheet" type="text/css" href="../styles/login.css" />
    <link rel="stylesheet" type="text/css" href="../styles/discover.css" />
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
                <a href="#" id="login-link">log In</a>
            </div>
    </div>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form action="YOUR_BACKEND_SCRIPT.php" method="POST">
                <input type="text" name="username" placeholder="Username">
                <input type="password" name="password" placeholder="Password">
                <button type="submit">Login</button>
            </form>
            <!-- <p>Don't have an account? <a href="./registration.php">Register here</a>.</p> -->
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

    <script>
        var modal = document.getElementById("myModal");
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
