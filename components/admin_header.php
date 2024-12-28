<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '
        <div class="message">
            <span>' . $msg . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}

// Make sure $admin_id is defined before using it in the query
 // Replace this with the actual value or logic to get the admin_id

?>

<header class="header">

    <section class="flex">

        <a href="dashboard.php" class="logo">Pereira Sea Caterers<br><span>AdminPanel</span></a>

        <nav class="navbar">
            <a href="dashboard.php">Home</a>
            <a href="uploaditems.php"> Menu items</a>
            <a href="placed_orders.php">Orders</a>
            <a href="admin_accounts.php">Admins</a>
            <a href="users_accounts.php">Users</a>
            <a href="messages.php">Messages</a>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>

        <div class="profile">
            <?php
            $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            // Check if the query was successful before fetching data
            if ($fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <p><?= $fetch_profile['name']; ?></p>
                <a href="update_profile.php" class="btn">Update profile</a>
            <?php
            } else {
                // Handle the case where no admin with the specified id was found
                echo "Admin not found";
            }
            ?>
            
            <a href="../components/admin_logout.php" onclick="return confirm('logout from this website?');"
                class="btn">Logout</a>
        </div>

    </section>

</header>