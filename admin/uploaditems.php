<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $Description = $_POST['Description'];
   $Description = filter_var($Description, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;

   $select_products = $conn->prepare("SELECT * FROM `item` WHERE name = ?");
   $select_products->execute([$name]);

   if($select_products->rowCount() > 0){
      $message[] = 'menu item name already exists!';
   }else{
      if($image_size > 2000000){
         $message[] = 'image size is too large';
      }else{
         if (!file_exists('../uploaded_img/')) {
            mkdir('../uploaded_img/', 0777, true);
        }
        
        move_uploaded_file($image_tmp_name, $image_folder);
       

         $insert_product = $conn->prepare("INSERT INTO `item`(name, categories,Description,image) VALUES(?,?,?,?)");
         $insert_product->execute([$name, $category, $Description, $image]);

         $message[] = 'New menu item added!';
      }

   }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `item` WHERE item_id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_image['image']);
   $delete_product = $conn->prepare("DELETE FROM `item` WHERE item_id = ?");
   $delete_product->execute([$delete_id]);

   header('location:uploaditems.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>menu items</title>
   <link rel="icon" type="image/x-icon" href="logo.png">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- add products section starts  -->

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Add menu items</h3>
      <h1 style="text-align:left;">Name of menu item</h1>
      <input type="text" required placeholder="Enter menu item name" name="name" maxlength="100" class="box">
      <h1 style="text-align:left;">Description</h1>
      <input type="text" required placeholder="enter Description name" name="Description" maxlength="100" class="box">
      <h1 style="text-align:left;">Category</h1>
      <select name="category" class="box" required>
         <option value="" disabled selected>Select Category --</option>
         <option value="Starter">Starter</option>
         <option value="Main Course">Main Course</option>
         <option value="Dessert">Dessert</option>
      </select>
      
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      <input type="submit" value="add " name="add_product" class="option-btn">
   </form>

</section>

<!-- add products section ends -->

<!-- show products section starts  -->

<section class="show-products" style="padding-top: 0;">

   <div class="box-container">

   <?php
      $show_products = $conn->prepare("SELECT * FROM `item`");
      $show_products->execute();
      if($show_products->rowCount() > 0){
         while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <br><div class="name">Item ID: <?= $fetch_products['item_id']; ?></div>
      <br><div class="name">Description: <?= $fetch_products['Description']; ?></div>
      <div class="name"> Category: <?= $fetch_products['categories']; ?></div>
      
      <div class="name">Name: <?= $fetch_products['Name']; ?></div>
      <div class="flex-btn">
         <a href="update_items.php?update=<?= $fetch_products['item_id']; ?>" class="option-btn">Update</a>
         <a href="uploaditems.php?delete=<?= $fetch_products['item_id']; ?>" class="option-btn" onclick="return confirm('Delete this Menu item?');">delete</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no menu item added yet!</p>';
      }
   ?>

   </div>

</section>

<!-- show products section ends -->










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>