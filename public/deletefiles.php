<?php
require "../config.php";
require "../common.php";

if (isset($_GET["filesId"])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $filesId = $_GET["filesId"];

        // Delete associated records in 'message_files' table
        $deleteMessageFilesSql = "DELETE FROM message_files WHERE filesId = :filesId";
        $deleteMessageFilesStatement = $connection->prepare($deleteMessageFilesSql);
        $deleteMessageFilesStatement->bindValue(":filesId", $filesId);
        $deleteMessageFilesStatement->execute();

        // Delete the file record from the 'files' table
        $deleteSql = "DELETE FROM files WHERE filesId = :filesId";
        $deleteStatement = $connection->prepare($deleteSql);
        $deleteStatement->bindValue(":filesId", $filesId);
        $deleteStatement->execute();

        // Redirect back to the home page after deletion
        header("Location: index.php");
    } catch (PDOException $error) {
        echo "Error: " . $error->getMessage();
    }
} else {
    echo "No files ID specified.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete File</title>
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

        a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Delete File</h2>
        <p>Are you sure you want to delete this file?</p>

        <form method="post">
            <input type="submit" name="submit" value="Delete">
        </form>

        <a href="index.php">Cancel</a>
    </div>
</body>
</html>
