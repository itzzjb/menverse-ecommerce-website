<?php 
     include 'config.php';
     session_start();


     if(isset($_SESSION['user_id'])){
        $id=$_SESSION['user_id'];
     } else {
      header('location: login.php');
     }

     if(isset($_GET['logout'])){
        session_destroy();
     }

     if(isset($_POST['submit'])){

      $name=$_POST['name'];
      $email=$_POST['email'];
      $number=$_POST['num'];
      $postal=$_POST['post'];
      $add1=$_POST['line1'];
      $add2=$_POST['line2'];
      $city=$_POST['city'];
      $method=$_POST['method'];

         $sqlquantity = "SELECT SUM(Quantity) as q FROM Cart WHERE UId = '$id'";
         $sqltotal = "SELECT SUM(Total) as t FROM Cart WHERE UId = '$id'";
         $quan = mysqli_query($conn, $sqlquantity);
         $tot = mysqli_query($conn, $sqltotal);
         $q = mysqli_fetch_assoc($quan);
         $t = mysqli_fetch_assoc($tot);
         $quantity = $q['q'];
         $total = $t['t'];

      
      $order=mysqli_query($conn,"INSERT INTO orders(name,email,number,postal,addline1,addline2,city,method,quantity,total,uId) VALUES('$name','$email','$number','$postal','$add1','$add2','$city','$method','$quantity','$total','$id')");
      $newid = mysqli_query($conn,"SELECT oId FROM orders ORDER BY oId DESC LIMIT 1;");
      $newOid = mysqli_fetch_assoc($newid);
      $_SESSION['order_id'] = $newOid['oId'];
      if($method == "Hand") {
        header('location: checkout-success.php?provider_session_id=payondelivey');
      } else {
        header('location: checkout.php');
      }

  }

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="wi<?php 
     include 'config.php';
     session_start();


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
</head>
<body>
  
   <!-- ------------------HEADER----------------------- -->
   <?php  include 'header.php'; ?>


<!-- Payment -->


<!-- product table -->
<section class="display-product-table" style="margin-bottom: 40px;">
<h1 class="heading"><span>Checkout</span></h1>
<?php
 if(isset($_REQUEST['provider_session_id'])) {
   echo "<div class='empty'>Payment Unsuccessful</div>";
  }
?>

<table>

   <thead>
      <th>product</th>
      <th>quantity</th>
      <th>price</th>
   </thead>

   <tbody>
      <?php
        $gal=mysqli_query($conn,"SELECT * FROM product_info WHERE pID IN ( SELECT PId FROM cart WHERE UId = '$id' );");
        //  $select_products = mysqli_query($conn, "SELECT * FROM `items` ORDER BY pID desc");
         if(mysqli_num_rows($gal) > 0){
            while($row = mysqli_fetch_assoc($gal)){
                $row_id = $row['pId'];
      ?>

      <tr>
        <?php 
        $edit_cart = mysqli_query($conn, "SELECT Quantity FROM cart WHERE PId = $row_id ");
        $fetch_cart = mysqli_fetch_assoc($edit_cart);
        ?>
         
         <td><?php echo $row['pName']; ?></td>
         <td><?php echo $fetch_cart['Quantity']; ?></td>
         <td>$<?php echo $fetch_cart['Quantity']*$row['pPrice']; ?>/-</td>
      </tr>

      <?php
         };
         $sqlquantity = "SELECT SUM(Quantity) as q FROM Cart WHERE UId = '$id'";
         $sqltotal = "SELECT SUM(Total) as t FROM Cart WHERE UId = '$id'";
         $quan = mysqli_query($conn, $sqlquantity);
         $tot = mysqli_query($conn, $sqltotal);
         $q = mysqli_fetch_assoc($quan);
         $t = mysqli_fetch_assoc($tot);
         $quantity = $q['q'];
         $total = $t['t'];

         ?> 
        
    <?php    
         }
         else{
            echo "<div class='empty'>no product added</div>";
         };
      ?>
   </tbody>
   <thead>
        <th>Total</th>
        <th><?php echo $quantity ?></th>
        <th>$<?php echo $total ?>/-</th>
    </thead>     
</table>
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

      <input type="submit" value="Update Product" name="update_product" class="btn">
       
      <a href="cart.php?reset='reset'" class="btn">Cancel</a>
   </form>

   <?php
            
         };
        };
         echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
      };
   ?>

</section>

<!-- order form -->
<div class="product-container">
        <form action="" method="POST" enctype="multipart/form-data">

            <h3>Order Details</h3>  
      
      <div class="indiv">
            <span>Name</span>
            <input type="text" name="name" class="box" style="text-transform: none" placeholder="Name" id="" required>
            <span>Email</span>
            <input type="email" name="email" class="box" style="text-transform: none" placeholder="Email" id="" required>
            <span>Mobile Number</span>
            <input type="number" name="num" class="box" style="text-transform: none" placeholder="Phone number" id="" required>
            <span>Postal Code</span>
            <input type="number" name="post" class="box" style="text-transform: none" placeholder="Postal code" id="" required>
    </div>

    <div class="indiv">
            <span>Address Line 1</span>
            <input type="text" name="line1" class="box" style="text-transform: none" placeholder="Address line 1" id="" required>
            <span>Address Line 2</span>
            <input type="text" name="line2" class="box" style="text-transform: none" placeholder="Address Line 2" id="" required>
            <span>City</span>
            <input type="text" name="city" class="box" style="text-transform: none" placeholder="City" id="" required>
            <span>Payment Method</span>
            <SELECT class = "box" name="method" placehoder="Select the category" required>
               <OPTION disabled selected>Select :</OPTION>
               <OPTION Value="Card">Card Payments</OPTION>
               <OPTION Value="Hand">Pay-on-delivery</OPTION>
            </SELECT>
    </div>
             
            <input type="submit" name="submit" value="Proceed to payments" class="btn" >  
            <a href="cart.php" class="btn">Back to cart</a>           
        </form>
    </div>


<!-- -----------------------------footer---------------------- -->
 <?php  include 'footer.php'; ?>
<!-- footer section ends -->

<!-- swiper linking -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

   <!-- linking the javascript -->
   <script src="script.js"></script>

</body>
</html>