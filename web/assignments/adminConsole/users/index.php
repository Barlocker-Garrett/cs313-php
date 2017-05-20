<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Door Step Dates - Users</title>
    <link href="/materialize/css/materialize.css" type="text/css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../../cart/css/nav.css" type="text/css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="../../adminConsole/js/admin.js"></script>
    <script src="../../adminConsole/js/elementToJSON.js"></script>
    <script src="../../../materialize/js/materialize.js"></script>
    <link href="../style/main.css" type="text/css" rel="stylesheet">
</head>

<body onload="saveSession();">
    <h3 class="center">Door Step Dates: Users</h3>
    <div class="row">
        <?php
        include( $_SERVER['DOCUMENT_ROOT'] . '/assignments/adminConsole/nav.php' ); 
        ?>
            <div class='col s2'>
                <div id='filters' class='card-panel'>
                    <h5>Filters:</h5>
                    <form id='form-filters'>
                        <input id='Gender' type='checkbox' name='Gender' />
                        <label for='Gender'>Gender:</label>
                        <div class='select-wrapper'>
                            <select id='GenderSelect' name='GenderSelect'>
                                <option value='true'>Male</option>
                                <option value='false'>Female</option>
                            </select>
                        </div>

                        <input id='LentOut' type='checkbox' name='LentOut' />
                        <label for='LentOut'>Lentout:</label>
                        <div class='select-wrapper'>
                            <select name='LentOutSelect' id='LentOutSelect'>
                                <?php
                            require "../dbConn.php";
                            $conn = getConn();
                        
                            $stmt = $conn->query('SELECT itemname, id FROM inventory ORDER BY itemname');
                            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($rows as $row) {
                                $itemName = $row['itemname'];
                                $id = $row['id'];
                                echo "<option value='$id'>$itemName</option>";
                            }
                        ?>
                            </select>
                        </div>

                        <input id='FullName' type='checkbox' name='FullName' />
                        <label for='FullName'>User's name:</label>
                        <input type='text' name='fullName' id='fullName' placeholder='First/Last Name' />
                    </form>
                    <input id='UpdateButton' type='button' class='right waves-effect waves-red waves-ripple red lighten-2 refreshButton' value='Update' onclick='updateTable();'>
                    <p>&nbsp;</p>
                </div>

                <div id='orderBy' class='card-panel orderRow'>
                    <h5>Order By:</h5>
                    <ol id="orderBy" class='droptrue'>
                        <input id='OrderByUserID' type='checkbox' name='OrderByUserID' />
                        <label for='OrderByUserID'>
                            <li value='id' class='orderItem'>UserID</li>
                        </label>
                        <input id='OrderByFullName' type='checkbox' name='OrderByFullName' />
                        <label for='OrderByFullName'>
                            <li value='fullname' class='orderItem'>Full Name</li>
                        </label>
                        <input id='OrderByGender' type='checkbox' name='OrderByGender' />
                        <label for='OrderByGender'>
                            <li id="ismale" class='orderItem'>Gender</li>
                        </label>
                        <input id='OrderByHeight' type='checkbox' name='OrderByHeight' />
                        <label for='OrderByHeight'>
                            <li id="height" class='orderItem'>Height</li>
                        </label>
                        <input id='OrderByWeight' type='checkbox' name='OrderByWeight' />
                        <label for='OrderByWeight'>
                            <li id="weight" class='orderItem'>Weight</li>
                        </label>
                    </ol>
                    <input id='OrderButton' type='button' class='right waves-effect waves-red waves-ripple red lighten-2 refreshButton' value='Reorder' onclick='updateTable();'>
                    <p>&nbsp;</p>
                </div>
            </div>
            <div class='col s10'>
                <table class='bordered striped'>
                    <thead>
                        <tr>
                            <th>Gender</th>
                            <th>Full Name</th>
                            <th>Birthdate</th>
                            <th>Height</th>
                            <th>Weight</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Apt #</th>
                            <th>City</th>
                            <th>State</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody id='userTable'>
                        <?php
                                $stmt = $conn->query('SELECT * FROM users ORDER BY id');
                                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                $i = 0;
                                foreach ($rows as $row) {
                                    $i++;
                                    echo '<tr>';
                                    $gender;
                                    if ($row['ismale'] == 1) {
                                        $gender = 'M';
                                    } else {
                                        $gender =  'F';
                                    }
                                    $number = $row['phonenumber'];
                                    $formattedNumber = "($number[0]$number[1]$number[2])$number[3]$number[4]$number[5]-$number[6]$number[7]$number[8]$number[9]";
                                    echo "<td class='td-value'>";echo $gender;echo '</td>';
                                    echo "<td class='td-value'>";echo $row['fullname'];echo '</td>';
                                    echo "<td class='td-value'>";echo $row['birthdate'];echo '</td>';
                                    echo "<td class='td-value'>";echo $row['height'];echo '</td>';
                                    echo "<td class='td-value'>";echo $row['weight'];echo '</td>';
                                    echo "<td class='td-value'>";echo $formattedNumber;echo '</td>';
                                    echo "<td class='td-value'>";echo $row['email'];echo '</td>';
                                    echo "<td class='td-value'>";echo $row['streetaddress'];echo '</td>';
                                    echo "<td class='td-value'>";echo $row['apartmentnumber'];echo '</td>';
                                    echo "<td class='td-value'>";echo $row['city'];echo '</td>';
                                    echo "<td class='td-value'>";echo $row['state'];echo '</td>';
                                    echo "<td id='save$i'><input id='button$i' type='button' class='waves-effect waves-red waves-ripple red lighten-2 saveButton' value='Save'></td>";
                                    echo '</tr>';
                                }
                            ?>
                    </tbody>
                </table>
            </div>
    </div>
</body>

</html>