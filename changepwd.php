<?php
@include 'config.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['email'], $_POST['new_pass'], $_POST['confirm_pass'])) {
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $new_pass = $_POST['new_pass'];
        $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
        $confirm_pass = $_POST['confirm_pass'];
        $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

        if ($new_pass === $confirm_pass) {
            $hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);

            $update_pass_query = $conn->prepare("UPDATE `users` SET password = ? WHERE email = ?");
            $result = $update_pass_query->execute([$hashed_password, $email]);
            
            if ($result) {
                echo 'Password updated successfully!';
            } else {
                echo 'Error updating password.';
            }
        } else {
            echo 'New passwords do not match.';
        }
    } else {
        echo 'All fields are required.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: rgb(173,216,230);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="email"], input[type="password"], input[type="submit"], button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Change Password</h2>
        <form id="changePasswordForm" method="POST">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <label for="newPassword">New Password</label>
            <input type="password" id="newPassword" name="new_pass" required>
            <label for="confirmPassword">Confirm New Password</label>
            <input type="password" id="confirmPassword" name="confirm_pass" required>
            <input type="submit" value="Change Password">
            
        </form>
        <button onclick="window.location.href='login.php'">Login</button>
    </div>
</body>
</html>







