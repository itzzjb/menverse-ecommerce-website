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

    if(isset($_REQUEST['cart'])) {
        if(isset($_SESSION['user_id'])) {
            $cid =  $_REQUEST['cart'];

            $price_sql = "SELECT pPrice FROM product_info WHERE pId = $cid";
            $price = mysqli_query($conn, $price_sql);
            $tot = mysqli_fetch_assoc($price);
            $total = $tot['pPrice'];

            $cart =  "INSERT into cart(UId, PId, Total) VALUES('$id','$cid','$total')";

            $insert = mysqli_query($conn, $cart);
            header('location: index.php#arrivals');   
        } else {
            header('location: login.php');
        }
    } else {
        $cid = 0;
    }

    if(isset($_REQUEST['wish'])) {
        if(isset($_SESSION['user_id'])) {
            $wid =  $_REQUEST['wish'];
            $sqlall =  "SELECT * from wishlist WHERE UId = '$id' and PId = '$wid'";
            $all = mysqli_query($conn, $sqlall);
            if (mysqli_num_rows($all) == 0) {
                $wish =  "INSERT into wishlist(UId, PId) VALUES('$id','$wid')";
                $insert = mysqli_query($conn, $wish);
            } 
            header('location: index.php#arrivals');
        } else {
            header('location: login.php');
        }
    } else {
        $wid =0;
    }

    $sqlwish = "SELECT * FROM wishlist";
    $wishall = mysqli_query($conn, $sqlwish);

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MenVerse</title>
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

  <header class="header">

    <div class="container">
        <video muted autoplay loop width="100%" >
            <source src="./video/back.mp4" type="video/mp4">
        </video>
            <div class="hero-text">
                <h1>LATEST DROP</h1></br>
                <h1 style="font-size: 55px;"> FREEDOM OVER ANYTHING</h1> 
                <a href="products.php" class="buynow-btn btn-shine"><span>Buy Now</span></a>
            </div>
    </div>
    
    </header>

<!-- icons section starts  -->

<section class="icons-container">

<div class="icons">
    <i class="fa-solid fa-motorcycle"></i>
    <div class="content">
        <h3> Free delivery</h3>
        <p> Free delivery for purchases over RS.10,000</p>
    </div> 
</div>


<div class="icons">
    <i class="fa-solid fa-lock"></i>
    <div class="content">
        <h3>Secure Payments</h3>
        <p>100% secure payment methods</p>
    </div>
</div>

<div class="icons">  
    <i class="fa-solid fa-rotate-right"></i>
    <div class="content">
        <h3>Easy Returns</h3>
        <p>Returns within 7 days</p>
    </div> 
</div>

<div class="icons">
    <i class="fa-solid fa-phone"></i>
    <div class="content">
        <h3>24/7 hours service</h3>
        <p>Call us anytime</p>
    </div>
</div>

</section>

 <!-- icons section ends -->

<!-- NEW ARRIVALS -->

<?php 

echo '<section class="featured" id="arrivals">

<h1 class="heading"><span>New Arrivals</span></h1>

<div class="swipers featured-sliders" style="display:flex;">

<section class="gallery" id="gallery">

  <div class="box-container">';

$gal=mysqli_query($conn,"SELECT * FROM `product_info` ORDER BY pId DESC limit 8;");

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
         }
                }
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
            echo'<a href="index.php?wish='.$dis['pId'].'" class="heart icon-heart far fa-heart"></a>';
        }
        else{
            echo'<a href="login.php" class="heart icon-heart far fa-heart"></a>';
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
                 }    
            }
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

<!-- Collections -->

<?php 

echo '<section class="featured" id="collections">

<h1 class="heading"><span>Collections</span></h1>

<div class="swipers featured-sliders" style="display:flex;">

<section class="gallery" id="gallery">

  <div class="box-container">';

$gal=mysqli_query($conn,"SELECT * FROM `product_info` ORDER BY pId ASC limit 8 ;");

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
                     }                }
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
                 }    
            }
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

<!-- upcoming section starts -->

<section class="blogs" id="blogs">

<h1 class="heading"><span>Upcoming</span></h1>

