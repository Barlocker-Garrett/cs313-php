<header class="site-header">
    <div class="nav-bar">
        <a href="/assignments/adminConsole/dashboard/">Dashboard</a>
        <a href="/assignments/adminConsole/users/">Users</a>
        <a href="/assignments/adminConsole/inventory/">Inventory</a>
        <?php 
            $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $urlExplode = explode('/', $actual_link);
            $num = (count($urlExplode) - 2);
            if ($urlExplode[$num] == "dashboard") {
                echo "<div class='name'>";
                    echo "<div class='content__container'>";
                        echo "<p class='content__container__text'>Hello&nbsp;</p>";
                        echo "<ul class='content__container__list'>";
                            echo "<li id='showName' class='content__container__list__item'></li>";
                        echo "</ul>";
                    echo "</div>";
                echo "</div>";
            }
        ?>
        <div class="right">
            <a href="/assignments/adminConsole/index.php">Logout</a>
        </div>
        <div id="numItems" class="counter right"></div>
    </div>
</header>