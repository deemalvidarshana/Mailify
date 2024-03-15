<?php
require "../config.php";
require "../common.php";

if (isset($_GET["id"])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $id = $_GET["id"];
        $sql = "SELECT * FROM message WHERE id = :id";

        $statement = $connection->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->execute();

        $message = $statement->fetch();
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} else {
    echo "No message ID specified.";
}
?>

<?php require "templates/header.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>View Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 800px;
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
            font-size: 18px;
        }

        a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        a:hover {
            color: #0056b3;
        }

        strong {
            font-weight: bold;
        }

        .edit-link {
            display: inline-block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>View Message</h2>

        <?php if ($message) : ?>
            <p><strong>Id:</strong> <?php echo escape($message["id"]); ?></p>
            <p><strong>Sender Email:</strong> <?php echo escape($message["sender"]); ?></p>
            <p><strong>Receiver Email:</strong> <?php echo escape($message["reciver"]); ?></p>
            <p><strong>Message:</strong> <?php echo escape($message["email"]); ?></p>
            <p><strong>Sender Name:</strong> <?php echo escape($message["nameSender"]); ?></p>
            <p><strong>Receiver Name:</strong> <?php echo escape($message["nameReciver"]); ?></p>
            <p><strong>Date:</strong> <?php echo escape($message["date"]); ?></p>

            <a href="edit.php?id=<?php echo escape($message["id"]); ?>" class="edit-link">Edit</a>
        <?php else : ?>
            <p>No message found with that ID.</p>
        <?php endif; ?>

        <a href="index.php">Back to home</a>
    </div>
</body>
</html>

<?php require "templates/footer.php"; ?>
