<?php 
     include 'config.php';
     session_start();


     if(isset($_SESSION['user_id'])){
        $id=$_SESSION['user_id'];
     } else {
      header('location: login.php');
     }

     if(isset($_SESSION['user_id'])){
        $choose=mysqli_query($conn,"SELECT *FROM user_info WHERE uId='$id'");
        $row=mysqli_fetch_assoc($choose);

        $u=$row['email'];
        $p= $row['epassword'];

        $take=mysqli_query($conn,"SELECT *FROM normal_admin WHERE email='$u' and password='$p'");
        if(!mysqli_num_rows($take)>0){
            header('Location:index.php');
    
        }     
                   
    }
    else{
        header('Location:index.php');
    }

    // product shipped
    if(isset($_REQUEST['ship'])) {
      $ship_id = $_REQUEST['ship'];
      $shipped =  mysqli_query($conn, "UPDATE orders SET status = 'Shipped' WHERE oId = '$ship_id'");
      header('location: admin.php#orders'); 
    }

    // cancel shipment
    if(isset($_REQUEST['canship'])) {
      $ship_id = $_REQUEST['canship'];
      $shipped =  mysqli_query($conn, "UPDATE orders SET status = 'Processing' WHERE oId = '$ship_id'");
      header('location: admin.php#orders'); 
    }

    


    // add product
    if(isset($_POST['submit'])){

        $product=$_POST['name'];
        $quantity=$_POST['quantity'];
        $descript=$_POST['description'];
        $price=$_POST['price'];
        $category = $_POST['category'];
        
        $p_image = $_FILES['p_image']['name'];
        $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
       
        $p_image_folder_arrivals = 'arrivals/'.$p_image;
        

        $check=mysqli_query($conn,"SELECT *FROM product_info WHERE pName='$product'");

        if(mysqli_num_rows($check)>0){
            $row=mysqli_fetch_assoc($check);
            $quantity=$quantity+$row['pQuantity'];
            $pid=$row['pId'];
          
            $add=mysqli_query($conn,"UPDATE product_info SET  pQuantity='$quantity',pDescription='$descript',pPrice='$price',pImg='$p_image',cId='$category' WHERE pId='$pid'");
            if($add){
                    move_uploaded_file($p_image_tmp_name,$p_image_folder_arrivals);
                    $message[]='Product added succesfully';
                    header("location: admin.php#products");
            }
            else{
                $message[]='Not updated';
            }

           
        }
        else{

        

        $insert=mysqli_query($conn,"INSERT INTO product_info(pName,pQuantity,pDescription,pPrice,pImg,cId)
           VALUES('$product','$quantity','$descript','$price','$p_image','$category')") or die('query failed');

           if($insert){
                    move_uploaded_file($p_image_tmp_name,$p_image_folder_arrivals);
                    $message[]='Product added succesfully';
                    header("location: admin.php#products");

                
            }
            else{
                $message[]='Image not uploaded';
            }
           

        } 
           



    }

    //  delete 

    if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $delete_query = mysqli_query($conn, "DELETE FROM product_info WHERE pId = $delete_id ") or die('query failed');
        if($delete_query){
           $message[] = 'Product has been deleted';
           header("location: admin.php#products");
        }else{
           $message[] = 'Product can not be deleted';
        }
     }

     //  desc and asc 

     if(isset($_GET['order1'])){
        $_SESSION['order']='desc';
        $select_products = mysqli_query($conn, "SELECT * FROM product_info INNER JOIN categories ON product_info.cId = categories.cId  ORDER BY pId DESC");
     }
     else if(isset($_GET['order2'])){
        $_SESSION['order']='asc';
        $select_products = mysqli_query($conn, "SELECT * FROM product_info  INNER JOIN categories ON product_info.cId = categories.cId  ORDER BY pId ASC");
     }
     else{
        $select_products = mysqli_query($conn, "SELECT * FROM product_info  INNER JOIN categories ON product_info.cId = categories.cId  ORDER BY pId DESC");
     }


    //  update 

       if(isset($_POST['update_product'])){

         $update_id = $_SESSION['upid'];
    

         $update_p_name = $_POST['update_p_name'];
         $update_p_quantity = $_POST['update_p_quantity'];
         $update_p_description = $_POST['update_p_description'];
         $update_p_price = $_POST['update_p_price'];   
         $update_category = $_POST['update_category'];
         $update_p_image = $_FILES['update_p_image']['name'];
         $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
         
     
         $update_p_arrivals = 'arrivals/'.$update_p_image;
         
         $update_query = null;

         if($update_p_image){
            $update_query = mysqli_query($conn, "UPDATE product_info SET pName = '$update_p_name', pQuantity='$update_p_quantity', pDescription=' $update_p_description', pPrice = '$update_p_price', cId = '$update_category' pImg = '$update_p_image' WHERE pId = '$update_id'");
            header("location: admin.php#products");
         }
         else{
            $update_querynopic = mysqli_query($conn, "UPDATE product_info SET pName = '$update_p_name', pQuantity='$update_p_quantity', pDescription=' $update_p_description', pPrice = '$update_p_price', cId = '$update_category' WHERE pId = '$update_id'");
            header("location: admin.php#products");
         }
         
         if($update_query){
        
                move_uploaded_file($update_p_image_tmp_name, $update_p_arrivals);
                $message[] = 'Product updated succesfully';
                header("location: admin.php#products");
               }
       }
       
         

     // rest
     if(isset($_GET['cancel'])){

        echo "<script>document.querySelector('.edit-form-container').style.display = 'none';</script>";
     }



   //   admin_add_process

   if(isset($_POST['add_admin'])){

      $aname = mysqli_real_escape_string($conn, $_POST['aname']);
      $aemail = mysqli_real_escape_string($conn, $_POST['aemail']);
      $anum = mysqli_real_escape_string($conn, $_POST['anum']);
      $apass = mysqli_real_escape_string($conn, md5($_POST['apassword']));
      $acpass = mysqli_real_escape_string($conn, md5($_POST['acpassword']));

      if($apass!= $acpass){
         $messageA[]='confirm password not match';
      }
      else{
         $check_admin=mysqli_query($conn,"SELECT *FROM normal_admin WHERE email='$aemail' and password='$apass'  ");

         if(mysqli_num_rows($check_admin)>0){
            $messageA[]='This admin already exists';
         }
         else{
            $add_am=mysqli_query($conn,"INSERT INTO `normal_admin`(`name`, `email`, `number`, `password`) VALUES ('$aname','$aemail','$anum','$apass')");
            $add_us=mysqli_query($conn,"INSERT INTO `user_info`(`name`, `email`, `number`, `epassword`) VALUES ('$aname','$aemail','$anum','$apass')");

            if($add_am and $add_us){
               $messageA[]='Admin added sucsessfully';
               header("location: admin.php");
            }
            else{
               $messageA[]='Admin adding failed';
            }
         }
      }

     

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

      <!-- add product -->
      <div class="product-container" id="addproduct">
        <div id="" class="signdiv"></div>
        <form action="" method="POST" enctype="multipart/form-data">
        <h3>Add product</h3>

            <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>

      <div class="indiv">
            <span>Product name</span>
            <input type="text" name="name" class="box" placeholder="Name" id="" required>
            <span>Quantity</span>
            <input type="number" min="0" name="quantity" class="box" placeholder="Quantity" id="" required>
            <span>Description</span>
            <input type="text" name="description" class="box" placeholder="Description" id="" required>
      </div>

      <div class="indiv">
            <span>Price</span>
            <input type="number" min="0" name="price" class="box" placeholder="Price" id="" required>
            <span>Category</span>
            <SELECT class = "box" name="category" placehoder="Select the category" required>
               <OPTION disabled selected>Select :</OPTION>
               <OPTION Value="1">Long-Sleeve Tshirts</OPTION>
               <OPTION Value="2">Sport T-Shirts</OPTION>
               <OPTION Value="3">Polo T-Shirts</OPTION>
               <OPTION Value="4">CrewNeck T-Shirts</OPTION>
               <OPTION Value="5">Shorts</OPTION>
            </SELECT>
            <span>Image</span>     
            <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box" required>       
      </div>
      <input type="submit" name="submit" value="Add Product" class="btn" >   
      <a href="index.php" class="btn">Back to Main</a>                  
      </form>
    </div>

      <!-- NAvigate -->
      <header class="header">
<div class= "header-2">
<nav class="navbar">
        <a href="admin.php#addproduct">Add Product</a>
        <a href="admin.php#orders">Order Managment</a>
</nav>
</div>
</header>
    <!-- filter -->
    <div style="align-items: center; display:flex ;justify-content: space-evenly;">
    <a style="width: 120px; " href="admin.php?order1='desc'>" class="option-btn">Descending</a>
    
    <!-- super admin button -->
    <?php  
    $knowing=mysqli_query($conn,"SELECT *FROM user_info WHERE uId='$id'");
    $look=mysqli_fetch_assoc($knowing);

    $ke=$look['email'];
    $kp=$look['epassword'];

    $check_super=mysqli_query($conn,"SELECT *FROM super_admin WHERE email='$ke' and password='$kp'");

    if(mysqli_num_rows($check_super)>0){
      echo '    <a style="width: 120px;" href="admin.php?add_admin"   class="option-btn-admin" > Add admin</a>';
    }

    ?>
<!-- super admin button  end-->
    <a style="width: 120px; " href="admin.php?order2='asc'>" class="option-btn">Ascending</a>

    </div>

    <!-- product table -->

<section id="products" class="display-product-table" style="margin-bottom: 40px;">
<h1 class="heading"><span>Our Stock</span></h1>

<table>

   <thead>
      <th>Image</th>
      <th>Product</th>
      <th>Category</th>
      <th>Quantity</th>
      <th>Description</th>
      <th>Price</th>
      <th>Action</th>
   </thead>

   <tbody>
      <?php
      
         if(mysqli_num_rows($select_products) > 0){
            while($row = mysqli_fetch_assoc($select_products)){
      ?>

      <tr>
        <?php 
        echo '<td><img src="arrivals/'.$row['pImg'].'" height="100" alt=""></td>';
        ?>
         
         <td><?php echo $row['pName']; ?></td>
         <td><?php echo $row['cName']; ?></td>
         <td><?php echo $row['pQuantity']; ?></td>
         <td><?php echo $row['pDescription']; ?></td>
         <td>$<?php echo $row['pPrice']; ?>/-</td>
         <td>
         <a href="admin.php?delete=<?php echo $row['pId']; ?>" class="delete-btn" onclick="return confirm('Are your sure you want to delete this?');"> <i class="fas fa-trash"></i> delete</a>
            <a href="admin.php?edit=<?php echo $row['pId']; ?>" class="option-btn"> <i class="fas fa-edit"></i> update </a>
         </td>
      </tr>

      <?php
         };    
         }
         else{
            echo "<div class='empty'>No product has been added</div>";
         };
      ?>
   </tbody>
</table>

</section>

<!-- edit form -->

</section>

<section class="edit-form-container">

   <?php
   
   if(isset($_GET['edit'])){
      $edit_id = $_GET['edit'];
      $edit_query = mysqli_query($conn, "SELECT * FROM product_info WHERE pId = $edit_id");
      if(mysqli_num_rows($edit_query) > 0){
        while( $fetch_edit = mysqli_fetch_assoc($edit_query)){
            
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      
   <?php  
   echo '<img src="arrivals/'.$fetch_edit['pImg'].'" height="100" alt="">';
   ?>
    
      
      <input type="text" class="box" required name="update_p_name" value="<?php echo $fetch_edit['pName']; ?>">
      <input type="number" min="0" class="box" required name="update_p_quantity" value="<?php echo $fetch_edit['pQuantity']; ?>">
      <input type="text" class="box" required name="update_p_description" value="<?php echo $fetch_edit['pDescription']; ?>">
      <input type="number" min="0" class="box" required name="update_p_price" value="<?php echo $fetch_edit['pPrice']; ?>">
      <SELECT class = "box" name="update_category">
               <OPTION Value="1" <?php if($fetch_edit['cId'] == 1) {echo "selected"; }?> >Long-Sleeves</OPTION>
               <OPTION Value="2" <?php if($fetch_edit['cId'] == 2) {echo "selected"; }?>>Sport T-Shirts</OPTION>
               <OPTION Value="3" <?php if($fetch_edit['cId'] == 3) {echo "selected"; }?>>Polo T-Shirts</OPTION>
               <OPTION Value="4" <?php if($fetch_edit['cId'] == 4) {echo "selected"; }?>>CrewNeck T-Shirts</OPTION>
               <OPTION Value="5" <?php if($fetch_edit['cId'] == 5) {echo "selected"; }?>>Shorts</OPTION>
      </SELECT>

       
      
      <?php $_SESSION['upid']=$fetch_edit['pId']; ?>  
      <input type="file" class="box"  name="update_p_image" accept="image/png, image/jpg, image/jpeg">
      <input type="submit" value="Update Product" name="update_product" class="btn">
       
      <a href="admin.php?reset='reset'" class="btn">Cancel</a>
   </form>

   <?php
            
         };
        };
         echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
      };
   ?>

</section>


    <!-- ----------add admin form-------------- -->
    <!-- sign form -->

    <?php   
    if(isset($_GET['add_admin'])){
       echo '<div class="add-form-container">
       <div id="" class="signdiv"></div>
       <form action="" method="POST" enctype="multipart/form-data">

       <a href="admin.php"  class="icon-eye fas fa-times"></a>
           <h3>Add Admin</h3>';

                 
      if(isset($messageA)){
         foreach($messageA as $messageA){
            echo '<div class="message">'.$messageA.'</div>';
         }
      }

         echo '
         
         <span>Name</span>
         <input type="text" name="aname" class="box" placeholder="User name" id="" required>
         <span>Email</span>
         <input type="email" name="aemail" class="box" placeholder="Enter your email" id="" required>
         <span>Mobile Number</span>
         <input type="number" name="anum" class="box" placeholder="Phone number" id="" required>
         <span>Password</span>
         <input type="password" name="apassword" class="box" placeholder="Enter your password" id="" required>
         <span>Confirm Password</span>
         <input type="password" name="acpassword" class="box" placeholder="Enter your password" id="" required>
          
         <input type="submit" name="add_admin" value="add" class="btn" >
         
          
     </form>
 </div>';
      
echo  "<script>document.querySelector('.add-form-container').style.display = 'flex';</script>";
    }
    
    ?>

    
<!-- NAvigate -->
<header class="header">
<div class= "header-2">
<nav class="navbar">
        <a href="admin.php#addproduct">Add Product</a>
        <a href="admin.php#products">Our Stock</a>
</nav>
</div>
</header>

<!-- Orders table -->
<section id="orders" class="display-product-table" style="margin-bottom: 40px;">
<h1 class="heading"><span>Order Management</span></h1>

<table>

   <thead>

      <th>Order Id</th>
      <th>Order Placed On</th>
      <th>Name</th>
      <th>Email</th>
      <th>Phone Number</th>
      <th>Postal Code</th>
      <th>Address Line 1</th>
      <th>Address Line 2</th>
      <th>City</th>
      <th>Quantity</th>
      <th>Total</th>
      <th>Status</th>

   </thead>

   <tbody>
      <?php

         $ord =  mysqli_query($conn, "SELECT * FROM orders");
         if(mysqli_num_rows($ord) > 0){
            while($row = mysqli_fetch_assoc($ord)){
      ?>

      <tr>    
         <td><?php echo $row['oId']; ?></td>
         <td><?php echo $row['datetime']; ?></td>
         <td><?php echo $row['name']; ?></td>
         <td><?php echo $row['email']; ?></td>
         <td><?php echo $row['number']; ?></td>
         <td><?php echo $row['postal']; ?></td>
         <td><?php echo $row['addline1']; ?></td>
         <td><?php echo $row['addline2']; ?></td>
         <td><?php echo $row['city']; ?></td>
         <td><?php echo $row['quantity']; ?></td>
         <td>$<?php echo $row['total']; ?>/-</td>
         <td>
            <?php echo $row['status']; ?>
            <?php 
            if($row['status'] ==  "Processing") { // Need to be processing
            echo '<a href="admin.php?ship='.$row['oId'].'" class="option-btn"> <i class="fas fa-ship"></i>Ship</a>';
            }
            ?>
            <?php 
            if($row['status'] ==  "Shipped") { 
            echo '<a href="admin.php?canship='.$row['oId'].'" class="option-btn"> <i class="fas fa-x"></i>Undo</a>';
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
      

    <!-- -----------------------------footer---------------------- -->
    <?php  include 'footer.php'; ?>
<!-- footer section ends -->

<!-- swiper linking -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

   <!-- linking the javascript -->
   <script src="script.js"></script>
    
</body>
</html>