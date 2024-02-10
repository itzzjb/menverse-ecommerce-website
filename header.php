<?php

if(isset($_REQUEST['search'])){
 $_SESSION['query'] = $_POST['q'];
 header('Location: search.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <style>
      .btns:hover{
        transform:scale(1);
      }
    </style>
</head>
<body>
<header class="header">

<!-- carousel -->
<div class="content-slider">
<div class="slider">
<div class="mask">
<ul>
 <center>
<li class="anim1">
  <div class="quote">4 DAYS MAXIMUM FOR DELIVERY</div>
</li>
<li class="anim2">
  <div class="quote">ADD 5 PRODUCTS TO CART AND GET DISCOUNTS</div>
</li>
<li class="anim3">
  <div class="quote">100% SECURE PAYMENT METHOD</div>
</li>
<li class="anim4">
  <div class="quote">RETURN WITHIN 7 DAYS</div>
</li>
<li class="anim5">
  <div class="quote">24/7 HOURS SERVICE</div>
</li>
</center>
</ul>
</div>
</div>
</div>
<!-- carousel end -->

<div class="header-2">
    <nav class="navbar">
        <a href="index.php#home" ><h1 class="menverse"><span>M</span>EN<span>V</span>ERSE</h1></a>
        <a href="index.php#arrivals" style="float:left";>New Arrivals</a>
        <a href="index.php#collections" style="float:left";>Collections</a>
        <a href="index.php#blogs" style="float:left";>Upcoming</a>    
        <?php

if(isset($_SESSION['user_id'])){

        echo '<a href="orders.php" style="float:left";>My Orders</a>';  

        $choose=mysqli_query($conn,"SELECT *FROM user_info WHERE uId='$id'");
        $row=mysqli_fetch_assoc($choose);

        $u=$row['email'];
        $p= $row['epassword'];

        $take=mysqli_query($conn,"SELECT *FROM normal_admin WHERE email='$u' and password='$p'");
        if(mysqli_num_rows($take)>0){
            echo '<a href="admin.php" style="float:left";>admin panel</a>';  
    
        } 
                   
    }
        ?>
        
        <a href="login.php" id="login-btn" style="float:right";><i class="fa-solid fa-user"></i></a>
       <a href="cart.php" id="shopping-cart" style="float:right";><i class="fa-solid fa-cart-shopping"></i></a>
       <a href="wishlist.php" id="shopping-cart" style="float:right";><i class="fa-solid fa-heart"></i></a>

       <!-- search bar -->
       <form action="" id="form" method="POST" style="float:right; margin-right:20px; border:1px solid black; margin-top:10px ";> 
            <input type="search" id="query" name="q" placeholder="  Search ...">
            <input type="submit" name="search" value="Search" class="btn btns" style="margin-top: 0; ">
        </form>
       

    </nav>

</header>
</body>