<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Door Step Dates - Inventory</title>
    <link href="/materialize/css/materialize.css" type="text/css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../../cart/css/nav.css" type="text/css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="../../adminConsole/js/admin.js"></script>
    <script src="../../../materialize/js/materialize.js"></script>
    <link href="../style/main.css" type="text/css" rel="stylesheet">
    <?php
    include($_SERVER['DOCUMENT_ROOT'] . '/assignments/adminConsole/fav.php')
    ?>
</head>

<body onload="saveSession();">
    <h3 class="center">Door Step Dates: Inventory</h3>
    <div class="row">
        <?php
            include( $_SERVER['DOCUMENT_ROOT'] . '/assignments/adminConsole/nav.php' ); 
            require "../dbConn.php";
            $conn = getConn();
        ?>
            <div class='col s2'>
                <div class='card-panel'>
                    <span><h5 class="createUser">Create Inventory Item:</h5><i onclick='createItem();' class='material-icons addFab right'>add</i></span>
                </div>
            </div>
            <div class='col s8'>
                <table class='bordered striped'>
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Stock</th>
                            <th>Lent Out</th>
                            <th>Price</th>
                            <th>Replace Price</th>
                            <th>Remove</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody id='userTable'>
                        <?php
                                $stmt = $conn->query('SELECT * FROM inventory ORDER BY id');
                                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                $i = 0;
                                foreach ($rows as $row) {
                                    $id = $row['id'];
                                    $i++;
                                    echo '<tr>';
                                    echo "<td id='itemName$id' class='td-value'>";echo $row['itemname'];echo '</td>';
                                    echo "<td id='stock$id' class='td-value'>";echo $row['instock'];echo '</td>';
                                    echo "<td id='lentout$id' class='td-value'>";echo $row['lentout'];echo '</td>';
                                    echo "<td id='price$id' class='td-value'>";echo '$' . number_format((float)$row['price'], 2, '.', '');echo '</td>';
                                    echo "<td id='replacePrice$id' class='td-value'>";echo '$'. number_format((float)$row['replaceprice'], 2, '.', '');echo '</td>';
                                    echo "<td id='remove$id'> <i class='material-icons trash' onclick='removeItem($id)'>delete</i></td>";
                                    echo "<td id='save$id'><input id='button$id' type='button' class='waves-effect waves-red waves-ripple red lighten-2 saveButton' value='Save' onclick='saveItem($id)'></td>";
                                    echo '</tr>';
                                }
                            ?>
                    </tbody>
                </table>
            </div>
            <div class='col s2'>
            </div>
    </div>
    <div id="createItemForm" class="popup">
        <h5>Create Item</h5>
        <form id='form-filters'>
            <div>
                <label for='itemName' class='left userField'>Item Name:</label>
                <input id='itemNameCreate' type='text' class='form-item' name='itemName'/>
            </div>
            <div>
                <label for='stock' class='left userField'>Current Stock:</label>
                <input id='stockCreate' type='number' class='form-item' name='stock' />
            </div>
            <div>
                <label for='lentout' class='left userField'>Lent Out:</label>
                <input id='lentoutCreate' type='number' class='form-item' name='lentout' />
            </div>
            <div>
                <label for='price' class='left userField'>Price:</label>
                <input id='priceCreate' type='number' class='form-item' name='price'/>
            </div>
            <div>
                <label for='replacePrice' class='left userField'>Replace Price:</label>
                <input id='replacePriceCreate' type='number' class='form-item' name='replacePrice' />
            </div>
        </form>
        <input id='CreateUserButton' type='button' class='right waves-effect waves-red waves-ripple red lighten-2 updateButton' name='close' value="Create Item" onclick='createNewItem();'>
    </div>
</body>

</html>