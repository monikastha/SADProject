<?php
include '../dbconnection/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_FILES['image'];

    // Check if the image was uploaded without errors
    if ($image['error'] == 0) {
        $imageName = basename($image['name']);
        $imagePath = 'uploads/' . $imageName; // Save the image in the uploads folder

        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($image['tmp_name'], $imagePath)) {
            // Insert image details into the database
            $sql = "INSERT INTO art (title, description, image_path) VALUES ('$title', '$description', '$imagePath')";
            if (mysqli_query($conn, $sql)) {
                header('Location: ../index.php?upload=success');
                exit();
            } else {
                echo "Error saving image details: " . mysqli_error($conn);
            }
        } else {
            echo "Error moving the uploaded file.";
        }
    } else {
        echo "Error uploading the image.";
    }
}
?>