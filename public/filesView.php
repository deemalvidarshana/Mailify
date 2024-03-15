<?php
require "../config.php";
require "../common.php";

if (isset($_GET["filesId"])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $filesId = $_GET["filesId"];
        $sql = "SELECT a.*, GROUP_CONCAT(m.sender) AS senders
                FROM files AS a
                INNER JOIN message_files AS ma ON a.filesId = ma.filesId
                INNER JOIN message AS m ON ma.id = m.id
                WHERE a.filesId = :filesId
                GROUP BY a.filesId";

        $statement = $connection->prepare($sql);
        $statement->bindValue(":filesId", $filesId);
        $statement->execute();

        $files = $statement->fetch();
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} else {
    echo "No files filesId specified.";
}
?>

<?php require "templates/header.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>View Files</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            color: #333;
        }

        p {
            margin-top: 10px;
        }

        strong {
            font-weight: bold;
        }

        a {
            color: #007bff;
            text-decoration: none;
            margin-right: 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        .btn-delete {
            color: #fff;
            background-color: #ff0000;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>View Files</h2>

        <?php if ($files) : ?>
            <p><strong>Files ID:</strong> <?php echo escape($files["filesId"]); ?></p>
            <p><strong>Title:</strong> <?php echo escape($files["title"]); ?></p>
            <p><strong>Description:</strong> <?php echo escape($files["description"]); ?></p>
            <p><strong>Created Date:</strong> <?php echo escape($files["CreatedDate"]); ?></p>
            
            <p><strong>From:</strong> <?php echo escape($files["senders"]); ?></p>
            
            <a href="editfiles.php?filesId=<?php echo escape($files["filesId"]); ?>">Edit</a>
            
            <!-- Delete button/link -->
            <a href="deletefiles.php?filesId=<?php echo escape($files["filesId"]); ?>"
            onclick="return confirm('Are you sure you want to delete this file?')" class="btn-delete">Delete</a>
        <?php else : ?>
            <p>No files found with that files ID.</p>
        <?php endif; ?>

        <a href="index.php">Back to home</a>
    </div>
</body>
</html>

<?php require "templates/footer.php"; ?>
