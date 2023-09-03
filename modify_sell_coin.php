<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
$coinId = $_POST['coinId'];
$sellAmount = $_POST['sellAmount'];

// Validate sell amount
if ($sellAmount <= 0) {
    echo '<script type="text/javascript">
    alert("Invalid amount!");
    window.location.href = "./profile.php";
    </script>';
    exit();
}

// Get current amount from the database
$stmt = $con->prepare("SELECT Amount FROM UserCryptoPurchases WHERE UserID = (SELECT UserID FROM UserAccounts WHERE Username = ?) AND CoinID = ?");
$stmt->bind_param("ss", $username, $coinId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $currentAmount = $row['Amount'];
} else {
    // Handle error - purchase not found
    echo "Purchase not found";
    exit();
}

$stmt->close();

// Validate if sell amount is not greater than current amount
if ($sellAmount > $currentAmount) {
    echo "Sell amount is greater than current amount";
    exit();
}

// Update the amount
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
