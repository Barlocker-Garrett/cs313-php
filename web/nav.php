<?php 
    function curPageName() {
        return explode("/", $_SERVER["SCRIPT_NAME"])[1];
    }
?>

<div class='container'>
    <nav>
        <div class='nav-wrapper main-nav'>
            <a href='/' class='brand-logo left'>Garrett Barlocker CS 313</a>
            <ul class='right hide-on-med-and-down'>
                <li class='<?php if(curPageName() === 'index.php') {echo 'active';} else {echo 'inactive';}?>'><a href='/'>Home</a></li>
                <li class='<?php if(curPageName() === 'assignments') {echo 'active';} else {echo 'inactive';}?>'><a href='/assignments/'>Assignments</a></li>
            </ul>
        </div>
    </nav>
</div>