<?php

function hashPass($password) {
    $options = [
        'cost' => 12,
    ];
    $hash = password_hash($password, PASSWORD_BCRYPT, $options);
    return $hash;
}

function checkPass($conn, $email, $password) {
    $valid = false;
    $adminId = null;
    $stmt = $conn->prepare('SELECT password, id FROM adminuser WHERE email=:email');
    $stmt->execute(array(':email' => $email));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($rows as $row) {
        $hash = $row['password'];
        $valid = password_verify ($password, $hash);
        if ($valid) {
            $adminId = $row['id'];
        }
    }
    return array($valid,$adminId);
}

function insertSessionToken($conn, $email, $adminId) {
    session_start();
    session_regenerate_id();
    // UPDATE THE SESSION
    $stmt = $conn->prepare('UPDATE adminsession SET  sessiontoken=:sessiontoken, lastUsed=current_timestamp WHERE adminuserid=:adminuserid');
    $stmt->execute(array(':sessiontoken' => session_id(), ':adminuserid' => $adminId));
    
    // else INSERT THE SESSION
    $stmt = $conn->prepare('INSERT INTO adminsession (sessiontoken, lastUsed, adminUserId) SELECT :sessiontoken, current_timestamp, :adminUserId WHERE NOT EXISTS (SELECT 1 FROM adminsession WHERE adminUserId=:adminUserId)');
    $stmt->execute(array(':sessiontoken' => session_id(), ':adminUserId' => $adminId));
    return session_id();
}

function validSession($conn, $token, $adminUserId) {
    $hourTimeout = 2;
    $stmt = $conn->prepare('SELECT sessiontoken, lastused, adminuserid FROM adminsession WHERE adminuserid=:adminuserid');
    $stmt->execute(array(':adminuserid' => $adminUserId));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        if ($token == $row['sessiontoken']) {
            return currentSession($row['lastused'], $hourTimeout);
        }
    }
}

function currentSession($lastUsed, $hourTimeout) {
    $lastTime = new DateTime($lastUsed);
    $now = new DateTime();

    $diff = $lastTime->diff($now);

    $hours = $diff->h;
    $hours = $hours + ($diff->days*24);
    
    if ($hours <= $hourTimeout) {
        return true;
    } else {
        return false;
    }
}

?>