<?php
include 'dbconnection/connection.php';

$sql = "SELECT title, image FROM art";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo htmlspecialchars($row['image']);
        echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
        echo "<img src='" . htmlspecialchars($row['image']) . "' alt='Art' style='width:300px;' />";
    }
} else {
    echo "No art found.";
}

$conn->close();
?>
