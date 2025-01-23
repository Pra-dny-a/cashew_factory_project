<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$delete_id]);
   header('location:cart.php');
}

if(isset($_GET['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   header('location:cart.php');
}





if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $p_qty = $_POST['p_qty'];

   // Convert quantity to grams
   if (strpos($p_qty, 'kg') !== false) {
       $p_qty = floatval($p_qty) * 1000; // Convert kg to grams
   } else {
       $p_qty = floatval($p_qty); // Convert kg to grams
   }

   // Insert or update the quantity in the database
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$p_qty, $cart_id]);
   $message[] = 'cart quantity updated';
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="shopping-cart">

   <h1 class="title">products added</h1>

   <div class="box-container">

   <?php
      $grand_total = 0;
      $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart->execute([$user_id]);
      if($select_cart->rowCount() > 0){
         while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){ 
            $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'] / 1000; // Subtotal in dollars
            if (strpos($fetch_cart['quantity'], 'kg') !== false) {
               $p_qty = floatval($p_qty) * 1000; 
               
            }
            $grand_total += $sub_total; // Add to grand total
           
   
           
            
   ?>
   <form action="" method="POST" class="box">
      <a href="cart.php?delete=<?= $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
      <a href="view_page.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
      <div class="name"><?= $fetch_cart['name']; ?></div>
      <div class="price">₹<?= $fetch_cart['price']; ?>/-</div>
      <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
      <div class="flex-btn">
         <!-- Change input type to text -->
         <input type="text" value="<?= $fetch_cart['quantity'] / 1000; ?>" class="qty" name="p_qty" placeholder="Enter quantity in grams (e.g., 1 or 0.5)">

         <input type="submit" value="update" name="update_qty" class="option-btn">
      </div>
      <div class="sub-total"> sub total : <span>₹<?= $sub_total; ?>/-</span> </div>

   </form>
   <?php
      }
   }else{
      echo '<p class="empty">your cart is empty</p>';
   }
   ?>
   </div>

   <div class="cart-total">
      <p>grand total : <span>₹<?= $grand_total; ?>/-</span></p>
      <a href="shop.php" class="option-btn">continue shopping</a>
      <a href="cart.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>">delete all</a>
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
    
   </div>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
