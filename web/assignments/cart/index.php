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
        array("Bonfire Equipment","Hot Dog rosters, lighter","What's better than a bonfire? Use our equipment and head to the dunes.", "bonfire.jpg", "bonfire"),
        
        array("Finger Painting","Paint, table cloth, paper, timer","There is a list of cards with items that needs to be drawn with your fingers. Keep tally of how many items are correctly drawn and whoever has the most within 7 minutes wins.", "fingerPainting.jpg", "fingerPainting"),
        
        array("Paper Lanterns","Paper Lanterns, lighters","These paper lanterns are awesome. Meet with your date, decorate them, light them up and watch them fly.", "paperLantern.jpg", "paperLantern"),
        
        array("Inner Tubes","Tubes","This is a really gentle flowing river that goes for about a mile in a “U” shape. Park you car at the beginning and take about 10 minutes to walk back. Great float for spring/summer. Warm Slough Address: 4705 W 4000 N, Rexburg, ID 83440", "innerTube.jpg", "innnerTube"),
        
        array("Nerf Gun War","Nerf guns, nerf bullets","Dress casually as it can usually get hot from running around. Split up teams and set up bases. Choose guns and split ammo equally.Fight until the last person is out.One shot and you’re dead", "nerfGun.jpg", "neftGun"),
        
        array("Miniture Golf","4+ putters, hole, obstacles, scorecard","Play outside or indoors against another couple.Play a full 18 holes.Decide on each hole where to start, where the hole is and what is par.Keep your score on a scorecard and see who wins!", "golf.jpg", "golf"),
        
        array("Cookies","Cookie mix, trays, plates","Bake some cookies together. Play games and talk while waiting. Put the cookies on a plate and go deliver them to people in your ward, random people, bishopric members or anyone you have in mind. Eat some too.", "cookies.jpg", "cookies"),
        
        array("Crayon Candles","Crayons, wick, dixie cup","Peel off adhesive and attach to the wick. Attach the wick to the bottom of the glass container. Unwrap crayons from paper and break them up. Keep each color separate Put each color in a dixie cup. Add one scent cube to each cup and some clear wax.", "crayons.jpg", "crayons"),
        
        array("Toothpick Tower","Bag of small marshmallows, Toothpicks","Make sure you have the same amount of toothpick and marshmallows on each team and see who can build the tallest tower. Possibly light them on fire afterwards.", "toothpick.jpg", "toothpick"),
        
        array("DIY Bag Kite","Plastic bag, straws, tape, scissors, Sharpie, string","Feel free to decorate them and see how they fly. If you want to get it off of the ground you might have to use some smarts in your design.", "kite.jpg", "kite"),
        
        array("Lemonade Stand","Large cooler with liquid dispenser, lemons and sugar or lemonade mix water, plastic cups","Take your group out on a hot sunny day and set up a stand in a crowded place with a sign saying “Free lemonade.” If anyone asks why say, “Just cause.” Talk with the group, play games, bring some chalk and draw on the sidewalk.", "lemonade.jpg", "lemonade"),
        
        array("Tin foil Dinner","Tin foil, tongs, cooking ingredients (Ex. Beef, potatoes, onions, carrots, mushrooms)","You can find recipes for these online but the basic idea is to combine food inside tinfoil and let it cook inside the foil. This is really fun to do at a bonfire. Make sure you cook over coals if you cook on a fire. Also make sure you wrap it really well so nothing falls out.", "tinFoil.jpg", "tinFoil")
    );
        
    for ($item = 0; $item < sizeof($items); $item++) {
        $id = $items[$item][4];
        $image = $items[$item][3];
        $title = $items[$item][0];
        $content = $items[$item][2];
        $fabId = 'fab-'.$id;
                echo "<div class='col s6 m3'>
                        <div id='$id' class='card'>
                            <div class='card-image'>
                                <img src='/images/$image'>
                                <span class='card-title card-panel card-label'>$title</span>
                                <a id='$fabId' onclick='subtractItem(this)' class='btn-floating halfway-fab left waves-effect waves-light red subtract'><i class='material-icons'>remove</i></a>
                                <a id='$fabId' onclick='addItem(this)' class='btn-floating halfway-fab waves-effect waves-light red'><i class='material-icons'>add</i></a>
                            </div>
                            <div class='card-content'>
                                <p>$content</p>
                            </div>
                        </div>
                    </div>";
    }
    ?>

        <?php
        include( $_SERVER['DOCUMENT_ROOT'] . '/assignments/cart/footer.php' ); 
    ?>
    </div>
</body>

</html>