<div class="swiper blogs-slider">

    <div class="swiper-wrapper">

        <div class="swiper-slide box">
            <div class="image">
                <img src="./upcoming/upcoming4.jpg" alt="">
            </div>
            <div class="content">
                <h3>"Urban Elegance"</h3>
                <p>Embrace the fusion of sophistication and casual comfort with our Urban Elegance collection. Designed for the modern man who seeks style without sacrificing ease, this collection redefines contemporary fashion. From versatile t-shirts to tailored shorts and sporty long sleeves, each piece is meticulously crafted to elevate your everyday wardrobe.
                </p>
                <a href="#" class="btn">Read More</a>
            </div>
        </div>

        <div class="swiper-slide box">
            <div class="image">
                <img src="./upcoming/upcoming2.jpg" alt="">
            </div>
            <div class="content">
                <h3>"Metropolitan Chic"</h3>
                <p>Redefine your urban style with our Metropolitan Chic collection. Immerse yourself in the perfect blend of cosmopolitan flair and refined comfort. Whether it's sleek jackets, tailored denim, or polished accessories, each piece in this collection is curated to seamlessly transition from city streets to upscale events, embodying the essence of modern sophistication.
                </p>
                <a href="#" class="btn">Read More</a>
            </div>
        </div>

        <div class="swiper-slide box">
            <div class="image">
                <img src="./upcoming/upcoming5.jpg" alt="">
            </div>
            <div class="content">
                <h3>"Dapper Downtown"</h3>
                <p>Introducing the Dapper Downtown collection, where dashing meets downtown. Navigate the city with confidence in our carefully curated assortment of stylish blazers, versatile chinos, and suave accessories. Tailored for the modern gentleman, this collection effortlessly combines sophistication with the laid-back charm of the urban landscape.
                </p>
                <a href="#" class="btn">Read More</a>
            </div>
        </div>

        <div class="swiper-slide box">
            <div class="image">
                <img src="./upcoming/upcoming1.jpg" alt="">
            </div>
            <div class="content">
                <h3>"Cosmopolitan Comfort"</h3>
                <p> Immerse yourself in the allure of Cosmopolitan Comfort, a collection designed for the contemporary man who values both style and ease. From refined sweaters to smart-casual trousers, each piece is thoughtfully crafted to provide unparalleled comfort without compromising on the urbane charm that defines your fashion-forward identity.
                </p>
                <a href="#" class="btn">Read More</a>
            </div>
        </div>

        <div class="swiper-slide box">
            <div class="image">
                <img src="./upcoming/upcoming3.jpg" alt="">
            </div>
            <div class="content">
                <h3> "Modern Urbane"</h3>
                <p>Redefine modern fashion with our Modern Urbane collection. Embrace the synergy of sleek design and urban sensibility with this curated selection of wardrobe essentials. From crisp shirts to tailored joggers, each piece is a testament to the modern man's commitment to style and functionality, ensuring you effortlessly stand out in any metropolitan setting.</p>
                <a href="#" class="btn">Read More</a>
            </div>
        </div>
    </div>
</div>
</section>

<!-- upcoming section ends --> 

<!-- Reviews section starts -->
<!--
<section class="reviews" id="reviews">

<h1 class="heading" ><span>Customers Reviews</span></h1>

        <div class="swiper reviews-slider">
            <div class="swiper-wrapper">

                <div class="swiper-slide box">
                    <h3>Jake Thompson</h3>
                    <p>"I recently ordered a few pieces from this men's fashion website, and I have to say I'm impressed! The fit is perfect for me as a medium-sized guy. The quality of the materials is top-notch, and the attention to detail in the stitching and design is evident. I'm definitely coming back for more. The fast shipping was an added bonus, too. Great job!"
                    </p>
                    <div class="stars">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                </div>

                   <div class="swiper-slide box">
                    <h3>Alex Rodriguez</h3>
                    <p>
                    "As a guy on the taller side, finding stylish clothes that fit well has always been a challenge. But this website nailed it! The large size options are true to fit, and the selection is fantastic. The trendy styles and comfortable fabrics make it my go-to for fashion. Highly recommend for all the fashion-forward guys out there!"
                    </p>
                    <div class="stars">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-alt"></i>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <h3>Ethan Davis</h3>
                    <p>
                    "I'm a guy with a smaller frame, and finding clothes that don't drown me has always been a struggle. However, this men's fashion website has an incredible range of small sizes that actually fit well! The clothes are not only stylish but also tailored perfectly. It's like they were made just for me. So happy I found this gem!"
                    </p>
                    <div class="stars">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <h3>Ryan Miller</h3>
                    <p>
                    "As an XL guy, it's often frustrating to find fashionable options that don't compromise on style. This website, though, is a game-changer. The XL sizes are roomy and comfortable without sacrificing the trendy designs. The shipping was quick, and the customer service was excellent. I've finally found my go-to destination for menswear!"
                    </p>
                    <div class="stars">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-alt"></i>
                    </div>
                </div>

                <div class="swiper-slide box">
                    <h3>Noah Carter</h3>
                    <p>
                    "It's not easy being an XS in the world of men's fashion, but this website has made it a breeze. The extra-small sizes are perfect, and the variety of styles is impressive. The quality is outstanding, and the shipping was faster than expected. Finally, a place that caters to us smaller guys without compromising on style! I've already recommended it to all my friends."
                    </p>
                    <div class="stars">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                    </div>
                </div>
    </div>
</div>
</section>
 Reviews section ends 
 -->

 <!-- hover image section start -->

 <!--
 <style>

    #imgcontainer {
      margin: 0;
      cursor: pointer;
    }

    #imgcontainer:hover ,+ section {
      background-image: url('long2.jpg'); /* Background image on hover */
    }
 </style>
 <section class="box" style="width:100%;";>
    <img src="long.jpg"></img>
    <div id="imgcontainer">
        <h1>long sleeves</h1>
    </div>
    <div id="imgcontainer">
        <h1>shorts</h1>
    </div>
    <div id="imgcontainer">
        <h1>sport tshirts</h1>
    </div>
    <div id="imgcontainer">
        <h1>polo tshirsts</h1>
    </div>
   

 </section>
-->

<!-- -----------------------------footer---------------------- -->
 <?php  include 'footer.php'; ?>
<!-- footer section ends -->

<!-- swiper linking -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

   <!-- linking the javascript -->
   <script src="script.js"></script>

</body>
</html>