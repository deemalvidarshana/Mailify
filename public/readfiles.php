<?php
require "../config.php";
require "../common.php";

$result = [];

if (isset($_GET["search"])) {
    $search = '%' . $_GET["search"] . '%';
    $sql = "SELECT a.*, GROUP_CONCAT(m.sender) AS senders
            FROM files AS a
            INNER JOIN message_files AS ma ON a.filesId = ma.filesId
            INNER JOIN message AS m ON ma.id = m.id
            WHERE a.title LIKE :search
            GROUP BY a.filesId";
} else {
    $sql = "SELECT filesId, title, description, CreatedDate FROM files";
}

try {
    $connection = new PDO($dsn, $username, $password, $options);
    $statement = $connection->prepare($sql);

    if (isset($_GET["search"])) {
        $statement->bindParam(":search", $search, PDO::PARAM_STR);
    }

    $statement->execute();
    $result = $statement->fetchAll();
} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>

<?php require "templates/header.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>View Files</title>
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
            margin: 10px 0;
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

        table td a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        table td a:hover {
            color: #0056b3;
        }

        label {
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        a:hover {
            color: #0056b3;
        }

        h4 {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>View Files</h2>

        <!-- Search form -->
        <form method="GET">
            <label for="search">Search by Title:</label>
            <input type="text" name="search" id="search" placeholder="Enter a title">
            <input type="submit" value="Search">
        </form>

        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Description</th>
                    <?php if (isset($_GET["search"])) : ?>
                        <th>From</th>
                    <?php endif; ?>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($result)) : ?>
                <?php foreach ($result as $row) : ?>
                    <tr>
                        <td><?php echo escape($row["filesId"]); ?></td>
                        <td><?php echo escape($row["title"]); ?></td>
                        <td><?php echo escape($row["description"]); ?></td>
                        <?php if (isset($_GET["search"])) : ?>
                            <td><?php echo isset($row["senders"]) ? escape($row["senders"]) : ''; ?></td>
                        <?php endif; ?>
                        <td><?php echo escape($row["CreatedDate"]); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5">No records found</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
        <a href="createfiles.php"><h4>Create Files</h4></a>
        <a href="index.php">Back to Home</a>
    </div>
</body>
</html>

<?php require "templates/footer.php"; ?>
