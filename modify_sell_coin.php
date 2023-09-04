<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
$coinId = $_POST['coinId'];
$sellAmount = $_POST['sellAmount'];

if ($sellAmount <= 0) {
    echo '<script type="text/javascript">
    alert("Invalid amount!");
    window.location.href = "./profile.php";
    </script>';
    exit();
}

$stmt = $con->prepare("SELECT Amount FROM UserCryptoPurchases WHERE UserID = (SELECT UserID FROM UserAccounts WHERE Username = ?) AND CoinID = ?");
$stmt->bind_param("ss", $username, $coinId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $currentAmount = $row['Amount'];
} else {
    echo "Purchase not found";
    exit();
}

$stmt->close();

if ($sellAmount > $currentAmount) {
    echo "Sell amount is greater than current amount";
    exit();
}

$newAmount = $currentAmount - $sellAmount;

if ($newAmount > 0) {
    $stmt = $con->prepare("UPDATE UserCryptoPurchases SET Amount = ? WHERE UserID = (SELECT UserID FROM UserAccounts WHERE Username = ?) AND CoinID = ?");
    $stmt->bind_param("dss", $newAmount, $username, $coinId);

    if ($stmt->execute() === TRUE) {
        echo '<script type="text/javascript">
        alert("Record updated successfully!");
        window.location.href = "./profile.php";
        </script>';
    } else {
        echo "Error updating record: " . $con->error;
    }

    $stmt->close();
} else {
    $stmt = $con->prepare("DELETE FROM UserCryptoPurchases WHERE UserID = (SELECT UserID FROM UserAccounts WHERE Username = ?) AND CoinID = ?");
    $stmt->bind_param("ss", $username, $coinId);

    if ($stmt->execute() === TRUE) {
        echo '<script type="text/javascript">
        alert("Record deleted successfully!");
        window.location.href = "./profile.php";
        </script>';
    } else {
        echo "Error deleting record: " . $con->error;
    }

    $stmt->close();
}

header('Location: profile.php');
?>
