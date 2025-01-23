<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = 'flat no. '. $_POST['flat'] .' '. $_POST['city'] .' '. $_POST['state'] .' - '. $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $cart_query->execute([$user_id]);
   if($cart_query->rowCount() > 0){
      while($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)){
         $cart_products[] = $cart_item['name'].' ( '.$cart_item['quantity'].'g )'; // Display grams
         $sub_total = ($cart_item['price'] * $cart_item['quantity'] / 1000); // Convert grams to kilograms
         $cart_total += $sub_total;
      };
   };

   $total_products = implode(', ', $cart_products);

   $order_query = $conn->prepare("SELECT * FROM `orders` WHERE name = ? AND number = ? AND email = ? AND method = ? AND address = ? AND total_products = ? AND total_price = ?");
   $order_query->execute([$name, $number, $email, $method, $address, $total_products, $cart_total]);

   if($cart_total == 0){
      $message[] = 'your cart is empty';
   }elseif($order_query->rowCount() > 0){
      $message[] = 'order placed already!';
   }else{
      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES(?,?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $cart_total, $placed_on]);
      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);
      $message[] = 'order placed successfully!';
   }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   
   <style>
      /* Styles for the modal */
      .modal {
         display: none;
         position: fixed;
         z-index: 1000;
         left: 0;
         top: 0;
         width: 100%;
         height: 100%;
         overflow: auto;
         background-color: rgba(0, 0, 0, 0.4);
      }
      .modal-content {
         background-color: #fefefe;
         margin: 15% auto;
         padding: 20px;
         border: 1px solid #888;
         width: 80%;
         max-width: 600px;
         text-align: center;
      }
      .close {
         color: #aaa;
         float: right;
         font-size: 28px;
         font-weight: bold;
      }
      .close:hover,
      .close:focus {
         color: black;
         text-decoration: none;
         cursor: pointer;
      }
      /* Style for QR code image */
      .qr-code-img {
         max-width: 100px; /* Adjust the size as needed */
         margin-bottom: 20px;
      }
     
      .payment-icons {
            text-align: center; /* Align center */
        }

        .payment-icons img {
            width: 50px;
            margin: 10px;
            display: inline-block; /* Display as inline-block */
        }
   </style>

</head>
<body>

<?php include 'header.php'; ?>

<section class="display-orders">

   <?php
      $cart_grand_total = 0;
      $select_cart_items = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
      $select_cart_items->execute([$user_id]);
      if($select_cart_items->rowCount() > 0){
         while($fetch_cart_items = $select_cart_items->fetch(PDO::FETCH_ASSOC)){
            $cart_total_price = ($fetch_cart_items['price'] * $fetch_cart_items['quantity'] / 1000); // Convert grams to kilograms
            $cart_grand_total += $cart_total_price;
   ?>
   <p> <?= $fetch_cart_items['name']; ?> <span>(<?= '₹'.$fetch_cart_items['price'].'/- x '. $fetch_cart_items['quantity'].'g'; ?>)</span> </p> <!-- Display grams -->
   <?php
    }
   }else{
      echo '<p class="empty">your cart is empty!</p>';
   }
   ?>
   <div class="grand-total">Grand Total : <span>₹<?= $cart_grand_total; ?>/-</span></div> <!-- Display grams -->
</section>

<section class="checkout-orders">

   <form action="" method="POST">

      <h3>place your order</h3>

      <div class="flex">
         <div class="inputBox">
            <span> Name :</span>
            <input type="text" name="name" placeholder="Enter Your Name" class="box" required>
         </div>
         <div class="inputBox">
            <span> Number :</span>
            <input type="number" name="number" placeholder="Enter Your Number" class="box" required>
         </div>
         <div class="inputBox">
            <span> Email :</span>
            <input type="email" name="email" placeholder="Enter Your Email" class="box" required>
         </div>
         <div class="inputBox">
            <span>Payment Method :</span>
            <select name="method" id="paymentMethod" class="box" required>
               <option value="cash on delivery">Cash On Delivery</option>
               <option value="qrcode">QR code</option>
               <!--<option value="paytm">paytm</option>
               <option value="paypal">paypal</option>-->
            </select>
         </div>
         <div class="inputBox">
            <span>Address Line 01 :</span>
            <input type="text" name="flat" placeholder="e.g. flat number" class="box" required>
         </div>
         <div class="inputBox">
            <span>City :</span>
            <input type="text" name="city" placeholder="e.g. mumbai" class="box" required>
         </div>
         <div class="inputBox">
            <span>State :</span>
            <input type="text" name="state" placeholder="e.g. maharashtra" class="box" required>
         </div>
         <div class="inputBox">
            <span>Pin Code :</span>
            <input type="number" min="0" name="pin_code" placeholder="e.g. 123456" class="box" required>
         </div>
      </div>

      <input type="submit" name="order" class="btn <?= ($cart_grand_total > 0.25)?'':'disabled'; ?>" value="place order">

   </form>

</section>

<!-- Modal for displaying QR code -->
<div id="qrModal" class="modal">
   <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <h3>Scan QR Code Using Your Preferred UPI App</h3><br>
      <img src="images/qr-code.jpeg" alt="QR Code" class="qr-code-img">
      <div class="payment-icons">
      <img src="images/gpay.jpeg" alt="Google Pay">
       <img src="images/phonepay.jpeg" alt="PhonePe">
       <img src="images/paytm.jpeg" alt="Paytm">
      </div>
   </div>
</div>

<script>
   // Function to display modal
   function openModal() {
      document.getElementById('qrModal').style.display = 'block';
   }

   // Function to close modal
   function closeModal() {
      document.getElementById('qrModal').style.display = 'none';
   }

   // Event listener for payment method selection
   document.getElementById('paymentMethod').addEventListener('change', function() {
      if (this.value === 'qrcode') {
         openModal();
      } else {
         closeModal();
      }
   });
</script>

<?php include 'footer.php'; ?>
</body>
</html>
