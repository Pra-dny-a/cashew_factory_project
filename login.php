<?php

include 'config.php';

session_start();

if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $password = $_POST['pass'];
    $password = filter_var($password, FILTER_SANITIZE_STRING);

    $sql = "SELECT * FROM `users` WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $rowCount = $stmt->rowCount();  
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Debugging information
    error_log("Email: " . $email);
    error_log("Password: " . $password);
    error_log("Row Count: " . $rowCount);
    if ($rowCount > 0) {
        error_log("Fetched Password: " . $row['password']);
    }

    if ($rowCount > 0) {
        if (password_verify($password, $row['password'])) {
            if ($row['user_type'] == 'admin') {
                $_SESSION['admin_id'] = $row['id'];
                header('location:admin_page.php');
            } elseif ($row['user_type'] == 'user') {
                $_SESSION['user_id'] = $row['id'];
                header('location:home.php');
            } else {
                $message[] = 'No user found!';
            }
        } else {
            $message[] = 'Incorrect email or password!';
        }
    } else {
        $message[] = 'Incorrect email or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/components.css">
</head>
<body>
<?php
if (isset($message)) {
    foreach ($message as $message) {
        echo '
        <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}
?>
<section class="form-container">
    <form action="" method="POST">
        <h3>Login Now</h3>
        <input type="email" name="email" class="box" placeholder="Enter Your Email" required>
        <input type="password" name="pass" class="box" placeholder="Enter Your Password" required>
        <input type="submit" value="Login Now" class="btn" name="submit">
        <p>Don't have an account? <a href="register.php">Register Now</a></p>
        <p>OOps!! Forgot Password <a href="changepwd.php">Click Me!!</a></p>
    </form>
</section>
</body>
</html>
