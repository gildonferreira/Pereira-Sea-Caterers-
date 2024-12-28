<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>
   <link rel="icon" type="image/x-icon" href="logo.png">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body >

<?php include '../components/admin_header.php' ?>

<!-- admin dashboard section starts  -->

<section style="background-color: var(--yellow);" class="dashboard">

   <h1 class="heading">Dashboard</h1>

   <div class="box-container">

   <div class="box">
      <h3>Welcome!</h3>
      <p><?= $fetch_profile['name']; ?></p>
      <a href="update_profile.php" class="btn">Update profile</a>
   </div>


   <div class="box">
      <?php
         $select_products = $conn->prepare("SELECT * FROM `item`");
         $select_products->execute();
         $numbers_of_products = $select_products->rowCount();
      ?>
      <h1>Number of menu items:</h1><h3><?= $numbers_of_products; ?></h3>
      <p>Menu Items</p>
      <a href="uploaditems.php" class="btn">Add Menu Items</a>
   </div>
   <div class="box">
      <?php
         $select_products = $conn->prepare("SELECT * FROM `package`");
         $select_products->execute();
         $numbers_of_products = $select_products->rowCount();
      ?>
      <h1>Number of package:</h1><h3><?= $numbers_of_products; ?></h3>
      <p>Create Package</p>
      <a href="createpackage.php" class="btn">Create Package</a>
   </div>
   <div class="box">
      <?php
         $select_users = $conn->prepare("SELECT * FROM `users`");
         $select_users->execute();
         $numbers_of_users = $select_users->rowCount();
      ?>
      <h1>Number of users:</h1><h3><?= $numbers_of_users; ?></h3>
      <p>Users Accounts</p>
      <a href="users_accounts.php" class="btn">Check Users</a>
   </div>
   <div class="box">
      <?php
         $select_orders = $conn->prepare("SELECT * FROM `orders`");
         $select_orders->execute();
         $numbers_of_orders = $select_orders->rowCount();
      ?>
      <h1>Number of orders:</h1><h3><?= $numbers_of_orders; ?></h3>
      <p>Total Orders</p>
      <a href="placed_orders.php" class="btn">Check Orders</a>
   </div>

   <div class="box">
      <?php
         $select_admins = $conn->prepare("SELECT * FROM `admin`");
         $select_admins->execute();
         $numbers_of_admins = $select_admins->rowCount();
      ?>
      <h1>Number of Admins:</h1><h3><?= $numbers_of_admins; ?></h3>
      <p>Admins</p>
      <a href="admin_accounts.php" class="btn">Check Admins</a>
   </div>
   <div class="box">
      <?php
         $select_messages = $conn->prepare("SELECT * FROM `messages`");
         $select_messages->execute();
         $numbers_of_messages = $select_messages->rowCount();
      ?>
      <h1>Number of messages:</h1><h3><?= $numbers_of_messages; ?></h3>
      <p>New Messages</p>
      <a href="messages.php" class="btn">Check Messages</a>
   </div>
   

   </div>

</section>

<!-- admin dashboard section ends -->









<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>