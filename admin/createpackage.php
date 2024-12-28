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
   $nstarter = $_POST['nstarter'];
   $nstarter = filter_var($nstarter, FILTER_SANITIZE_STRING);
   $nmain = $_POST['nmain'];
   $nmain = filter_var($nmain, FILTER_SANITIZE_STRING);
   $ndess = $_POST['ndess'];
  
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $starter = isset($_POST['Starter']) ? $_POST['Starter'] : [];
$starter1 = implode(",", $starter);

$MainCourse = isset($_POST['Course']) ? $_POST['Course'] : [];
$MainCourse1 = implode(",", $MainCourse);

$Dessert = isset($_POST['Dessert']) ? $_POST['Dessert'] : [];
$Dessert1 = implode(",", $Dessert);

$select_products = $conn->prepare("SELECT * FROM `package` WHERE Package_Name = ?");
$select_products->execute([$name]);

if($select_products->rowCount() > 0){
   $message[] = 'Package name already exists!';
}else{
         $insert_product = $conn->prepare("INSERT INTO `package`(`Package_Name`, `starter_Name`, `MainCourse_Name`, `Dessert_Name`, `number_of_starter`, `number_of_MainCourse`, `number_of_Dessert`, `price`) VALUES(?,?,?,?,?,?,?,?)");
         $insert_product->execute([$name,$starter1,$MainCourse1, $Dessert1,$nstarter,$nmain, $ndess,$price]);

         $message[] = 'Package added successfully ';
      }
   }
  

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product = $conn->prepare("DELETE FROM `package` WHERE Package_ID = ?");
   $delete_product->execute([$delete_id]);
   header('location:createpackage.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>create package</title>
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
      <h3>Add Package</h3>
      <h1 style="text-align:left;">Package name</h1>
      <input type="text" required placeholder="Enter package name" name="name" maxlength="100" class="box">
      <h1 style="text-align:left;">Number of starter items</h1>
      <input type="text" required placeholder="Enter number of starter" name="nstarter" maxlength="100" class="box">
      <h1 style="text-align:left;">Number of Main Course items</h1>
      <input type="text" required placeholder="Enter number of MainCourse " name="nmain" maxlength="100" class="box">
      <h1 style="text-align:left;"> Number of Dessert items</h1>
      <input type="text" required placeholder="Enter number of Dessert " name="ndess" maxlength="100" class="box">
      <h1 style="text-align:left;"> Select items from Starter, Main Course, and Dessert category</h1>
      <div style="text-align:left;" class="box">
      <B>Starter</B><br>
                        <?php
                            

                            $stat = $conn->prepare( "SELECT * FROM item where categories='Starter'");
                            $stat->execute();
                            if($stat->rowCount() > 0){
                            
                                foreach($stat as $brand)
                                {
                                    ?>
                                    <input type="checkbox" name="Starter[]" onclick="validate()" value="<?= $brand['Name']; ?>"  /> <?= $brand['Name']; ?> <br/>
                                    <?php
                                }
                            }
                            else
                            {
                                echo "No Record Found";
                            }
                        ?>
                        <script>
        function validate() {
            var checkboxes = document.getElementsByName('starter[]');
            var checkedCheckboxes = 0;

            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    checkedCheckboxes++;
                }
            }

            if (checkedCheckboxes === 1) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (!checkboxes[i].checked) {
                        checkboxes[i].required = true;
                    }
                }
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    checkboxes[i].required = true;
                }
            }
        }
    </script>
                        <br><B>Main Course</B><BR>
                        
                        <?php
                            

                            $main = $conn->prepare( "SELECT * FROM item where categories='Main Course'");
                            $main->execute();
                            if($main->rowCount() > 0){
                                foreach($main as $brand1)
                                {
                                    ?>
                                    <input type="checkbox" name="Course[]" value="<?= $brand1['Name']; ?>" /> <?= $brand1['Name']; ?> <br/>
                                    <?php
                                }
                            }
                            else
                            {
                                echo "No Record Found";
                            }
                        ?>
                        <br><B>Dessert</B><BR>
                        
                        <?php
                            

                            $dess = $conn->prepare( "SELECT * FROM item where categories='Dessert'");
                            $dess->execute();
                            if($dess->rowCount() > 0){
                                foreach($dess as $brand3){
                                    ?>
                                    <input type="checkbox" name="Dessert[]" value="<?= $brand3['Name']; ?>" /> <?= $brand3['Name']; ?> <br/>
                                    <?php
                                }
                            }
                            else
                            {
                                echo "No Record Found";
                            }
                        ?>
</div>

      <h1 style="text-align:left;">Package Price</h1>
      <input type="number" min="0" max="9999999999" required placeholder="Enter Total Price" name="price" onkeypress="if(this.value.length == 10) return false;" class="box">
     
      <input type="submit" value="Add  Package" name="add_product" class="btn">
   </form>

</section>

<!-- add products section ends -->

<!-- show products section starts  -->

<section class="show-products" style="padding-top: 0;">

   <div class="box-container">

   <?php
      $show_products = $conn->prepare("SELECT * FROM `package`");
      $show_products->execute();
      if($show_products->rowCount() > 0){
         while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      
      <div class="flex">
         <div class="price"><span>₹</span><?= $fetch_products['price']; ?><span>/-</span></div>
         
      </div>
      <div class="name"><b>Package ID:</b> <?= $fetch_products['Package_ID']; ?></div>
      <div class="name"><b>Package Name:</b> <?= $fetch_products['Package_Name']; ?></div>
      <div class="name"><b>Number of starter :</b> <?= $fetch_products['number_of_starter']; ?></div>
      <div class="name"><b>Number of MainCourse: </b><?= $fetch_products['number_of_MainCourse']; ?></div>
      <div class="name"><b>Number of Dessert: </b><?= $fetch_products['number_of_Dessert']; ?></div>
      <div class="name"><b>Starter Name: </b><?= $fetch_products['starter_Name']; ?></div>
      <div class="name"><b>MainCourse Name: </b><?= $fetch_products['MainCourse_Name']; ?></div>
      <div class="name"><b>Dessert Name: </b><?= $fetch_products['Dessert_Name']; ?></div>
      
     
      <div class="flex-btn">
         <a href="createpackage.php?delete=<?= $fetch_products['Package_ID']; ?>" class="delete-btn" onclick="return confirm('Delete this Package?');">delete</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">No Package added yet!</p>';
      }
   ?>

   </div>

</section>

<!-- show products section ends -->










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>