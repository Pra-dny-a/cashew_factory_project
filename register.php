<?php

include 'config.php';

if(isset($_POST['submit'])) {

   $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
   $pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
   $cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);
   $verify_token = md5(rand());

   $image = filter_var($_FILES['image']['name'], FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select->execute([$email]);

   if($select->rowCount() > 0) {
      $message[] = 'User email already exists!';
   } else {
      if($pass != $cpass) {
         $message[] = 'Confirm password not matched!';
      } else {
         $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

         $insert = $conn->prepare("INSERT INTO `users`(name, email, password, image, verify_token) VALUES(?,?,?,?,?)");
         $insert->execute([$name, $email, $hashed_password, $image, $verify_token]);

         if($insert) {
            if($image_size > 2000000) {
               $message[] = 'Image size is too large!';
            } else {
               move_uploaded_file($image_tmp_name, $image_folder);
               $message[] = 'Registered successfully!';
               header('Location: login.php');
               exit(); // Ensure no further code is executed
            }
         } else {
            $message[] = 'Registration failed!';
         }
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/components.css">

</head>
<body>

<?php
if(isset($message)) {
   foreach($message as $msg) {
      echo '
      <div class="message">
         <span>'.$msg.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<section class="form-container">
   <form action="" enctype="multipart/form-data" method="POST">
      <h3>Register Now</h3>
      <input type="text" name="name" class="box" placeholder="Enter Your Name" required>
      <input type="email" name="email" class="box" placeholder="Enter Your Email" required>
      <input type="password" name="pass" class="box" placeholder="Enter Your Password" required>
      <input type="password" name="cpass" class="box" placeholder="Confirm Your Password" required>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="Register Now" class="btn" name="submit">
      <p>Already have an account? <a href="login.php">Login now</a></p>
   </form>
</section>

</body>
</html>
