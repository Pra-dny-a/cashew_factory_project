<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_message = $conn->prepare("SELECT * FROM `message` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if($select_message->rowCount() > 0){
      $message[] = 'already sent message!';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `message`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);

      $message[] = 'sent message successfully!';

   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>


       <!-- Bootstrap 5 CDN -->
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

   <!-- custom css file link  -->

   <link rel="stylesheet" href="css/contact.css">

</head>
<body>


<?php include 'header.php'; ?>


 <!-- banner Section start -->
 <section class="banner_section">
       
            <div class="banner-content">
                <h1><b>Contact Us</b></h1>

            </div>

           
    </section>
    <!-- banner section exit -->
    
    <div class="container">
      <span class="big-circle"></span>
      <img src="images/shape.png" class="square" alt="" />
      <div class="form">
        <div class="contact-info">
          <h3 class="title">Let's get in touch</h3>
          <p class="text">
           "Contact Us:Your Gateway to Cashew Ecxellence!"
          </p>

          <div class="info">
            <div class="information">
              <img src="images/location.png" class="icon" alt="" />
              <p>A/P Khed Bk (Lonand Khandala Road) Tal. Khandala Dist. Satara, 415521</p>
            </div>
            <div class="information">
              <img src="images/email.png" class="icon" alt="" />
              <p> supercashew802@gmail.com </p>
            </div>
            <div class="information">
              <img src="images/phone.png" class="icon" alt="" />
              <p>9158233042</p>
            </div>
          </div>

          <div class="social-media">
            <p>Connect with us :</p>
            <div class="social-icons">
             <!-- <a href="#">
                <i class="fab fa-facebook-f"></i>
              </a>-->
              <!--<a href="#">
                <i class="fab fa-twitter"></i>
              </a>-->
              <a href="tel:1-800-CASHEW(9158233042)"><i class="fab fa-whatsapp"></i> whatsapp</a>
              <a href="https://www.instagram.com/supercashew_">
                <i class="fab fa-instagram"></i>
              </a>
             <!-- <a href="#">
                <i class="fab fa-linkedin-in"></i>
              </a>-->
            </div>
          </div>
        </div>

        <div class="contact-form">
          <span class="circle one"></span>
          <span class="circle two"></span>

          <form action="" method="POST">
            <h3 class="title">Contact us</h3>
            <div class="input-container">
              <input type="text" name="name" class="input" placeholder="Name" required=""/>
              <label for=""></label>
              <span>Username</span>
            </div>
            <div class="input-container">
              <input type="email" name="email" class="input" placeholder="Email" required=""/>
              <label for=""></label>
              <span>Email</span>
            </div>
            <div class="input-container">
              <input type="tel" name="number" class="input" placeholder="Phone" required=""/>
              <label for=""></label>
              <span>Phone</span>
            </div>
            <div class="input-container textarea">
              <textarea name="msg" class="input" placeholder="Message"></textarea>
              <label for=""></label>
              <span>Message</span>
            </div>
            <input type="submit" value="Send" class="button" name="send"/>
          </form>
        </div>
      </div>
    </div>





 


    <?php include 'footer.php'; ?>




<script src="app.js"></script>
<script src="js/script.js"></script>

</body>
</html>