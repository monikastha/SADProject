<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Contact</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../styles/dashboard.css"> <!-- Link to your CSS file -->
    <style>
        body {
            font-family: "Montserrat", sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .edit-form-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 50%;
            max-width: 600px;
            text-align: center;
        }

        .edit-form-container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .edit-form input, .edit-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .edit-form input:focus, .edit-form textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .edit-form button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .edit-form button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .edit-form .form-group {
            text-align: left;
            margin-bottom: 15px;
        }

        .edit-form .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
    </style>
</head>
<body>
    <?php
    include '../dbconnection/connection.php';

    // Handle edit request
    if (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $description = $_POST['description'];
        $visitor_id = $_POST['visitor_id'];

        $sql = "UPDATE `message` SET `description`='$description', `visitor_id`='$visitor_id' WHERE `id`='$id'";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Message updated successfully'); window.location.href='contact.php';</script>";
        } else {
            echo "<script>alert('Error updating message');</script>";
        }
    }

    // Fetch message to edit
    $edit_message = null;
    if (isset($_GET['edit_id'])) {
        $edit_id = $_GET['edit_id'];
        $sql = "SELECT * FROM `message` WHERE `id`='$edit_id'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $edit_message = mysqli_fetch_assoc($result);
        } else {
            echo "<script>alert('Message not found'); window.location.href='contact.php';</script>";
        }
    } else {
        echo "<script>window.location.href='contact.php';</script>";
    }
    ?>

    <?php if ($edit_message): ?>
    <div class="edit-form-container">
        <h2>Edit Message</h2>
        <form class="edit-form" action="edit.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $edit_message['id']; ?>">
            <div class="form-group">
                <label for="description">Message:</label>
                <textarea name="description" id="description" cols="30" rows="10" required><?php echo htmlspecialchars($edit_message['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="visitor_id">Visitor ID:</label>
                <input type="text" name="visitor_id" id="visitor_id" value="<?php echo htmlspecialchars($edit_message['visitor_id']); ?>" required>
            </div>
            <button type="submit" name="edit">Update</button>
        </form>
    </div>
    <?php endif; ?>
</body>
</html>