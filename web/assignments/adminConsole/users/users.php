<?php 
session_start();
require "../dbConn.php";
$conn = getConn();

$filter = filter_var($_REQUEST['filter'], FILTER_VALIDATE_BOOLEAN);
$orderBy = filter_var($_REQUEST['orderBy'], FILTER_VALIDATE_BOOLEAN);

if ($_REQUEST['action'] == "users") {
    $response = "";
    $query = 'SELECT * FROM users';
    
    if ($filter) {
        $query = addFilters($query);
    }
    if ($orderBy) {
        $query = addOrderBy($query);
    }
    
    $stmt = $conn->prepare($query);
    
    if ($filter) {
        $stmt = bindFilters($stmt);
    }
    
/*    echo var_dump($stmt);*/
    $stmt->execute();
    
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $i = 0;
    foreach ($rows as $row) {
        $i++;
        $response = $response . '<tr>';
        $gender;
        if ($row['ismale'] == 1) {
            $gender = 'M';
        } else {
            $gender =  'F';
        }
        $number = $row['phonenumber'];
        $formattedNumber = "($number[0]$number[1]$number[2])$number[3]$number[4]$number[5]-$number[6]$number[7]$number[8]$number[9]";
        $response = $response . "<td class='td-value'>";$response = $response . $gender;$response = $response . '</td>';
        $response = $response . "<td class='td-value'>";$response = $response . $row['fullname'];$response = $response . '</td>';
        $response = $response . "<td class='td-value'>";$response = $response . $row['birthdate'];$response = $response . '</td>';
        $response = $response . "<td class='td-value'>";$response = $response . $row['height'];$response = $response . '</td>';
        $response = $response . "<td class='td-value'>";$response = $response . $row['weight'];$response = $response . '</td>';
        $response = $response . "<td class='td-value'>";$response = $response . $formattedNumber;$response = $response . '</td>';
        $response = $response . "<td class='td-value'>";$response = $response . $row['email'];$response = $response . '</td>';
        $response = $response . "<td class='td-value'>";$response = $response . $row['streetaddress'];$response = $response . '</td>';
        $response = $response . "<td class='td-value'>";$response = $response . $row['apartmentnumber'];$response = $response . '</td>';
        $response = $response . "<td class='td-value'>";$response = $response . $row['city'];$response = $response . '</td>';
        $response = $response . "<td class='td-value'>";$response = $response . $row['state'];$response = $response . '</td>';
        $response = $response . "<td id='save$i'><input id='button$i' type='button' class='waves-effect waves-red waves-ripple red lighten-2 saveButton' value='Save'></td>";
        $response = $response . '</tr>';
    }

    echo $response;
}

function addFilters($query) {
    $ismale = getIfSet($_REQUEST['ismale']);
    $lentout = getIfSet($_REQUEST['lentout']);
    $fullname = getIfSet($_REQUEST['fullname']);
    
    if ($lentout != null) {
        $query = $query . ' JOIN lentout ON lentout.userid = users.id';
    }
    
    $query = $query . ' WHERE ';
    
    if ($ismale != null) {
        $query = $query . " ismale = :ismale ";
    }
    if ($lentout != null) {
        if ($ismale != null) {
            $query = $query . " AND";
        }
        $query = $query . " checkedout = true AND lentout.inventoryid = :lentout";
    }
    if ($fullname != null) {
        if ($lentout != null || $lentout == null && $ismale != null) {
            $query = $query . " AND";
        }
        $query = $query . " fullname LIKE :fullname";
    }
    
    return $query;
}

function bindFilters($stmt) {
    $ismale = getIfSet($_REQUEST['ismale']);
    $lentout = getIfSet($_REQUEST['lentout']);
    $fullname = getIfSet($_REQUEST['fullname']);
    if ($ismale != null) {
        $stmt->bindParam(':ismale', filter_var($ismale, FILTER_VALIDATE_BOOLEAN), PDO::PARAM_BOOL);
    }
    if ($lentout != null) {
        $stmt->bindParam(':lentout', $lentout, PDO::PARAM_INT);
    }
    if ($fullname != null) {
        $fullname = '%' . $fullname . '%';
        $stmt->bindParam(':fullname', $fullname, PDO::PARAM_STR);
    }
    
    return $stmt;
}

function addOrderBy($query) {
    $query = $query . ' ORDER BY';
    
    $userId = getIfSet($_REQUEST['orderUserId']);
    $fullName = getIfSet($_REQUEST['orderFullName']);
    $gender = getIfSet($_REQUEST['orderGender']);
    $height = getIfSet($_REQUEST['orderHeight']);
    $weight = getIfSet($_REQUEST['orderWeight']);
    
    if ($userId != null) {
        $query = $query . ' users.id,';
    }
    if ($fullName != null) {
        $query = $query . " users.fullname,";
    }
    if ($gender != null) {
        $query = $query . " users.ismale,";
    }
    if ($height != null) {
        $query = $query . " users.height,";
    }
    if ($weight != null) {
        $query = $query . " users.weight,";
    }
    $query = substr($query, 0, -1);

    return $query;
}

function getIfSet(&$value, $default = null)
{
    return isset($value) ? $value : $default;
}

?>