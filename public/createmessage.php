<?php

/**
 * Use an HTML form to create a new entry in the
 * createmessage table.
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

    try  {
        $connection = new PDO($dsn, $username, $password, $options);

        $new_user = array(
            "sender" => $_POST['sender'],
            "reciver"  => $_POST['reciver'],
            "email"     => $_POST['email'],
            "nameSender" => $_POST['nameSender'],
            "nameReciver" => $_POST['nameReciver']
        );

        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "message",
            implode(", ", array_keys($new_user)),
            ":" . implode(", :", array_keys($new_user))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create a New Message</title>
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
        <h2>Create a New Message</h2>

        <form method="post">
            <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
            <label for="sender">Sender Email Address</label>
            <input type="text" name="sender" id="sender">
            <label for="reciver">Receiver Email Address</label>
            <input type="text" name="reciver" id="reciver">
            <label for="email">Mail Message</label>
            <input type="text" name="email" id="email">
            <label for="nameSender">Sender Name</label>
            <input type="text" name="nameSender" id="nameSender">
            <label for="nameReciver">Receiver Name</label>
            <input type="text" name="nameReciver" id="nameReciver">
            <input type="submit" name="submit" value="Submit">
        </form>

        <a href="index.php">Back to home</a>

        <?php if (isset($_POST['submit']) && $statement) : ?>
            <blockquote><?php echo escape($_POST['sender']); ?> successfully added.</blockquote>
        <?php endif; ?>
    </div>
</body>
</html>
