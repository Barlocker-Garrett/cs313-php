<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Door Step Dates - Shop</title>
    <link href="/materialize/css/materialize.css" type="text/css" rel="stylesheet">
    <link href="../cart/css/nav.css" type="text/css" rel="stylesheet">
    <link href="../cart/css/cart.css" type="text/css" rel="stylesheet">
    <link href="../cart/css/main.css" type="text/css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="../cart/js/cart.js"></script>
</head>

<body onload='getItems();'>
    <?php 
            session_start();
            include( $_SERVER['DOCUMENT_ROOT'] . '/assignments/cart/nav.php' ); 
        ?>
    <div class='wrapper'>
        <div class='checkoutForm'>
            <form action='confirmation.php' method='post'>
                <label for='fullName'>Full Name</label>
                <input class='center' type='text' maxlength='50' name='fullName' />
                <br/>
                <label for='streetAddress'>Street Address</label>
                <input class='center' type='text' maxlength='50' name='streetAddress' />
                <br/>
                <label for='state'>State</label>
                <input class='center' type='text' maxlength='50' name='state' />
                <br/>
                <label for='city'>City</label>
                <input class='center' type='text' maxlength='50' name='city' />
                <br/>
                <label for='zip'>Zip Code</label>
                <input class='center' type='number' name='zip' />
                <br/>
                <a href='/assignments/cart/checkout.php'><button class='btn checkout-btn'><i class='material-icons left'>undo</i>Back to Checkout</button></a>
                <button class='btn' type='submit'>Purchase</button>
            </form>
        </div>
    </div>
</body>

</html>