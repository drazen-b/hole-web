<?php
session_start();
include 'db.php'; // include your database connection file

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get UserID from the database
$username = $_SESSION['username'];
$result = $con->query("SELECT UserID FROM UserAccounts WHERE Username = '$username'");
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userId = $row['UserID'];
} else {
    // Handle error - user not found
    exit();
}

$coinId = $_POST['coinId'];
$amount = $_POST['amount'];
$price = $_POST['price'];

$stmt = $con->prepare("INSERT INTO UserCryptoPurchases (UserID, CoinID, Amount, Price) VALUES (?, ?, ?, ?)");
if ($stmt === false) {
    // Handle error - the prepare statement failed
    echo "Error: " . $con->error;
    exit();
}

$stmt->bind_param("isdd", $userId, $coinId, $amount, $price);
$stmt->execute();

echo '<script type="text/javascript">
alert("Coin has been added to your portfolio!");
window.location.href = "./profile.php";
</script>';

$stmt->close();
?>
