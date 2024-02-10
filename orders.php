<?php 
     include 'config.php';
     session_start();


     if(isset($_SESSION['user_id'])){
        $id=$_SESSION['user_id'];
     } else {
      header('location: login.php');
   }


    // order cancelled
    if(isset($_REQUEST['cancel'])) {
      $cancel_id = $_REQUEST['cancel'];
      $cancelled =  mysqli_query($conn, "UPDATE orders SET status = 'Cancelled' WHERE oId = '$cancel_id'");
      header('location: orders.php');
    }

    // order successfull
    if(isset($_REQUEST['success'])) {
      $success_id = $_REQUEST['success'];
      $successfull =  mysqli_query($conn, "UPDATE orders SET status = 'Successfull' WHERE oId = '$success_id'");
      header('location: orders.php'); 
    }

    
    ?>

   <!-- ////////////////////////////// -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

     <!-- linking fontawsome -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- linking style sheets -->
    <link rel="stylesheet" href="styles.css">
    <!-- linking style sheets -->
    <link rel="stylesheet" href="style.css">
    <!-- linking swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
</head>
<body>
   
  <!-- ------------------HEADER----------------------- -->
  <?php  include 'header.php'; ?>

<!-- Orders table -->
<section id="orders" class="display-product-table" style="margin-bottom: 40px;">
<h1 class="heading"><span>My Orders</span></h1>

<?php
 if(isset($_REQUEST['provider_session_id'])) {
   echo "<div class='empty'>Checkout Successful</div>";
  }
?>

<table>

   <thead>

      <th>Order Id</th>
      <th>Order Placed On</th>
      <th>Address Line 1</th>
      <th>Address Line 2</th>
      <th>City</th>
      <th>Quantity</th>
      <th>Total</th>
      <th>Status</th>

   </thead>

   <tbody>
      <?php

         $ord =  mysqli_query($conn, "SELECT * FROM orders WHERE uId = '$id' ORDER BY oId DESC");
         if(mysqli_num_rows($ord) > 0){
            while($row = mysqli_fetch_assoc($ord)){
      ?>

      <tr>    
         <td><?php echo $row['oId']; ?></td>
         <td><?php echo $row['datetime']; ?></td>
         <td><?php echo $row['addline1']; ?></td>
         <td><?php echo $row['addline2']; ?></td>
         <td><?php echo $row['city']; ?></td>
         <td><?php echo $row['quantity']; ?></td>
         <td>$<?php echo $row['total']; ?>/-</td>
         <td>
            <?php echo $row['status']; ?>
            <?php 
            if($row['status'] ==  "Processing") { 
            echo '<a href="orders.php?cancel='.$row['oId'].'" class="option-btn"> <i class="fas fa-x"></i>Cancel</a>';
            }
            ?>
            <?php 
            if($row['status'] ==  "Shipped") { 
            echo '<a href="orders.php?success='.$row['oId'].'" class="option-btn"> <i class="fas fa-check"></i>Deliverd</a>';
            }
            ?>
         </td>


         <!--
         <td>
            <a href="admin.php?edit=<?php echo $row['oId']; ?>" class="option-btn"> <i class="fas fa-edit"></i> Shipped </a>
         </td>
            -->
      </tr>

      <?php
         };    
         }
         else{
            echo "<div class='empty'>No Orders Have Been Placed</div>";
         };
      ?>
   </tbody>
</table>

</section>
      
<!-- infinite text loop start -->
<div class="scrolling_text">
    <div class="text">
        <span> ✪ FREEDOM OVER ANYTHING ✪ </span>
        <span>MENVERSE</span>
        <span> ✪ FREEDOM OVER ANYTHING ✪ </span>
        <span>MENVERSE</span>
        <span> ✪ FREEDOM OVER ANYTHING ✪ </span>
        <span>MENVERSE</span>
        <span> ✪ FREEDOM OVER ANYTHING ✪ </span>
        <span>MENVERSE</span>
        <span> ✪ FREEDOM OVER ANYTHING ✪ </span>
        <span>MENVERSE</span>
    </div>
    <div class="text">
        <span> ✪ FREEDOM OVER ANYTHING ✪ </span>
        <span>MENVERSE</span>
        <span> ✪ FREEDOM OVER ANYTHING ✪ </span>
        <span>MENVERSE</span>
        <span> ✪ FREEDOM OVER ANYTHING ✪ </span>
        <span>MENVERSE</span>
        <span> ✪ FREEDOM OVER ANYTHING ✪ </span>
        <span>MENVERSE</span>
        <span> ✪ FREEDOM OVER ANYTHING ✪ </span>
        <span>MENVERSE</span>
    </div>
</div>
<!-- infinite text loop ends -->
    
    

    <!-- -----------------------------footer---------------------- -->
    <?php  include 'footer.php'; ?>
<!-- footer section ends -->

<!-- swiper linking -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

   <!-- linking the javascript -->
   <script src="script.js"></script>
    
</body>
</html>