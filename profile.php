<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header('Location: registration.php');
    exit();
}

$username = $_SESSION['username'] ?? 'Not logged in';
$email = $_SESSION['email'] ?? 'Not logged in';

$result = $con->query("SELECT UserID FROM UserAccounts WHERE Username = '$username'");
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userId = $row['UserID'];
} else {
    exit();
}

$result = $con->query("SELECT CoinID, Amount, Price FROM UserCryptoPurchases WHERE UserID = '$userId'");
$purchases = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $purchases[] = $row;
    }
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="./styles/style.css" />
    <link rel="stylesheet" type="text/css" href="./styles/discover.css" />
    <link rel="stylesheet" type="text/css" href="./styles/profile.css" />
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
            <p>Username:
                <?php echo $username; ?>
            </p>
            <p>Email:
                <?php echo $email; ?>
            </p>
        </div>
    </div>

    <h3>My Coins</h3>


    <div class="profile-coins">
        <div id="coins-info">
            <p class="coin-name">Coin Name</p>
            <p class="coin-amount">Amount</p>
            <p class="coin-worth">Worth €</p>
            <p class="coin-price">Current Price €</p>
            <p class="coin-profit">Profit €</p>
            <p class="coin-modify">Sell</p>
        </div>

        <?php
        if (!empty($purchases)) {
            foreach ($purchases as $purchase) {
                $coinId = $purchase['CoinID'];
                $amount = $purchase['Amount'];
                $buyingPrice = $purchase['Price'];

                $url = "https://api.coingecko.com/api/v3/simple/price?ids=" . $coinId . "&vs_currencies=eur";
                $json = file_get_contents($url);
                $data = json_decode($json, true);
                $currentPrice = $data[$coinId]['eur'];

                $worth = $currentPrice * $amount;
                $profit = $amount * $buyingPrice - $worth;
                ?>
                <div class="coin">
                    <form class="coin" method="POST" action="modify_sell_coin.php">
                        <input type="hidden" name="coinId" value="<?php echo $coinId; ?>">
                        <p class="coin-name">
                            <?php echo $coinId; ?>
                        </p>
                        <p class="coin-amount">
                            <?php echo number_format($amount, 2); ?>
                        </p>
                        <p class="coin-worth">€
                            <?php echo $worth; ?>
                        </p>
                        <p class="coin-price" style="color: <?php echo ($currentPrice >= $buyingPrice) ? 'green' : 'red'; ?>">
                            €<?php echo $currentPrice; ?>
                        </p>
                        <p class="coin-profit" style="color: <?php echo ($profit >= 0) ? 'green' : 'red'; ?>">
                            €<?php echo $profit; ?>
                        </p>
                        <div>
                            <input type="number" name="sellAmount" min="0" max="<?php echo $amount; ?>" step="0.00000001" required>
                            <button  type="submit" name="sell">Sell</button>
                        </div>
                    </form>
                </div>
                <?php
            }
        } else {
            echo '<p>You have not purchased any coins yet.</p>';
        }
        ?>
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