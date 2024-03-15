<?php
require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT * 
                FROM message
                WHERE sender = :sender";

        $sender = $_POST['sender'];
        $statement = $connection->prepare($sql);
        $statement->bindParam(':sender', $sender, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php require "templates/header.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Messages by Sender</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        table tbody tr:nth-child(2n) {
            background-color: #f2f2f2;
        }

        blockquote {
            margin: 10px 0;
            font-style: italic;
            color: #888;
        }
    </style>
</head>
<body>
<div class="container">
    <?php if (isset($_POST['submit'])) : ?>
        <?php if ($result && $statement->rowCount() > 0) : ?>
            <h2>Results</h2>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Sender Email</th>
                        <th>Receiver Email</th>
                        <th>Mail Message</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $row) : ?>
                        <tr>
                            <td><?php echo escape($row["id"]); ?></td>
                            <td><?php echo escape($row["sender"]); ?></td>
                            <td><?php echo escape($row["reciver"]); ?></td>
                            <td><?php echo escape($row["email"]); ?></td>
                            <td><?php echo escape($row["date"]); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <blockquote>No results found for <?php echo escape($_POST['sender']); ?>.</blockquote>
        <?php endif; ?>
    <?php endif; ?>

    <h2>Find user based on sender</h2>

    <form method="post">
        <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
        <label for="sender">Sender Email Address</label>
        <input type="text" id="sender" name="sender">
        <input type="submit" name="submit" value="View Results">
    </form>

    <a href="index.php">Back to home</a>
</div>
</body>
</html>

<?php require "templates/footer.php"; ?>
