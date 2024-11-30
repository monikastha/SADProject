<?php
include '../dbconnection/connection.php'; // Include database connection

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure the ID is an integer

    // Delete query
    $sql = "DELETE FROM `message` WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<script>alert('Message deleted successfully');</script>";
    } else {
        echo "<script>alert('Error deleting message: " . mysqli_error($conn) . "');</script>";
    }

    // Redirect back to the table page
    echo "<script>window.location.href = 'contact.php';</script>";
}
?>
