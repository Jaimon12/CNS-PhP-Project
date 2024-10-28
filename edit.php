<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $stmt = $pdo->prepare("SELECT * FROM content WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $content = $stmt->fetch();

    if (!$content) {
        echo "Content not found.";
        exit;
    }
} else {
    echo "No content ID specified.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $status = $_POST['status'];

    $imagePath = $content['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = 'uploads/';
        $targetFile = $targetDir . basename($_FILES['image']['name']);
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = $targetFile;
        } else {
            echo "Failed to upload image.";
        }
    }

    $stmt = $pdo->prepare("UPDATE content SET title = :title, body = :body, status = :status, image = :image WHERE id = :id");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':body', $body);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':image', $imagePath);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Failed to update content.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Content</title>
    <link rel="stylesheet" href="style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 28px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: 700;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"], textarea, select {
            padding: 10px;
            font-size: 16px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="file"] {
            margin-bottom: 20px;
        }

        input[type="submit"] {
            padding: 12px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .current-image {
            max-width: 200px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Content</h1>
        <form action="edit.php?id=<?php echo htmlspecialchars($id); ?>" method="POST" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($content['title']); ?>" required>

            <label for="body">Body:</label>
            <textarea name="body" id="body" rows="10" required><?php echo htmlspecialchars($content['body']); ?></textarea>

            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="draft" <?php if ($content['status'] == 'draft') echo 'selected'; ?>>Draft</option>
                <option value="published" <?php if ($content['status'] == 'published') echo 'selected'; ?>>Published</option>
            </select>

            <label for="image">Image:</label>
            <input type="file" name="image" id="image">
            <?php if ($content['image']): ?>
                <img src="<?php echo htmlspecialchars($content['image']); ?>" alt="Current Image" class="current-image">
            <?php endif; ?>

            <input type="submit" value="Update Content">
        </form>
        <a href="index.php" class="back-link">Back to Content List</a>
    </div>
</body>
</html>
