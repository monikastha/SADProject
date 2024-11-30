<?php
include '../dbconnection/connection.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $imagePath = '';

    // Check if an image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = basename($_FILES['image']['name']);
        $targetDir = '../uploads/';
        $targetFile = $targetDir . $imageName;

        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Store the relative path in the database
            $imagePath = 'uploads/' . $imageName;
        } else {
            echo "Error uploading the image.";
            exit();
        }
    } else {
        echo "No image uploaded or there was an error uploading the image.";
        exit();
    }

    // Insert the new art details into the database
    $sql = "INSERT INTO art (title, description, image_path) VALUES ('$title', '$description', '$imagePath')";
    if (mysqli_query($conn, $sql)) {
        header('Location: view_art.php?add=success');
        exit();
    } else {
        echo "Error adding record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Art</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/dashboard.css"> 
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #333;
            color: #fff;
            padding: 20px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
        }
        .right-sidebar {
            width: 250px;
            background-color: #333;
            color: #fff;
            padding: 20px;
            height: 100vh;
            position: fixed;
            right: 0;
            top: 0;
        }
        .main-content {
            flex: 1;
            margin-left: 250px;
            margin-right: 250px;
            padding: 20px;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container h3 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        .form-container input[type="text"],
        .form-container textarea,
        .form-container input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-container button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #218838;
        }
        .image-preview {
            margin-top: 20px;
            display: none;
        }
        .image-preview img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
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
        <div class="form-container">
            <h3>Add New Art</h3>
            <form action="add_art.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" required>
                <label for="description">Description:</label>
                <textarea name="description" id="description" rows="4" required></textarea>
                <label for="image">Image:</label>
                <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)" required>
                <div class="image-preview" id="imagePreview">
                    <img id="imagePreviewImg" src="#" alt="Image Preview">
                </div>
                <button type="submit">Add Art</button>
            </form>
        </div>
    </div>
    <?php include 'right-sidebar.php'; ?>
    <script>
        function validateForm() {
            const imageInput = document.getElementById('image');
            if (imageInput.files.length === 0) {
                alert('Please select an image to upload.');
                return false;
            }
            return true;
        }

        function previewImage(event) {
            const imagePreview = document.getElementById('imagePreview');
            const imagePreviewImg = document.getElementById('imagePreviewImg');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreviewImg.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>