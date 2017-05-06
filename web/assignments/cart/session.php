<?php 
session_start();

$product = $_REQUEST['product'];
$quantity = $_REQUEST['quantity'];

if ($_REQUEST['action'] == "add") {
    if (isset($_SESSION[$product]) && $quantity === null) {
        $old = $_SESSION[$product];
        $_SESSION[$product] = $old + 1;
    } else if ($quantity != null){
        $_SESSION[$product] = $quantity;
    } else {
        $_SESSION[$product] = 1;
    }
} else if ($_REQUEST['action'] == 'subtract') {
    if (isset($_SESSION[$product])) {
        $old = $_SESSION[$product];
        $_SESSION[$product] = $old - 1;
    }
    if ($_SESSION[$product] == 0) {
        unset($_SESSION[$product]);
    }
} else if ($_REQUEST['action'] == 'remove') {
    unset($_SESSION[$product]);
} else if ($_REQUEST['action'] == 'get') {
    $response = "{";
    foreach($_SESSION as $key => $value) 
    { 
        $response = $response . '"' . $key . '":"' . $value . '",'; 
    }
    if (strlen($response) > 1) {
        $response = substr($response,0,-1);
    }
    $response = $response . "}";
    echo $response;
}

?>