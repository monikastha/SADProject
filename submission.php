<?php
include 'dbconnection/connection.php';
// echo $_SERVER['REQUEST_METHOD'];
// echo $_POST['submit'];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $visitor_id = 1;
    $description = $_POST['description'];
    $sql = "INSERT INTO `message`(description,visitor_id) VALUES ('$description', '$visitor_id')";
    $result = mysqli_query($conn, $sql);
    echo $result;
    if ($result) {
        echo "<script>alert('Message has been sent successfully');
        window.location.href = 'index.php';</script>";
        exit();
    } else {
        die(mysqli_error($conn));
    }
} else {
    echo "<script>alert('Form submission error. Please try again.');</script>";
    header("Location: error_page.php"); // Optional error page redirection
    exit();
}
?>