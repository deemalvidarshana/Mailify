<?php
require "../config.php";
require "../common.php";

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT filesId, title, description, CreatedDate FROM files"; 

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Create File in Gmail</title>
    <style>
        /* Add your CSS styles here */
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

        .red-header {
            color: #FF0000;
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

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create File in Gmail</h2>
        <h3 class="red-header">Created Files</h3>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($result as $row) : ?>
                <tr>
                    <td><?php echo escape($row["filesId"]); ?></td>
                    <td><?php echo escape($row["title"]); ?></td>
                    <td><?php echo escape($row["description"]); ?></td>
                    <td><?php echo escape($row["CreatedDate"]); ?></td>
                    <td><a href="filesView.php?filesId=<?php echo escape($row["filesId"]); ?>">View</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <a href="createfiles.php" style="text-decoration: none;"><h3>Create files</h3></a>
        <a href="readfiles.php" style="text-decoration: none;"><h3>Read file</h3></a>
        <a href="index.php" style="text-decoration: none;">Back to home</a>
    </div>
</body>
</html>

<?php require "templates/footer.php"; ?>
