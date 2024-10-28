<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Details</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Google Fonts Import */
        @import url('https://fonts.googleapis.com/css2?family=Sevillana&family=Roboto:wght@400;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
            display: flex;
            justify-content: center;
        }

        .content-container {
            max-width: 2000px; /* Increased width for more prominent display */
            margin: 20px;
            padding: 15px; /* Increased padding for a spacious look */
            background: #fff;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); /* Slightly larger shadow for emphasis */
            border-radius: 12px; /* Slightly larger border-radius */
            flex: 3; /* Larger flex value for main content */
        }

        h1 {
            font-size: 36px; /* Larger font size for the title */
            color: #333;
            margin-bottom: 25px;
            text-align: center;
            font-family: 'Sevillana', cursive;
        }

        .content-body {
            line-height: 1.8; /* Increased line-height for better readability */
            font-size: 20px; /* Larger font size for body text */
            margin-bottom: 35px;
        }

        .content-image {
            width: 100%;
            max-height: 500px; /* Increased max-height for larger images */
            object-fit: cover;
            border-radius: 12px; /* Slightly larger border-radius */
            margin-bottom: 25px;
        }

        .content-meta {
            font-size: 16px; /* Slightly larger meta text */
            color: #888;
            text-align: right;
        }

        .back-button {
            display: inline-block;
            padding: 12px 24px; /* Larger button */
            font-size: 18px; /* Larger font size */
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 8px; /* Larger border-radius */
            text-decoration: none;
            text-align: center;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        .recommended-container {
            flex: 1;
            margin-left: 30px; /* Increased margin for more spacing */
        }

        .recommended-content {
            background: #fff;
            padding: 20px; /* Larger padding for recommended content */
            margin-bottom: 20px; /* Increased margin between recommendations */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px; /* Slightly larger border-radius */
        }

        .recommended-content img {
            width: 100%;
            max-height: 150px; /* Increased image size for recommendations */
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .recommended-content h3 {
            font-size: 20px; /* Larger font size for recommended titles */
            margin-bottom: 12px;
            font-family: 'Sevillana', cursive;
        }

        .recommended-content a {
            font-size: 16px; /* Larger font size for links */
            color: #007bff;
            text-decoration: none;
        }

        .recommended-content a:hover {
            text-decoration: underline;
        }

        .container {
            display: flex;
            max-width: 1400px; /* Increased max-width for the overall layout */
            margin: 50px auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content-container">
            <?php
            include 'db.php';
            $id = $_GET['id'];
            $stmt = $pdo->prepare("SELECT * FROM content WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $item = $stmt->fetch();

            if ($item):
            ?>
                <h1><?php echo htmlspecialchars($item['title']); ?></h1>
                <?php if ($item['image']): ?>
                    <img src="<?php echo htmlspecialchars($item['image']); ?>" class="content-image" alt="Content Image">
                <?php endif; ?>
                <div class="content-body"><?php echo nl2br(htmlspecialchars($item['body'])); ?></div>
                <div class="content-meta">Published on <?php echo $item['created_at']; ?></div>
            <?php else: ?>
                <p>Content not found.</p>
            <?php endif; ?>
            <a href="index.php" class="back-button">Back to Home</a>
        </div>

        <div class="recommended-container">
            <h3>Recommended Content</h3>
            <?php
            $stmt = $pdo->prepare("SELECT * FROM content WHERE id != :id ORDER BY created_at DESC LIMIT 5");
            $stmt->execute(['id' => $id]);
            $recommended = $stmt->fetchAll();

            foreach ($recommended as $rec):
            ?>
                <div class="recommended-content">
                    <?php if ($rec['image']): ?>
                        <img src="<?php echo htmlspecialchars($rec['image']); ?>" alt="Recommended Image">
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($rec['title']); ?></h3>
                    <a href="details.php?id=<?php echo $rec['id']; ?>">Read More</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
