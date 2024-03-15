<?php
require "../config.php";
require "../common.php";

$messageSelectOptions = "";

try {
    $connection = new PDO($dsn, $username, $password, $options);
    $connection->beginTransaction();

    $sql = "SELECT * FROM message";

    $result = $connection->query($sql);

    if ($result->rowCount() > 0) {
        foreach ($result as $row) {
            $id = $row["id"];
            $sender = htmlspecialchars($row["sender"]);
            $messageSelectOptions .= "<option value='$id'>$sender</option>";
        }
    } else {
        $messageSelectOptions = "<option value='0'>No messages available</option>";
    }

    $connection->commit();
} catch (PDOException $error) {
    $connection->rollBack();
    echo $sql . "<br>" . $error->getMessage();
}

if (isset($_POST['submit'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $connection->beginTransaction();

        $insertSql = "INSERT INTO files (title, description) VALUES (:title, :description)";
        $statement = $connection->prepare($insertSql);

        $title = $_POST['title'];
        $description = $_POST['description'];

        $statement->bindParam(':title', $title);
        $statement->bindParam(':description', $description);

        if ($statement->execute()) {
            $attachmentId = $connection->lastInsertId();

            if (isset($_POST['message_files']) && is_array($_POST['message_files'])) {
                foreach ($_POST['message_files'] as $messageId) {
                    $attachMessageSql = "INSERT INTO message_files (filesId, id) VALUES (:filesId, :id)";
                    $attachStatement = $connection->prepare($attachMessageSql);

                    $attachStatement->bindParam(':filesId', $attachmentId);
                    $attachStatement->bindParam(':id', $messageId);

                    $attachStatement->execute();
                }
            }

            $connection->commit();

            echo "<blockquote>$title successfully added.</blockquote>";
        } else {
            $connection->rollBack();
            echo "<blockquote>Error adding $title.</blockquote>";
        }
    } catch (PDOException $error) {
        $connection->rollBack();
        echo $insertSql . "<br>" . $error->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create a File</title>
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

        form label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        select {
            height: 100px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        blockquote {
            background-color: #d4edda;
            border-left: 5px solid #155724;
            padding: 10px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create a File</h2>

        <form method="post">
            <label for="title">File title</label>
            <input type="text" name="title" id="title" required>

            <label for="description">Description</label>
            <input type="text" name="description" id="description">

            <label for="message_files">From</label>
            <select multiple name="message_files[]" id="message_files">
                <?php echo $messageSelectOptions; ?>
            </select>

            <input type="submit" name="submit" value="Create files">
        </form>

        <a href="filesHome.php">Back to the previous page</a>
    </div>
</body>
</html>
