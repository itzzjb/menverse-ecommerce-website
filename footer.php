<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
</head>
<body>


<!-- bottom nav---------------------------------------- -->
   
<nav class="bottom-navbar">

 

<a href="index.php" class="fa-solid fa-house"></a>
<a href="index.php#arrivals" class="fa-solid fa-list-ul"></a>
<a href="index.php#collections" class="fa-solid fa-tag"></a>
<a href="index.php#blogs" class="fa-solid fa-tag"></a>
<?php

if(isset($_SESSION['user_id'])){
        echo '<a href="orders.php" class="fa-brands fa-database"></a>';

        $choose=mysqli_query($conn,"SELECT *FROM user_info WHERE uId='$id'");
        $row=mysqli_fetch_assoc($choose);

        $u=$row['email'];
        $p= $row['epassword'];

        $take=mysqli_query($conn,"SELECT *FROM normal_admin WHERE email='$u' and password='$p'");
        if(mysqli_num_rows($take)>0){
            echo'<a href="admin.php" class="fas fa-user-shield"></a>';  
    
        } 
                   
    }
        ?>

</nav>

    
    

     <!-- -----------------------------footer---------------------- -->
     <hr>
<section class="footer">

<div class="box-container">

    <div class="box">
        <h3>Our Locations</h3>
        <a href="#" ><i class="fa-solid fa-location-dot"></i>Colombo</a>
        <a href="#"><i class="fa-solid fa-location-dot"></i>Kelaniya</a>
        <a href="#"><i class="fa-solid fa-location-dot"></i>Wattala</a>
         
    </div>

    <div class="box">
        <h3>Quick Links</h3>
        <a href="index.php"><i class="fa-solid fa-arrow-right"></i>Home</a>
        <a href="index.php#arrivals"><i class="fa-solid fa-arrow-right"></i>New Arrivals</a>
        <a href="index.php#collections"><i class="fa-solid fa-arrow-right"></i>Collections</a>
        <a href="index.php#blogs"><i class="fa-solid fa-arrow-right"></i>Upcoming</a> 
        <?php
        echo'<a href="orders.php"><i class="fa-solid fa-arrow-right"></i>My Orders</a>';
        if(isset($_SESSION['user_id'])){
        $choose=mysqli_query($conn,"SELECT *FROM user_info WHERE uId='$id'");
        $row=mysqli_fetch_assoc($choose);

        $u=$row['email'];
        $p= $row['epassword'];

        $take=mysqli_query($conn,"SELECT *FROM normal_admin WHERE email='$u' and password='$p'");
        if(mysqli_num_rows($take)>0){
            echo'<a href="admin.php"><i class="fa-solid fa-arrow-right"></i>Admin Panel</a>';  
        } 
                   
    }
        ?>
    </div>

    <div class="box">
        <h3>Extra Links</h3>
        <a href="#"><i class="fa-solid fa-arrow-right"></i>Account info</a>
        <a href="#"><i class="fa-solid fa-arrow-right"></i>Order Items</a>
        <a href="#"><i class="fa-solid fa-arrow-right"></i>Payment Methods</a>
        <a href="#"><i class="fa-solid fa-arrow-right"></i>Privacy Policy</a>
        <a href="#"><i class="fa-solid fa-arrow-right"></i>Our Services</a> 
    </div>

    <div class="box">
        <h3>Contact Info</h3>
         
        <a href="tel:+94777772229"><i class="fa-solid fa-phone"></i>+94777772229</a>
        <a href="mailto:support@menverse.com" style="text-transform:lowercase"><i class="fa-solid fa-envelope"></i>support@menverse.com</a>
    </div>

</div>

<div class="share">
    <a href="https://www.facebook.com/" class="fa-brands fa-facebook"></a>
    <a href="https://web.whatsapp.com/" class="fa-brands fa-whatsapp"></a>
    <a href="https://www.linkedin.com/" class="fa-brands fa-linkedin"></a>
    <a href="https://www.instagram.com/" class="fa-brands fa-instagram"></a>
</div>

<div class="credit">© SE 2020 Group 12. All Rights Reserved </div>

</section>
<!-- footer section ends -->


</body>
</html>