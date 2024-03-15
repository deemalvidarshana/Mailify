<?php include "templates/header.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Navigation Links</title>
    <style>
        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin: 10px 0;
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
    </style>
</head>
<body>
    <ul>
        <li><a href="createmessage.php">Create Email</a> - Add a new email</li>
        <li><a href="read.php">Read Emails</a> - Search by sender</li>
        <li><a href="home.php">Home</a> - Find all details</li>
        <li><a href="filesHome.php">File</a> - Create a file</li>
    </ul>
</body>
</html>

<?php include "templates/footer.php"; ?>
