<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};



if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE payid = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>placed orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- placed orders section starts  -->

<section class="placed-orders">

   <h1 class="heading">placed orders</h1>

   <div class="box-container">

   <?php
      $select_orders = $conn->prepare("SELECT * FROM `orders`");
      $select_orders->execute();
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box" style="font-color:#000000;">
      <p> User id : <span class="name"><?= $fetch_orders['user_id']; ?></span> </p>
      <p>User name : <span class="name"><?= $fetch_orders['name']; ?></span></p>
      <p>Placed on : <span class="name"><?= $fetch_orders['payment_date']; ?></span></p>
      <p>Transaction ID: <span class="name"><?= $fetch_orders['txnid']; ?></span></p>
      <p>Amount : <span class="name">Rs <?= $fetch_orders['amount']; ?>/-</span></p>
    
      <p>Email : <span class="name"><?= $fetch_orders['payer_email']; ?></span></p>
      <p>Number : <span class="name"><?= $fetch_orders['mobile']; ?></span></p>
      <p>Address : <span class="name"><?= $fetch_orders['address']; ?></span></p>
      <p>Package Name : <span class="name"><?= $fetch_orders['package_name']; ?></span></p>
      <p>Starter Name : <span class="name"><?= $fetch_orders['starter_Name']; ?></span></p>
      <p>Main Course Name : <span class="name"><?= $fetch_orders['MainCourse_Name']; ?></span></p>
      <p>Dessert Name : <span class="name"><?= $fetch_orders['Dessert_Name']; ?></span></p>
      <p>Quantity : <span class="name"><?= $fetch_orders['total_item']; ?></span></p>
      <p>Delivery Address : <span><?= $fetch_orders['venue']; ?></span></p>
      <p>Delivery date : <span class="name"><?= $fetch_orders['deliver_date']; ?></span></p>
      <p>Delivery time : <span><?= $fetch_orders['deliver_time']; ?></span></p>
      <p> Payment status : <span style="color:<?php if($fetch_orders['status'] == 'fire'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['status']; ?></span> </p>
      <form action="" method="POST">
         <input type="hidden" name="order_id" value="<?= $fetch_orders['payid']; ?>">
        
            
         </select>
         <div class="flex-btn">
            
            <a href="placed_orders.php?delete=<?= $fetch_orders['payid']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">delete</a>
         </div>
      </form>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">no orders placed yet!</p>';
   }
   ?>

   </div>

</section>

<!-- placed orders section ends -->









<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>