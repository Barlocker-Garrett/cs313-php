<?php 
session_start();
require "../dbConn.php";
$conn = getConn();

if ($_REQUEST['action'] == "getName") {
    
    $id = $_REQUEST['userId'];
    $name = null;
    $stmt = $conn->prepare('SELECT firstname FROM adminuser WHERE id=:id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($rows as $row) {
        $name = $row['firstname'];
    }
    $response = "{";
    $response = $response . '"name":"' . $name . '"';
    $response = $response . "}";
    
    echo $response;
} else if ($_REQUEST['action'] == "dashboardData") {
    
    $girls = null;
    $guys = null;
    $inactiveGirls = null;
    $inactiveGuys = null;
    $payingUsers = null;
    $stmt = $conn->query('SELECT COUNT(*) FROM users WHERE active = true GROUP BY ismale ORDER BY ismale');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        if ($girls == null) {
            $girls = $row['count'];
        } else {
            $guys = $row['count'];
        }
    }
    $stmt = $conn->query('SELECT COUNT(*) FROM users WHERE active = false GROUP BY ismale ORDER BY ismale');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        if ($inactiveGirls == null) {
            $inactiveGirls = $row['count'];
        } else {
            $inactiveGuys = $row['count'];
        }
    }
    $stmt = $conn->query('SELECT COUNT(DISTINCT users.id) FROM users JOIN charge ON charge.userid = users.id WHERE active = true');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        $payingUsers = $row['count'];
    }
    $stmt = $conn->query('SELECT COUNT(id) FROM inventory');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        $totalStock = $row['count'];
    }
    $stmt = $conn->query('SELECT COUNT(id) FROM lentout WHERE checkedout = true');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        $lentOut = $row['count'];
    }
    $response = "{";
    $response = $response . '"activeGirls":' . $girls . ',';
    $response = $response . '"activeGuys":' . $guys . ',';
    $response = $response . '"inactiveGirls":' . $inactiveGirls . ',';
    $response = $response . '"inactiveGuys":' . $inactiveGuys . ',';
    $response = $response . '"payingUsers":' . $payingUsers . ',';
    $response = $response . '"totalStock":' . $totalStock . ',';
    $response = $response . '"lentOut":' . $lentOut . '';
    $response = $response . "}";
    
    echo $response;
}
?>