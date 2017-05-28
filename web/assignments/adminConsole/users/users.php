<?php 
session_start();
require "../dbConn.php";
$conn = getConn();

if ($_REQUEST['action'] == "users") {
    $filter = filter_var($_REQUEST['filter'], FILTER_VALIDATE_BOOLEAN);
    $orderBy = filter_var($_REQUEST['orderBy'], FILTER_VALIDATE_BOOLEAN);
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
        $id = $row['id'];
        $number = $row['phonenumber'];
        $formattedNumber = "($number[0]$number[1]$number[2])$number[3]$number[4]$number[5]-$number[6]$number[7]$number[8]$number[9]";
        $response = $response . "<td id='isMale$id' class='td-value'>";$response = $response . $gender;$response = $response . '</td>';
        $response = $response . "<td id='fullName$id' class='td-value'>";$response = $response . $row['fullname'];$response = $response . '</td>';
        $response = $response . "<td id='birthdate$id' class='td-value'>";$response = $response . $row['birthdate'];$response = $response . '</td>';
        $response = $response . "<td id='height$id' class='td-value'>";$response = $response . $row['height'];$response = $response . '</td>';
        $response = $response . "<td id='weight$id' class='td-value'>";$response = $response . $row['weight'];$response = $response . '</td>';
        $response = $response . "<td id='phoneNumber$id' class='td-value'>";$response = $response . $formattedNumber;$response = $response . '</td>';
        $response = $response . "<td id='email$id' class='td-value'>";$response = $response . $row['email'];$response = $response . '</td>';
        $response = $response . "<td id='address$id' class='td-value'>";$response = $response . $row['streetaddress'];$response = $response . '</td>';
        $response = $response . "<td id='apt$id' class='td-value'>";$response = $response . $row['apartmentnumber'];$response = $response . '</td>';
        $response = $response . "<td id='city$id' class='td-value'>";$response = $response . $row['city'];$response = $response . '</td>';
        $response = $response . "<td id='state$id' class='td-value'>";$response = $response . $row['state'];$response = $response . '</td>';
        $response = $response . "<td id='remove$id' <i class='material-icons trash' onclick='removeUser($id)'>delete</i></td>";
        $response = $response . "<td id='save$id'><i class='waves-effect waves-red waves-ripple red lighten-2 saveButton waves-input-wrapper' style> <input id='button$id' type='button' class='waves-button-input' value='Save' onclick='saveUser($id)'></td>";
        $response = $response . '</tr>';
    }

    echo $response;
} else if ($_REQUEST['action'] == "updateUser") {
    $user = getIfSet($_REQUEST['user']);
    if ($user != null) {
        $response = "";
        $query = 'UPDATE users SET email=:email, fullname=:fullname, birthdate=:birthdate, height=:height, weight=:weight, phonenumber=:phonenumber, streetaddress=:streetaddress, apartmentnumber=:apartmentnumber, city=:city, state=:state, ismale=:ismale WHERE id=:id';
        
        $stmt = $conn->prepare($query);
        $stmt = bindUserValues($stmt, $user);
        /*echo var_dump($stmt);*/
        $stmt->execute();
    } else {
        die();
    }
} else if ($_REQUEST['action'] == "deleteUser") {
    $user = getIfSet($_REQUEST['user']);
    if ($user != null) {
        $response = "";
        // remove any charges
        $query = 'DELETE FROM charge WHERE userid=:id';
        $stmt = $conn->prepare($query);
        $stmt = bindUserID($stmt, $user);
        /*echo var_dump($stmt);*/
        $stmt->execute();
        
        // remove any lentout items
        $query = 'DELETE FROM lentout WHERE userid=:id';
        $stmt = $conn->prepare($query);
        $stmt = bindUserID($stmt, $user);
        /*echo var_dump($stmt);*/
        $stmt->execute();
        
        // remove any subscriptions
        $query = 'DELETE FROM subscription WHERE userid=:id';
        $stmt = $conn->prepare($query);
        $stmt = bindUserID($stmt, $user);
        /*echo var_dump($stmt);*/
        $stmt->execute();
        
        // lastly delete the user
        $query = 'DELETE FROM users WHERE id=:id';
        $stmt = $conn->prepare($query);
        $stmt = bindUserID($stmt, $user);
        /*echo var_dump($stmt);*/
        $stmt->execute();
    } else {
        die();
    }
} else if ($_REQUEST['action'] == "insertUser") {
    $user = getIfSet($_REQUEST['user']);
    if ($user != null) {
        $response = "";

        // insert the new user
        $query = "INSERT INTO users 
        (email,password,fullname,firstname,lastname,
        birthdate,height,weight,phonenumber,streetaddress,apartmentnumber,
        city,state,ismale,active) 
        VALUES (:email,:password,:fullname,:firstname,:lastname,
        :birthdate,:height,:weight,:phonenumber,:streetaddress,:apartmentnumber,
        :city,:state,:ismale,'1')";
        $stmt = $conn->prepare($query);
        $stmt = bindUserInsert($stmt, $user);
        /*echo var_dump($stmt);*/
        $stmt->execute();
    } else {
        die();
    }
}

