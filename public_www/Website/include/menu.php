<?php
    $menu = array(
        'index.php' => 'Home',
        'data/SuperUser/admin.php' => 'Administrator',
        'intra.php' => 'Intranet'
    );

    foreach ($menu as $index => $name ){
        echo '<li><a href="'.$index.'">'.$name.'</a></li>';
    }
