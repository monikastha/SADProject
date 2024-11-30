<?php
include '../dbconnection/connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing art details
    $sql = "SELECT * FROM art WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $art = mysqli_fetch_assoc($result);

    if (!$art) {
        echo "Art not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $imagePath = $art['image_path'];

    // Check if a new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = basename($_FILES['image']['name']);
        $imagePath = '../uploads/' . $imageName;

        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            // Delete the old image file
            if (file_exists($art['image_path'])) {
                unlink($art['image_path']);
            }
        } else {
            echo "Error uploading the new image.";
            exit();
        }
    }

    // Update the art details in the database
    $sql = "UPDATE art SET title = '$title', description = '$description', image_path = '$imagePath' WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header('Location: view_art.php?edit=success');
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Art</title>
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
        .current-image {
            margin-bottom: 20px;
        }
        .current-image img {
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
        <h3>Edit Art</h3>
        <div class="form-container">
            <form action="edit_art.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($art['title']); ?>" required>
                <label for="description">Description:</label>
                <textarea name="description" id="description" rows="4" required><?php echo htmlspecialchars($art['description']); ?></textarea>
                <label for="image">Image:</label>
                <input type="file" name="image" id="image">
                <div class="current-image">
                    <p>Current Image:</p>
                    <img src="<?php echo $art['image_path']; ?>" alt="<?php echo htmlspecialchars($art['title']); ?>">
                </div>
                <button type="submit">Update Art</button>
            </form>
        </div>
    </div>
    <?php include 'right-sidebar.php'; ?>
</body>
</html>