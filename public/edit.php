<?php
require "../config.php";
require "../common.php";

$updateSuccess = false;

if (isset($_POST['update'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $id = $_POST['id'];
        $updatedMessage = array(
            "sender" => $_POST['sender'],
            "reciver" => $_POST['reciver'],
            "email" => $_POST['email'],
            "nameSender" => $_POST['nameSender'],
            "nameReciver" => $_POST['nameReciver']
        );

        $sql = "UPDATE message 
                SET sender = :sender, reciver = :reciver, email = :email, 
                nameSender = :nameSender, nameReciver = :nameReciver
                WHERE id = :id";

        $statement = $connection->prepare($sql);
        $statement->bindValue(':sender', $updatedMessage['sender'], PDO::PARAM_STR);
        $statement->bindValue(':reciver', $updatedMessage['reciver'], PDO::PARAM_STR);
        $statement->bindValue(':email', $updatedMessage['email'], PDO::PARAM_STR);
        $statement->bindValue(':nameSender', $updatedMessage['nameSender'], PDO::PARAM_STR);
        $statement->bindValue(':nameReciver', $updatedMessage['nameReciver'], PDO::PARAM_STR);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $updateSuccess = true; // Set the flag on successful update
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

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

<!DOCTYPE html>
<html>
<head>
    <title>Edit Message</title>
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
    <h2>Edit Message</h2>

    <?php if ($message) : ?>
        <form method="post">
            <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
            <input name="id" type="hidden" value="<?php echo escape($message['id']); ?>">
            <label for="sender">Sender email</label>
            <input type="text" name="sender" id="sender" value="<?php echo escape($message['sender']); ?>">
            <label for="reciver">Receiver email</label>
            <input type="text" name "reciver" id="reciver" value="<?php echo escape($message['reciver']); ?>">
            <label for="email">Mail message</label>
            <input type="text" name="email" id="email" value="<?php echo escape($message['email']); ?>">
            <label for="nameSender">Sender Name</label>
            <input type="text" name="nameSender" id="nameSender" value="<?php echo escape($message['nameSender']); ?>">
            <label for="nameReciver">Receiver Name</label>
            <input type="text" name="nameReciver" id="nameReciver" value="<?php echo escape($message['nameReciver']); ?>">
            <input type="submit" name="update" value="Update">
        </form>
        <?php if ($updateSuccess) : ?>
            <p>Message successfully updated.</p>
        <?php endif; ?>
    <?php else : ?>
        <p>No message found with that ID.</p>
    <?php endif; ?>

    <a href="view.php?id=<?php echo escape($message["id"]); ?>">Back to view</a>
    <a href="index.php">Back to home</a>
</div>
</body>
</html>
