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
    <?php
    include($_SERVER['DOCUMENT_ROOT'] . '/assignments/adminConsole/fav.php')
    ?>
</head>

<body onload="saveSession();">
    <h3 class="center">Door Step Dates: Users</h3>
    <div class="row">
        <?php
        include( $_SERVER['DOCUMENT_ROOT'] . '/assignments/adminConsole/nav.php' ); 
        ?>
            <div class='col s2'>
                <div class='card-panel'>
                    <span><h5 class="createUser">Create User:</h5><i onclick='createUser();' class='material-icons addFab right'>add</i></span>
                </div>
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
                            <th>Remove</th>
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
                                    $id = $row['id'];
                                    $number = $row['phonenumber'];
                                    $formattedNumber = "($number[0]$number[1]$number[2])$number[3]$number[4]$number[5]-$number[6]$number[7]$number[8]$number[9]";
                                    echo "<td id='isMale$id' class='td-value'>";echo $gender;echo '</td>';
                                    echo "<td id='fullName$id' class='td-value'>";echo $row['fullname'];echo '</td>';
                                    echo "<td id='birthdate$id' class='td-value'>";echo $row['birthdate'];echo '</td>';
                                    echo "<td id='height$id' class='td-value'>";echo $row['height'];echo '</td>';
                                    echo "<td id='weight$id' class='td-value'>";echo $row['weight'];echo '</td>';
                                    echo "<td id='phoneNumber$id' class='td-value'>";echo $formattedNumber;echo '</td>';
                                    echo "<td id='email$id' class='td-value'>";echo $row['email'];echo '</td>';
                                    echo "<td id='address$id' class='td-value'>";echo $row['streetaddress'];echo '</td>';
                                    echo "<td id='apt$id' class='td-value'>";echo $row['apartmentnumber'];echo '</td>';
                                    echo "<td id='city$id' class='td-value'>";echo $row['city'];echo '</td>';
                                    echo "<td id='state$id' class='td-value'>";echo $row['state'];echo '</td>';
                                    echo "<td id='remove$id'> <i class='material-icons trash' onclick='removeUser($id)'>delete</i></td>";
                                    echo "<td id='save$id'><input id='button$id' type='button' class='waves-effect waves-red waves-ripple red lighten-2 saveButton' value='Save' onclick='saveUser($id)'></td>";
                                    echo '</tr>';
                                }
                            ?>
                    </tbody>
                </table>
            </div>
    </div>
    <div id="createUserForm" class="popup">
        <h5>Create User</h5>
        <form id='form-filters'>
            <label for='Gender' class='left userField'>Gender:</label>
            <div class='select-wrapper'>
                <select id='genderCreate' name='Gender'>
                    <option value='true'>Male</option>
                    <option value='false'>Female</option>
                </select>
            </div>
            <div>
                <label for='fullName' class='left userField'>Full Name:</label>
                <input id='fullnameCreate' type='text' class='form-item' name='fullName' placeholder='First Last Name' />
            </div>
            <div>
                <label for='birthdate' class='left userField'>Birthdate:</label>
                <input id='birthdateCreate' type='text' class='form-item' name='birthdate' placeholder='YYYY-MM-DD' />
            </div>
            <div>
                <label for='height' class='left userField'>Height:</label>
                <input id='heightCreate' type='number' class='form-item' name='height' placeholder='Height in inches' />
            </div>
            <div>
                <label for='weight' class='left userField'>Weight:</label>
                <input id='weightCreate' type='number' class='form-item' name='weight' placeholder='Weight in pounds' />
            </div>
            <div>
                <label for='phonenumber' class='left userField'>Phone Number:</label>
                <input id='phonenumberCreate' type='text' class='form-item' name='phonenumber' placeholder='555-555-5555' />
            </div>
            <div>
                <label for='email' class='left userField'>Email:</label>
                <input id='emailCreate' type='text' class='form-item' name='email' placeholder='email@gmail.com' />
            </div>
            <div>
                <label for='password' class='left userField'>Password:</label>
                <input id='passwordCreate' type='password' class='form-item' name='password' />
            </div>
            <div>
                <label for='address' class='left userField'>Street Address:</label>
                <input id='addressCreate' type='text' class='form-item' name='address' />
            </div>
            <div>
                <label for='apt' class='left userField'>Apt #:</label>
                <input id='aptCreate' type='text' class='form-item' name='apt' />
            </div>
            <div>
                <label for='city' class='left userField'>City:</label>
                <input id='cityCreate' type='text' class='form-item' name='city' placeholder='Rexburg' />
            </div>
            <div>
                <label for='state' class='left userField'>State:</label>
                <input id='stateCreate' type='text' class='form-item' name='state' placeholder='Idaho' />
            </div>
        </form>
        <input id='CreateUserButton' type='button' class='right waves-effect waves-red waves-ripple red lighten-2 updateButton' name='close' value="Create User" onclick='createNewUser();'>
    </div>
</body>

</html>