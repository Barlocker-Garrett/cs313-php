<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Door Step Dates - Dashboard</title>
    <link href="/materialize/css/materialize.css" type="text/css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="../../cart/css/nav.css" type="text/css" rel="stylesheet">
    <link href="../style/main.css" type="text/css" rel="stylesheet">
    <script src="../../adminConsole/js/charts.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="../../../materialize/js/materialize.js"></script>
    <script src="../../adminConsole/js/admin.js"></script>

</head>

<body onload="saveSession(); loaded();">
    <h3 class="center">Door Step Dates: Dashboard</h3>
    <?php
        include( $_SERVER['DOCUMENT_ROOT'] . '/assignments/adminConsole/nav.php' ); 
    ?>
        <div class="row">
            <div class="col s3">
                <div class="header-label">
                    <p>Active Users</p>
                    <div class="userCounter-container">
                        <span id="userCounter" class="userCounter">0</span>
                    </div>
                </div>
            </div>
            <div class="col s3">
                <div id="chart">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
            <div class="col s3">
                <div id="chart">
                    <canvas id="genderActiveChart"></canvas>
                </div>
            </div>
            <div class="col s3">
                <div class="header-label">
                    <p>Active Paying Users</p>
                    <div class="userCounter-container">
                        <span id="payingCounter" class="userCounter">0</span>
                    </div>
                </div>
            </div>
            <div class="col s3 counter-divider"></div>
            <div class="col s3 counter-divider">
                <div class="header-label">
                    <p>Total Stock</p>
                    <div class="userCounter-container">
                        <span id="inventoryCounter" class="userCounter">0</span>
                    </div>
                </div>
            </div>
            <div class="col s3 counter-divider">
                <div class="header-label">
                    <p>Inventory Lent Out</p>
                    <div class="userCounter-container">
                        <span id="lentOutCounter" class="userCounter">0</span>
                    </div>
                </div>
            </div>
            <div class="col s3 counter-divider"></div>
        </div>

</body>

</html>