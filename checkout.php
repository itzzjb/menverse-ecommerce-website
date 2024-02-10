<?php
require_once 'stripe-php-13.7.0-beta.1/init.php';
require_once 'config.php';
session_start();

if(isset($_SESSION['user_id'])){
    $id=$_SESSION['user_id'];
} else {
    header('location: login.php'); 
}

$stripe = new \Stripe\StripeClient(STRIPE_SECRET_KEY);

$lineItems = [];
$cart=mysqli_query($conn,"SELECT * FROM product_info INNER JOIN cart ON product_info.pId =  cart.PId WHERE UId = '$id'" )or die('query failed');


if(mysqli_num_rows($cart) > 0){
    while($row = mysqli_fetch_assoc($cart)){
        $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $row['pName'],
                    ],
                    'unit_amount' => $row['pPrice']*100,
                ],
                'quantity' => $row['Quantity'],
        ];
    }
}

// Create Stripe checkout session
$checkoutSession = $stripe->checkout->sessions->create([
    'line_items' => $lineItems,
    'mode' => 'payment',
    'success_url' => 'http://localhost/website/checkout-success.php?provider_session_id={CHECKOUT_SESSION_ID}',
    'cancel_url' => 'http://localhost/website/payment.php?provider_session_id={CHECKOUT_SESSION_ID}'
]);

// Retrieve provider_session_id. Store in database.
//$checkoutSession->id;

$testCardNumber = '4242424242424242';

// Send user to Stripe
header('Content-Type: application/json');
header("HTTP/1.1 303 See Other");
header("Location: " . $checkoutSession->url);
exit;