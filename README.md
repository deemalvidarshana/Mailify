<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Email</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 20px;
        }
        .container {
            max-width: 600px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create New Email</h2>
        <form id="createEmailForm">
            <div class="form-group">
                <label for="toEmail">To:</label>
                <input type="email" class="form-control" id="toEmail" placeholder="Enter recipient's email" required>
            </div>
            <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" class="form-control" id="subject" placeholder="Email subject" required>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea class="form-control" id="message" rows="4" placeholder="Write your message here" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Email</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#createEmailForm').on('submit', function(e) {
                e.preventDefault();
                // Here you would typically grab the form data and send it to the server
                // For demonstration, we'll just log it to the console
                console.log({
                    toEmail: $('#toEmail').val(),
                    subject: $('#subject').val(),
                    message: $('#message').val()
                });
                alert('Email sent! (simulated for this example)');
            });
        });
    </script>
</body>
</html>
