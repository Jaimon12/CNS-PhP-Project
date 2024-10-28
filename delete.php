<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Get the image path for deletion
    $stmt = $pdo->prepare("SELECT image FROM content WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $content = $stmt->fetch();

    if ($content) {
        // Delete the content from the database
        $stmt = $pdo->prepare("DELETE FROM content WHERE id = :id");
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            // Delete the image file if it exists
            if ($content['image'] && file_exists($content['image'])) {
                unlink($content['image']);
            }
            header("Location: index.php");
            exit;
        } else {
            echo "Failed to delete content.";
        }
    } else {
        echo "Content not found.";
    }
} else {
    echo "No content ID specified.";
}
?>
