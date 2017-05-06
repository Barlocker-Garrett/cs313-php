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
    <div class="row">
        <?php 
        session_start();
        include( $_SERVER['DOCUMENT_ROOT'] . '/assignments/cart/nav.php' ); 

    $items = array(
        array("Bonfire Equipment","Hot Dog rosters, lighter","What's better than a bonfire? Use our equipment and head to the dunes.", "bonfire.jpg", "bonfire", 3),
        
        array("Finger Painting","Paint, table cloth, paper, timer","There is a list of cards with items that needs to be drawn with your fingers. Keep tally of how many items are correctly drawn and whoever has the most within 7 minutes wins.", "fingerPainting.jpg", "fingerPainting", 2.50),
        
        array("Paper Lanterns","Paper Lanterns, lighters","These paper lanterns are awesome. Meet with your date, decorate them, light them up and watch them fly.", "paperLantern.jpg", "paperLantern", 3.50),
        
        array("Inner Tubes","Tubes","This is a really gentle flowing river that goes for about a mile in a “U” shape. Park you car at the beginning and take about 10 minutes to walk back. Great float for spring/summer. Warm Slough Address: 4705 W 4000 N, Rexburg, ID 83440", "innerTube.jpg", "innnerTube", 7.50),
        
        array("Nerf Gun War","Nerf guns, nerf bullets","Dress casually as it can usually get hot from running around. Split up teams and set up bases. Choose guns and split ammo equally.Fight until the last person is out.One shot and you’re dead", "nerfGun.jpg", "neftGun", 6),
        
        array("Miniture Golf","4+ putters, hole, obstacles, scorecard","Play outside or indoors against another couple.Play a full 18 holes.Decide on each hole where to start, where the hole is and what is par.Keep your score on a scorecard and see who wins!", "golf.jpg", "golf", 4),
        
        array("Cookies","Cookie mix, trays, plates","Bake some cookies together. Play games and talk while waiting. Put the cookies on a plate and go deliver them to people in your ward, random people, bishopric members or anyone you have in mind. Eat some too.", "cookies.jpg", "cookies", 5),
        
        array("Crayon Candles","Crayons, wick, dixie cup","Peel off adhesive and attach to the wick. Attach the wick to the bottom of the glass container. Unwrap crayons from paper and break them up. Keep each color separate Put each color in a dixie cup. Add one scent cube to each cup and some clear wax.", "crayons.jpg", "crayons", 4),
        
        array("Toothpick Tower","Bag of small marshmallows, Toothpicks","Make sure you have the same amount of toothpick and marshmallows on each team and see who can build the tallest tower. Possibly light them on fire afterwards.", "toothpick.jpg", "toothpick", 3.5),
        
        array("DIY Bag Kite","Plastic bag, straws, tape, scissors, Sharpie, string","Feel free to decorate them and see how they fly. If you want to get it off of the ground you might have to use some smarts in your design.", "kite.jpg", "kite", 2.5),
        
        array("Lemonade Stand","Large cooler with liquid dispenser, lemons and sugar or lemonade mix water, plastic cups","Take your group out on a hot sunny day and set up a stand in a crowded place with a sign saying “Free lemonade.” If anyone asks why say, “Just cause.” Talk with the group, play games, bring some chalk and draw on the sidewalk.", "lemonade.jpg", "lemonade", 7),
        
        array("Tin foil Dinner","Tin foil, tongs, cooking ingredients (Ex. Beef, potatoes, onions, carrots, mushrooms)","You can find recipes for these online but the basic idea is to combine food inside tinfoil and let it cook inside the foil. This is really fun to do at a bonfire. Make sure you cook over coals if you cook on a fire. Also make sure you wrap it really well so nothing falls out.", "tinFoil.jpg", "tinFoil", 8)
    );
        
        echo "<div class='container'>
                    <h1>Cart</h1>
                    <table class='table table-xs'>
                        <tr class='odd'>
                            <th></th>
                            <th class='text-right'>Remove</th>
                            <th>Description</th>
                            <th class='text-right'>Quantity</th>
                            <th class='text-right'>Price</th>
                            <th class='text-right'>Total</th>
                        </tr>";
        $grandTotal = 0;
        $even = true;
        foreach($_SESSION as $key => $quantity) 
        { 
            for ($item = 0; $item < sizeof($items); $item++) {
                if ($items[$item][4] === substr($key,4)) {
                    if ($even) {
                        $highlightEven = 'even';
                        $even = false;
                    } else {
                        $highlightEven = 'odd';
                        $even = true;
                    }
                    $id = $items[$item][4];
                    $image = $items[$item][3];
                    $title = $items[$item][0];
                    $included = $items[$item][1];
                    $content = $items[$item][2];
                    $fabId = 'fab-'.$id;
                    $priceId = 'price-'.$fabId;
                    $totalId = 'total-'.$fabId;
                    $price = $items[$item][5];
                    $total = $price * $quantity;
                    $grandTotal += $total;
                    $displayPrice = '$' . number_format((float)$price, 2, '.', '');
                    $displayTotal = '$' . number_format((float)$total, 2, '.', '');
                    echo "<tr class='item-row $highlightEven' id='row-$fabId'>
                            <td> <img class='cart-image' src='/images/$image'/></td>
                            <td class='text-right' title='Remove $title'><i id='$fabId' onclick='removeItem(this);' class='material-icons'>delete</i></td>
                            <td>
                                <p> <strong>$title</strong></p>
                                <p>$included</p>
                            </td>
                            <td class='text-right' title='Quantity'><input class='quantity' type='number' value='$quantity' onchange='updateQuantity(this);' name='$fabId' min='0' max='99'/></td>
                            <td class='text-right' title='Price' id='$priceId'>$displayPrice</td>
                            <td class='text-right total' title='Total' id='$totalId'>$displayTotal</td>
                        </tr>";
                }
            }
        }

        $displayGrandTotal = '$' . number_format((float)$grandTotal, 2, '.', '');
        echo "<tr id='grandTotalRow' class='total-row info'>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong>Grand Total:</strong></td>
                            <td id='grandTotal'>$displayGrandTotal</td>
                        </tr>
                </table>
            </div>";
        
        echo "<div class='center'>
                <a href='/assignments/cart'><button class='btn backToShop-btn'><i class='material-icons left'>undo</i>Return to Shop</button></a>
                <a href='/assignments/cart/checkout.php'><button class='btn checkout-btn'>Checkout<i class='material-icons right'>credit_card</i></button></a>
              </div>";
    ?>

        <?php
        include( $_SERVER['DOCUMENT_ROOT'] . '/assignments/cart/footer.php' ); 
    ?>
    </div>
</body>

</html>