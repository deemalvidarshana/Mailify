<?php
require "../config.php";
require "../common.php";

$updateSuccess = false;

if (isset($_POST['update'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $filesId = $_POST['filesId'];
        $updatedFiles = array(
            "title" => $_POST['title'],
            "description" => $_POST['description'],
        );

        $sql = "UPDATE files 
                SET title = :title, description = :description
                WHERE filesId = :filesId";

        $statement = $connection->prepare($sql);
        $statement->bindValue(':title', $updatedFiles['title'], PDO::PARAM_STR);
        $statement->bindValue(':description', $updatedFiles['description'], PDO::PARAM_STR);
        $statement->bindValue(':filesId', $filesId, PDO::PARAM_INT);
        $statement->execute();

        $updateSuccess = true; // Set the flag on successful update
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

if (isset($_GET["filesId"])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $filesId = $_GET["filesId"];
        $sql = "SELECT * FROM files WHERE filesId = :filesId";

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

<!DOCTYPE html>
<html>
<head>
    <title>Edit Files</title>
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

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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
        <h2>Edit Files</h2>

        <?php if ($files) : ?>
            <form method="post">
                <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
                <input name="filesId" type="hidden" value="<?php echo escape($files['filesId']); ?>">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="<?php echo escape($files['title']); ?>">
                <label for="description">Description</label>
                <input type="text" name="description" id="description" value="<?php echo escape($files['description']); ?>">
                <input type="submit" name="update" value="Update">
            </form>
            <?php if ($updateSuccess) : ?>
                <p>Files successfully updated.</p>
            <?php endif; ?>
        <?php else : ?>
            <p>No files found with that ID.</p>
        <?php endif; ?>

        <a href="filesView.php?filesId=<?php echo escape($files["filesId"]); ?>">Back to view</a>
        <a href="index.php">Back to home</a>
    </div>
</body>
</html>
