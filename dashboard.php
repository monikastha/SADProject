<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include '../dbconnection/connection.php';

// Fetch the total number of arts
$sql = "SELECT COUNT(*) AS total_arts FROM art";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$totalArts = $row['total_arts'];
?>
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../styles/dashboard.css"> <!-- Link to the CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"> <!-- Link to Font Awesome for icons -->
</head>

<body>
    <?php
    include 'sidebar.php';
    ?>
    <div class="main-content">
        <div class="header">
            <div class="search-bar">
                <input type="text" placeholder="Search...">
            </div>
            <div class="notifications">
                <i class="fas fa-bell"></i>
                <i class="fas fa-envelope"></i>
                <i class="fas fa-user"></i>
            </div>
        </div>
        <h1>Welcome to the Dashboard</h1>
        <p>Select an option from the sidebar to get started.</p>
        <div class="total-arts">
        <h2>Total Arts = <?php echo $totalArts; ?></h2>
        </div>
    </div>
    <?php
    include 'right-sidebar.php';
    ?>

</body>

</html>