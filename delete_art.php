<?php
include '../dbconnection/connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get the image path
    $sql = "SELECT image_path FROM art WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $imagePath = $row['image_path'];

    // Delete the image file
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Delete the record from the database
    $sql = "DELETE FROM art WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header('Location: view_art.php?delete=success');
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>