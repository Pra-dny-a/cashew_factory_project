<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['add_to_wishlist'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

   $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
   $check_wishlist_numbers->execute([$p_name, $user_id]);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_wishlist_numbers->rowCount() > 0){
      $message[] = 'already added to wishlist!';
   }elseif($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{
      $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
      $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
      $message[] = 'added to wishlist!';
   }

}

if(isset($_POST['add_to_cart'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
   $p_qty = $_POST['p_qty'];
   $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{

      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$p_name, $user_id]);

      if($check_wishlist_numbers->rowCount() > 0){
         $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
         $delete_wishlist->execute([$p_name, $user_id]);
      }

      $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);
      $message[] = 'added to cart!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="home-bg">

   <section class="home">

      <div class="content">
       
     <!-- <div class="container">-->
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            
            <div class="carousel-inner">
                <div class="carousel-item active">
                <div class="carousel-caption">
                    <div class="banner-content">
                    <h1>SUPER CASHEW</h1>
                    <h2>100% Organic</h2>
                    <p><b>Fresh and Natural Cashew From Our Farm.</b></p>
                    <a href="about.php" class="btn">about us</a>
                </div>
                </div>
                
                </div>
                    </div>
    </div>
        </div>


   </section>
    

</div>

<section class="home-category">

   <h1 class="title">Our Best Products</h1><h3 style="text-align:center"><b><mark>Crack Open Happiness with Every Cashew Bite</mark></b></h3>
 

   <div class="box-container">

      <div class="box">
         <img src="images/perikaju.jfif" alt="">
         <h3>Peri-Peri Cashew</h3>
         <!--<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>-->
         <a href="shop.php" class="btn">shop</a>
      </div>

      <div class="box">
         <img src="images/saltedcashwe.jfif" alt="">
         <h3>Salted-Cashew</h3>
         <!--<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>-->
         <a href="shop.php" class="btn">shop</a>
      </div>

      <div class="box">
         <img src="images/chokaju.jfif" alt="">
         <h3>Chocalate-Cashew</h3>
         <!--<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>-->
         <a href="shop.php" class="btn">shop</a>
      </div>

      <div class="box">
         <img src="images/greenkaju.jfif" alt="">
         <h3>Green Chili-Cashew</h3>
         <!--<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>-->
         <a href="shop.php" class="btn">shop</a>
      </div>

   </div>

</section>

<section class="products">

   <h1 class="title">latest products</h1>
   <h3 style=text-align:center><mark>"New Nuts On The Block! Check Out Our Latest Cashew Goodies!"</mark></h3><br>

   <div class="box-container">
       
   <div class="box">
         <img src="images/honeykaju.jfif" alt="">
         <h3>Honey-Cashew</h3>
         <!--<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>-->
         <a href="shop.php" class="btn">shop</a>
      </div>
      
      <div class="box">
         <img src="images/kadipttakaju.jfif" alt="">
         <h3>Kaddiptta-Cashew</h3>
         <!--<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>-->
         <a href="shop.php" class="btn">shop</a>
      </div>
      
      <div class="box">
         <img src="images/manchuriyankaju.jfif" alt="">
         <h3>Manchurian-Cashew</h3>
         <!--<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>-->
         <a href="shop.php" class="btn">shop</a>
      </div>
      
      <div class="box">
         <img src="images/pudinakaju.jfif" alt="">
         <h3>Mint-Cashew</h3>
         <!--<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>-->
         <a href="shop.php" class="btn">shop</a>
      </div>
      
      <div class="box">
         <img src="images/barbekaju.jfif" alt="">
         <h3>Barbeque-Cashew</h3>
         <!--<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>-->
         <a href="shop.php" class="btn">shop</a>
      </div>
      
      <div class="box">
         <img src="images/roastedkaju.jfif" alt="">
         <h3>Roasted-Cashew</h3>
         <!--<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>-->
         <a href="shop.php" class="btn">shop</a>
      </div>
   

   </div>

</section>







<?php include 'footer.php'; ?>

<script src="script.js"></script>


</body>
</html>