<?php 
session_start();
require "../dbConn.php";
$conn = getConn();

if ($_REQUEST['action'] == "updateItem") {
    $item = getIfSet($_REQUEST['item']);
    if ($item != null) {
        $response = "";
        $query = 'UPDATE inventory SET itemname=:itemname,instock=:instock,lentout=:lentout,price=:price,replaceprice=:replaceprice WHERE id=:id';
        
        $stmt = $conn->prepare($query);
        $stmt = bindItemValues($stmt, $item);
        /*echo var_dump($stmt);*/
        $stmt->execute();
    } else {
        die();
    }
} else if ($_REQUEST['action'] == "deleteItem") {
    $item = getIfSet($_REQUEST['item']);
    if ($item != null) {
        $response = "";
        // remove any lentout items
        $query = 'DELETE FROM lentout WHERE inventoryid=:id';
        $stmt = $conn->prepare($query);
        $stmt = bindItemID($stmt, $item);
        /*echo var_dump($stmt);*/
        $stmt->execute();
        
        // lastly delete the item
        $query = 'DELETE FROM inventory WHERE id=:id';
        $stmt = $conn->prepare($query);
        $stmt = bindItemID($stmt, $item);
        /*echo var_dump($stmt);*/
        $stmt->execute();
    } else {
        die();
    }
} else if ($_REQUEST['action'] == "insertItem") {
    $item = getIfSet($_REQUEST['item']);
    if ($item != null) {
        $response = "";
        // insert the new item
        $query = "INSERT INTO inventory 
        (itemname,instock,lentout,price,replaceprice) 
        VALUES (:itemname,:stock,:lentout,:price,:replacePrice)";
        $stmt = $conn->prepare($query);
        $stmt = bindItemInsert($stmt, $item);
        /*echo var_dump($stmt);*/
        $stmt->execute();
    } else {
        die();
    }
} else if ($_REQUEST['action'] == "updateItemTable") {
    $response = "";
    $query = 'SELECT * FROM inventory';
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $i = 0;
    foreach ($rows as $row) {
        $response = $response . '<tr>';
        $id = $row['id'];
        $response = $response . "<td id='itemName$id' class='td-value'>";$response = $response . $row['itemname'];$response = $response . '</td>';
        $response = $response . "<td id='stock$id' class='td-value'>";$response = $response . $row['stock'];$response = $response . '</td>';
        $response = $response . "<td id='lentout$id' class='td-value'>";$response = $response . $row['lentout'];$response = $response . '</td>';
        $response = $response . "<td id='price$id' class='td-value'>";$response = $response . number_format((float)$row['price'], 2, '.', '');$response = $response . '</td>';
        $response = $response . "<td id='replacePrice$id' class='td-value'>";$response = $response . number_format((float)$row['replaceprice'], 2, '.', '');$response = $response . '</td>';
        $response = $response . "<td id='remove$id' <i class='material-icons trash' onclick='removeItem($id)'>delete</i></td>";
        $response = $response . "<td id='save$id'><i class='waves-effect waves-red waves-ripple red lighten-2 saveButton waves-input-wrapper' style> <input id='button$id' type='button' class='waves-button-input' value='Save' onclick='saveItem($id)'></td>";
        $response = $response . '</tr>';
    }
    echo $response;
}

function bindItemInsert($stmt, $item) {
    $itemName = getIfSet($item['itemName']);
    $stock = getIfSet($item['stock']);
    $lentout = getIfSet($item['lentout']);
    $price = getIfSet($item['price']);
    $replacePrice = getIfSet($item['replacePrice']);
    
    if ($itemName != null && $stock != null && $lentout != null && $price != null && $replacePrice != null) {
        $stmt->bindParam(':itemname', $itemName, PDO::PARAM_STR);
        $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
        $stmt->bindParam(':lentout', $lentout, PDO::PARAM_INT);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':replacePrice', $replacePrice, PDO::PARAM_STR);
    }
    return $stmt;
}

function bindItemID($stmt, $item) {
    $id = getIfSet($item['id']);
    if ($id != null) {
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    }
    return $stmt;
}

function bindItemValues($stmt, $item) {
    $id = getIfSet($item['id']);
    $itemname = getIfSet($item['itemName']);
    $instock = getIfSet($item['stock']);
    $lentout = getIfSet($item['lentOut']);
    $price = getIfSet($item['price']);
    $replaceprice = getIfSet($item['replacePrice']);
    
    if ($id != null && $itemname != null && $instock != null && $lentout != null && 
       $price != null && $replaceprice != null) {
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':itemname', $itemname, PDO::PARAM_STR);
        $stmt->bindParam(':instock', $instock, PDO::PARAM_INT);
        $stmt->bindParam(':lentout', $lentout, PDO::PARAM_INT);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':replaceprice', $replaceprice, PDO::PARAM_STR);
    }
    return $stmt;
}

function getIfSet(&$value, $default = null)
{
    return isset($value) ? $value : $default;
}