<?php

require '../vendor/autoload.php';


if(isset($_GET['p'])){

    $p = $_GET['p'];

}else{
    
    $p = 'home';

}

ob_start();

if($p === 'home'){

    require '../templates/home.php';

} else if($p === 'post'){

    require '../templates/single.php';

}

$content = ob_get_clean();

require '../templates/default.php';