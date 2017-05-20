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
                            <th></th>
                        </tr>
                    </thead>

                    <tbody id='userTable'>
                        <?php
                                $stmt = $conn->query('SELECT * FROM inventory ORDER BY id');
                                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                $i = 0;
                                foreach ($rows as $row) {
                                    $i++;
                                    echo '<tr>';
                                    echo "<td class='td-value'>";echo $row['itemname'];echo '</td>';
                                    echo "<td class='td-value'>";echo $row['instock'];echo '</td>';
                                    echo "<td class='td-value'>";echo $row['lentout'];echo '</td>';
                                    echo "<td class='td-value'>";echo '$' . number_format((float)$row['price'], 2, '.', '');echo '</td>';
                                    echo "<td class='td-value'>";echo '$'. number_format((float)$row['replaceprice'], 2, '.', '');echo '</td>';
                                    echo "<td id='save$i'><input id='button$i' type='button' class='waves-effect waves-red waves-ripple red lighten-2 saveButton' value='Save'></td>";
                                    echo '</tr>';
                                }
                            ?>
                    </tbody>
                </table>
            </div>
            <div class='col s2'>
            </div>
    </div>
</body>

</html>