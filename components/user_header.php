<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header style="background-color: var(--yellow);"class="header">

   <section class="flex">

      <a href="home.php" class="logo"><p><img style="max-width: 600px;max-height: 600px;" src="images/logo1.png"> </p> </a>

      <nav class="navbar">
         <a href="home.php">Home</a>
         <a href="about.php">About</a>
         
         <a href="orders.php">Orders</a>
         <a href="contact.php">Contact</a>
      </nav>

      <div class="icons">
      
         <div id="user-btn" class="fas fa-user"> </div><?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>   <b><?= $fetch_profile['user_name']; }?></b>
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>

      <div class="profile">
      <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p class="name"><?= $fetch_profile['user_name']; ?></p>
         <div class="flex">
            <a href="profile.php" class="btn">Profile</a>
            <a href="components/user_logout.php" onclick="return confirm('logout from this website?');" class="btn">Logout</a>
         </div>
     
         <?php
            }else{
         ?>
            <p class="name">Please login first!</p>
            <p><a href="login.php" class="btn">Login</a> <br> 
            <a href="register.php" class="btn">Register</a></p>
         <?php
          }
         ?>
      </div>

   </section>

</header>

