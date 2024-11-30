<?php
include '../dbconnection/connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art Gallery</title>
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
        .table-container {
            width: 100%;
            display: flex;
            justify-content: center;
        }
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 1rem;
            text-align: left;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        table th,
        table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .delete-btn, .edit-btn {
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.3s;
        }
        .delete-btn {
            background-color: red;
        }
        .delete-btn:hover {
            background-color: darkred;
            transform: scale(1.05);
        }
        .edit-btn {
            background-color: blue;
        }
        .edit-btn:hover {
            background-color: darkblue;
            transform: scale(1.05);
        }
        .action-buttons {
            display: flex;
            gap: 10px; /* Add gap between buttons */
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
        <h3>Art Gallery</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM art";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        $sn = 1; // Serial number counter
                        while ($row = mysqli_fetch_assoc($result)) {
                            $imagePath = $row['image_path'];
                            echo "<tr>
                                    <td>" . $sn++ . "</td>
                                    <td>" . htmlspecialchars($row['title']) . "</td>
                                    <td>" . htmlspecialchars($row['description']) . "</td>
                                    <td><img src='../" . $imagePath . "' alt='" . htmlspecialchars($row['title']) . "' style='width: 100px; height: auto;'></td>
                                    <td class='action-buttons'> 
                                        <a href='edit_art.php?id=" . $row['id'] . "' class='edit-btn'>Edit</a>
                                        <a href='#' onclick='confirmDelete(" . $row['id'] . ")' class='delete-btn'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No art found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include 'right-sidebar.php'; ?>
    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this art?')) {
                window.location.href = 'delete_art.php?id=' + id;
            }
        }
    </script>
</body>
</html>