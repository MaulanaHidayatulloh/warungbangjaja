<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="login.css" />
</head>
<body>
    <h2>Reset Password</h2>
    <form action="send_reset_email.php" method="post">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <input type="submit" value="Reset Password">
    </form>
</body>
</html>
