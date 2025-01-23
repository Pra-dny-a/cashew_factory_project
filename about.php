<?php
@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">




   <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


</head>


<body>
<?php include 'header.php'; ?>


<!-- banner Section start -->
<section class="banner_section">
        
        <div class="banner-content">
            <h1><b>About Us</b></h1>
        </div> 
</section>
<!-- banner section exit -->



<!--About Section start -->
<section class="about_section">
        <div class="container">
                <div class="row justify-content-center">
                <div class="col-12 text-center pb-5">
                
                    <h2 class="section-title">Welcome to Super Cashew Factory</h2>
                    <p class="section-subtitle"><mark><b>Where Quality Meets convenience in Every Cashew</mark></b></p>
            </div>
                 
                </div>
            
            <div class="row align-items-center py-5">
                <div class="col-lg-6 col-12 mb-4">
                    <div class="me-lg-5">
                        <img src="./images/machin.jfif" alt="about" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-6 col-12 mb-4">
                    <div class="about-content">
                        <div class="about-details">
                            <p>Welcome to Super Cashew, your one-stop destination for premium quality cashews delivered right to your doorstep. We are passionate about providing you with the freshest and most delicious cashews sourced directly from the finest farms </p>
                            <p>At Super Cashew, we understand the importance of healthy snacking. That's why we are committed to offering you a wide range of cashew varieties, from classic roasted and salted cashews to exotic flavors like chili lime and honey roasted.</p>
                             <p>Our commitment to quality is unwavering. We work closely with our suppliers to ensure that every batch of cashews meets our rigorous standards. This dedication to quality has earned us the trust of our customers, who know that they can always count on Nutty Delights for fresh, flavorful cashews.</p>

                             <a href="shop.php" class="btn">our shop</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center py-5">
                <div class="col-lg-6 col-12 order-2 order-lg-1 mb-4 ">
                    <div class="about-content">
                        <div class="about-details">
                            <p>At Cashew Express, we take pride in offering unparalleled convenience, quality, and variety. Here's what makes us stand out:

                                <p><mark>Premium Quality:</mark> We meticulously source our cashews from the finest growers to ensure superior taste, texture, and freshness in every bite.</p>
                            <p><mark>Variety:</mark> From classic roasted and salted cashews to exotic flavored varieties, we offer a wide range of options to suit every palate and occasion.

                               <p> <mark>Freshness Guarantee:</mark> We are committed to delivering only the freshest cashews, carefully packaged to preserve their natural flavor and goodness.</p>
                                    
                               <a href="client.php" class="btn">Our Clients</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12 order-1 order-lg-2 mb-4">
                    <div class="me-lg-5">
                        <img src="./images/labour.jfif" alt="about" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--About Section Exit -->


 
    

    


    <?php include 'footer.php'; ?>



<script src="js/script.js"></script>

</body>
</html>