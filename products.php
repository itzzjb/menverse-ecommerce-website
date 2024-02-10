<?php 
     include 'config.php';
     session_start();


     if(isset($_SESSION['user_id'])){
        $id=$_SESSION['user_id'];
     } else {
        $id = 0;
     }

     if(isset($_GET['logout'])){
        session_destroy();
        header('location: index.php');
     } 

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products</title>
    <!-- linking fontawsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
     <!-- linking style sheets -->
     <link rel="stylesheet" href="styles.css">
    <!-- linking style sheets -->
    <link rel="stylesheet" href="style.css">
    <!-- linking swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
    <style>
    
</style>
</head>
<body>

  <!-- ------------------HEADER----------------------- -->
  <?php  include 'header.php'; ?>


<!-- NEW ARRIVALS -->

<?php 

echo '<section class="featured" id="arrivals">

<h1 class="heading"><span>All Products</span></h1>

<div class="swipers featured-sliders" style="display:flex;">

<section class="gallery" id="gallery">

  <div class="box-container">';

$gal=mysqli_query($conn,"SELECT * FROM `product_info`");

if(mysqli_num_rows($gal)>0){
    while($set=mysqli_fetch_assoc($gal)){
     
        echo '
    <div class="box">
        <img src="arrivals/'.$set['pImg'].'" alt="new arrival product">
        <div class="content">

        <div class="icons">';

        if(isset($id)){   
            echo'<a href="index.php?wish='.$set['pId'].'" class="icon-heart far fa-heart"></a>';
        }
        else{
            echo'<a href="login.php" class="icon-heart far fa-heart"></a>';
        }
                 echo'  <a href="index.php?view='.$set['pId'].'" class="icon-eye far fa-eye"></a>
                 
                </div>

                <h3>'.$set['pName'].'</h3>
                <h2>'.'$'.$set['pPrice'].'/-'.'</h2>';
                
                if(isset($id)){
                    if($set['pQuantity']>0) {
                        echo '<h4>Only '.$set['pQuantity'].' left</h4>';
                        echo '<a href="index.php?cart='.$set['pId'].'" class="btn1">Add to cart</a>';
                     } else {
                        echo "<h3>Out of Stock</h3>";
                     }                    }
                else{
                    echo '<a href="login.php" class="btn1">Add to cart</a>';
                }
       echo ' </div>
    </div>
    ';
        
    }
}
echo '</div>
</section>
</div>
</section>';

?>



<!-- view popup -->

<section class="viewbox">

  <div class="infobox">

  <?php 
if(isset($_GET['view'])){
    $viewId=$_GET['view'];

    $info= mysqli_query($conn, "SELECT * FROM `product_info` WHERE pId = $viewId");
    if(mysqli_num_rows($info) > 0){
      while( $dis = mysqli_fetch_assoc($info)){

        if(isset($id)){
            echo'<a href="index.php?wish='.$dis['pId'].'" class="icon-heart far fa-heart"></a>';
        }
        else{
            echo'<a href="login.php" class="icon-heart far fa-heart"></a>';
        }
        echo '<a href="index.php#arrivals" class="icon-eye fas fa-times"></a>'."<br>";
         
             echo '<img src="arrivals/'.$dis['pImg'].'"  alt="">'; 
            
           echo '
           <div>
           <h3>'.$dis['pName'].'</h3>
            <p>'.$dis['pDescription'].'</p>
            <h2>'.'$'.$dis['pPrice'].'/-'.'</h2>';
            if(isset($id)){
                if($dis['pQuantity']>0) {
                    echo '<h4>Only '.$dis['pQuantity'].' left</h4>';
                    echo '<a href="index.php?cart='.$dis['pId'].'" class="btn1">Add to cart</a>';
                 } else {
                    echo "<h3>Out of Stock</h3>";
                 }                }
            else{
                echo '<a href="login.php" class="btn1">Add to cart</a>';
            }
           echo' </div>';

            
            
            echo "<script>document.querySelector('.viewbox').style.display = 'flex';</script>";

      }}
          
    
    
}

?>
 


  </div>


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

<!-- categories -->
<header class="header">
<div class= "header-2">
<nav class="navbar">
        <a href="categories.php?cat=1">Long-Sleeves</a>
        <a href="categories.php?cat=2">Sport T-shirts</a>
        <a href="categories.php?cat=3">Polo T-shirts</a>
        <a href="categories.php?cat=4">CrewNeck T-Shirts</a>
        <a href="categories.php?cat=5">Shorts</a>
        <a href="products.php">All</a>
</nav>
</div>
</header>
<!-- -----------------------------footer---------------------- -->
 <?php  include 'footer.php'; ?>
<!-- footer section ends -->

<!-- swiper linking -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

   <!-- linking the javascript -->
   <script src="script.js"></script>

</body>
</html>