function bindUserInsert($stmt, $user) {
    $email = getIfSet($user['email']);
    $password = getIfSet($user['password']);
    $fullname = getIfSet($user['fullname']);
    $firstname = " "; 
    $lastname = " ";
    $birthdate = getIfSet($user['birthdate']);
    $height = getIfSet($user['height']);
    $weight = getIfSet($user['weight']);
    $phonenumber = getIfSet($user['phonenumber']);
    $streetaddress = getIfSet($user['address']);
    $apartment = getIfSet($user['apt']);
    $city = getIfSet($user['city']);
    $state = getIfSet($user['state']);
    $ismale = getIfSet($user['ismale']);
    
    /*echo "outside" . $user;*/
    
    if ($email != null && $password != null && $fullname != null && $birthdate != null && $height != null && 
       $weight != null && $phonenumber != null && $streetaddress != null && $apartment != null && 
       $city != null && $state != null && $ismale != null && $firstname != null && $lastname != null) {
        
        $names = explode(" ", $fullname);
        $firstname = names[0];
        $lastname = end($names);
        
        $hash = hashPass($password);
        
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hash, PDO::PARAM_STR);
        $stmt->bindParam(':fullname', $fullname, PDO::PARAM_STR);
        $stmt->bindParam(':firstname', $fullname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $fullname, PDO::PARAM_STR);
        $stmt->bindParam(':birthdate', $birthdate, PDO::PARAM_STR);
        $stmt->bindParam(':height', $height, PDO::PARAM_INT);
        $stmt->bindParam(':weight', $weight, PDO::PARAM_INT);
        $stmt->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR);
        $stmt->bindParam(':streetaddress', $streetaddress, PDO::PARAM_STR);
        $stmt->bindParam(':apartmentnumber', $apartment, PDO::PARAM_STR);
        $stmt->bindParam(':city', $city, PDO::PARAM_STR);
        $stmt->bindParam(':state', $state, PDO::PARAM_STR);
        $stmt->bindParam(':ismale', filter_var($ismale, FILTER_VALIDATE_BOOLEAN), PDO::PARAM_BOOL);
    }
    
    return $stmt;
}

function hashPass($password) {
    $options = [
        'cost' => 12,
    ];
    $hash = password_hash($password, PASSWORD_BCRYPT, $options);
    return $hash;
}

function bindUserID($stmt, $user) {
    $id = getIfSet($user['id']);
    if ($id != null) {
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    }
    return $stmt;
}

function bindUserValues($stmt, $user) {
    $id = getIfSet($user['id']);
    $email = getIfSet($user['email']);
    $fullname = getIfSet($user['fullname']);
    $birthdate = getIfSet($user['birthdate']);
    $height = getIfSet($user['height']);
    $weight = getIfSet($user['weight']);
    $phonenumber = getIfSet($user['phonenumber']);
    $streetaddress = getIfSet($user['address']);
    $apartment = getIfSet($user['apt']);
    $city = getIfSet($user['city']);
    $state = getIfSet($user['state']);
    $ismale = getIfSet($user['ismale']);
    
    if ($email != null && $fullname != null && $birthdate != null && $height != null && 
       $weight != null && $phonenumber != null && $streetaddress != null && $apartment != null && 
       $city != null && $state != null && $ismale != null && $id != null) {
        
        if ($ismale == 'M' || $ismale == 'm') {
            $ismale = 1; 
        } else if ($ismale == 'F' || $ismale == 'f') {
            $ismale = 0;
        } else {
            die();
        }
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':fullname', $fullname, PDO::PARAM_STR);
        $stmt->bindParam(':birthdate', $birthdate, PDO::PARAM_STR);
        $stmt->bindParam(':height', $height, PDO::PARAM_INT);
        $stmt->bindParam(':weight', $weight, PDO::PARAM_INT);
        $stmt->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR);
        $stmt->bindParam(':streetaddress', $streetaddress, PDO::PARAM_STR);
        $stmt->bindParam(':apartmentnumber', $apartment, PDO::PARAM_STR);
        $stmt->bindParam(':city', $city, PDO::PARAM_STR);
        $stmt->bindParam(':state', $state, PDO::PARAM_STR);
        $stmt->bindParam(':ismale', filter_var($ismale, FILTER_VALIDATE_BOOLEAN), PDO::PARAM_BOOL);
    }
    
    return $stmt;
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