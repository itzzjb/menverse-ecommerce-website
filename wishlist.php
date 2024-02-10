<?php 
     include 'config.php';
     session_start();


     if(isset($_SESSION['user_id'])){
        $id=$_SESSION['user_id'];
     }  else {
        header('location: login.php');
     }

     if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $delete = mysqli_query($conn, "DELETE FROM wishlist WHERE pId = $delete_id ") or die('query failed');
        header('location: wishlist.php');
        }

     if(isset($_REQUEST['cart'])) {
        if(isset($_SESSION['user_id'])) {
            $cid =  $_REQUEST['cart'];
            $cart =  "INSERT into cart(UId, PId) VALUES('$id','$cid')";
            $insert = mysqli_query($conn, $cart);
            $delete = mysqli_query($conn, "DELETE FROM wishlist WHERE pId = $cid") or die('query failed');
            header('location: wishlist.php');   
        } else {
            header('location: login.php');
        }
    } else {
        $cid = 0;
    }   

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <!-- linking fontawsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
     <!-- linking style sheets -->
     <link rel="stylesheet" href="styles.css">
    <!-- linking style sheets -->
    <link rel="stylesheet" href="style.css">
    <!-- linking swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
    <style>
    .icon-heart {
        color: red; /* Change the color to red */
        font-size: 24px; /* Change the font size to 24 pixels */
        padding-bottom: 5px;
        padding-right: 20px;
    }

    .icon-heart:hover,
    .icon-eye:hover{
        color:purple;
        font-size: 30px;
        
    }

    .icon-eye {
        color: blue; /* Change the color to blue */
        font-size: 24px; /* Change the font size to 24 pixels */
        padding-bottom: 5px;
    }
</style>
</head>
<body>

  
   <!-- ------------------HEADER----------------------- -->
   <?php  include 'header.php'; ?>
   
<!-- My Wishlist -->


<!-- product table -->
<section class="display-product-table" style="margin-bottom: 40px;">
<h1 class="heading"><span>My Wishlist</span></h1>
<table>

   <thead>
      <th colspan="2">product</th>
      <th>in stock</th>
      <th>description</th>
      <th>price</th>
      <th>action</th>
   </thead>

   <tbody>
      <?php
        $gal=mysqli_query($conn,"SELECT * FROM product_info WHERE pID IN ( SELECT PId FROM wishlist WHERE UId = '$id' );");
        //  $select_products = mysqli_query($conn, "SELECT * FROM `items` ORDER BY pID desc");
         if(mysqli_num_rows($gal) > 0){
            while($row = mysqli_fetch_assoc($gal)){
      ?>

      <tr>
        <?php 
        echo '<td><img src="arrivals/'.$row['pImg'].'" height="100" alt=""></td>';
        ?>
         
         <td><?php echo $row['pName']; ?></td>
         <td><?php echo $row['pQuantity']; ?></td>
         <td><?php echo $row['pDescription']; ?></td>
         <td>$<?php echo $row['pPrice']; ?>/-</td>
         <td>
         <?php 
         if($row['pQuantity']>0) {
            echo '<a href="wishlist.php?cart='.$row['pId'].'" class="option-btn"> <i class="fas fa-cart-shopping"></i> Add to cart</a>';
         } else {
            echo "Out of Stock";
         }
         ?>
         <a href="wishlist.php?delete=<?php echo $row['pId']; ?>" class="delete-btn"> <i class="fas fa-trash"></i> Remove</a>
         </td>
      </tr>

      <?php
         };
         }
         else{
            echo "<div class='empty'>no product added</div>";
         };
      ?>
   </tbody>
</table>

</section>

<!-- -----------------------------footer---------------------- -->
 <?php  include 'footer.php'; ?>
<!-- footer section ends --> 

<!-- swiper linking -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

   <!-- linking the javascript -->
   <script src="script.js"></script>

</body>
</html>