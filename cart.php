<?php 
     include 'config.php';
     session_start();
      $button = false;

     if(isset($_SESSION['user_id'])){
        $id=$_SESSION['user_id'];
     } else {
        header('location: login.php');
     }

     if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $delete_query = mysqli_query($conn, "DELETE FROM cart WHERE pId = $delete_id ") or die('query failed');
        header('location: cart.php');
        }

    
     //  update 

     if(isset($_POST['update_product'])){

        $update_id = $_SESSION['upid'];

        $update_p_quantity = $_POST['update_p_quantity'];

        $price_sql = "SELECT pPrice FROM product_info WHERE pId = $update_id";
        $price = mysqli_query($conn, $price_sql);
        $tot = mysqli_fetch_assoc($price);
        $t = $tot['pPrice'];
        $total = $update_p_quantity*$t;
        $update_querynopic = mysqli_query($conn, "UPDATE cart SET Quantity='$update_p_quantity', Total = '$total' WHERE UId = '$id' AND PId = '$update_id'");
        header('location: cart.php');

      }
      
    // rest
    if(isset($_GET['cancel'])){

       echo "<script>document.querySelector('.edit-form-container').style.display = 'none';</script>";
       // echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
    }    

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
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

<!-- My Cart -->


<!-- product table -->
<section class="display-product-table" style="margin-bottom: 40px;">
<h1 class="heading"><span>My Cart</span></h1>
<table>

   <thead>
      <th colspan="2">product</th>
      <th>in stock</th>
      <!-- <th>description</th> -->
      <th>price</th>
      <th>quantity</th>
      <th>total</th>
      <th>action</th>
   </thead>

   <tbody>
      <?php
        $gal=mysqli_query($conn,"SELECT * FROM product_info WHERE pID IN ( SELECT PId FROM cart WHERE UId = '$id' );");
         if(mysqli_num_rows($gal) > 0){
            while($row = mysqli_fetch_assoc($gal)){
                $row_id = $row['pId'];
                $button = true;
      ?>

      <tr>
        <?php 
        $edit_cart = mysqli_query($conn, "SELECT Quantity FROM cart WHERE PId = $row_id ");
        $fetch_cart = mysqli_fetch_assoc($edit_cart);
        echo '<td><img src="arrivals/'.$row['pImg'].'" height="100" alt=""></td>';
        ?>
         
         <td><?php echo $row['pName']; ?></td>
         <td><?php echo $row['pQuantity']; ?></td>
         <!-- <td><?php echo $row['pDescription']; ?></td> -->
         <td>$<?php echo $row['pPrice']; ?>/-</td>
         <td><?php echo $fetch_cart['Quantity']; ?></td>
         <td>$<?php echo $fetch_cart['Quantity']*$row['pPrice']; ?>/-</td>
         <td>
         <a href="cart.php?edit=<?php echo $row['pId']; ?>" class="option-btn"> <i class="fas fa-edit"></i> update quantity </a>   
         <a href="cart.php?delete=<?php echo $row['pId']; ?>" class="delete-btn"> <i class="fas fa-trash"></i> Remove</a>
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
<?php
   if($button) {
      echo '<a href="payment.php" class="proceed-btn">Proceed to checkout</a>';
      $button = false;
   }
?>
</section>


<!-- edit form -->

</section>

<section class="edit-form-container">

   <?php
   
   if(isset($_GET['edit'])){
      $edit_id = $_GET['edit'];
      $edit_query = mysqli_query($conn, "SELECT * FROM product_info WHERE pId = $edit_id");
      $edit_cart = mysqli_query($conn, "SELECT Quantity FROM cart WHERE PId = $edit_id");
      if(mysqli_num_rows($edit_query) > 0){
        while( $fetch_edit = mysqli_fetch_assoc($edit_query)){
            $fetch_cart = mysqli_fetch_assoc($edit_cart);
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      
   <?php  
   echo '<img src="arrivals/'.$fetch_edit['pImg'].'" height="100" alt="">';
   ?>
    
      <input type="number" min="1" max="<?php echo $fetch_edit['pQuantity']; ?>" class="box" required name="update_p_quantity" value="<?php echo $fetch_cart['Quantity']; ?>">

      <?php $_SESSION['upid']=$fetch_edit['pId']; ?>  
      
      <input type="submit" value="Update Quantity" name="update_product" class="btn">
       
      <a href="cart.php?reset='reset'" class="btn">Cancel</a>
   </form>

   <?php
            
         };
        };
         echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
      };
   ?>

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