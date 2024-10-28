<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $status = $_POST['status'];
    $user_id = $_SESSION['user_id'];

    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = 'uploads/';
        $targetFile = $targetDir . basename($_FILES['image']['name']);
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = $targetFile;
        } else {
            echo "Failed to upload image.";
        }
    }

    $stmt = $pdo->prepare("INSERT INTO content (title, body, status, image, user_id) VALUES (:title, :body, :status, :image, :user_id)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':body', $body);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':image', $imagePath);
    $stmt->bindParam(':user_id', $user_id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Failed to save content.";
    }
}
?>
