<?php

// Validate Admin - User and Password

function validAdmin($user, $pass){

    $found = 0;

    $handle = fopen('../../data/admin.txt', 'r');
    while (!feof($handle)) {
        $line = fgets($handle, 1024);
        $elements = explode(',', $line);
        list($first, $second) = $elements;
        $first = trim($first);
        $second = trim($second);
        if ($user == $first && $pass == $second){
            $found = 1;
        }
    }
    fclose($handle);

    return $found;
}

// Validate Member - User and Password

function validUser($user, $pass){

    $found = 0;
    $users = '../../data/users.txt';

    $handle = fopen($users, 'r');
    while (!feof($handle)) {
        $line = fgets($handle, 1024);
        $elements = explode(',', $line);
        if(!empty($elements[4]) && !empty($elements[5])){
            $username = $elements[4];
            $password = $elements[5];
            $username = trim($username);
            $password = trim($password);
            if ($user == $username && $pass == $password){
                $found = 1;
                break;
            } else {
                $found = 0;
            }
        }

    }
    fclose($handle);

    return $found;
}

// Welcome message

function TimeMsg (){

    $msg = 'Hello! ';
    if (date('H') < 12) {
        $msg = 'Good morning! ';
    } else if (date('H') > 11 && date('H') < 18) {
        $msg = 'Good afternoon! ';
    } else if (date('H') > 17) {
        $msg = 'Good evening! ';
    }
    echo $msg;

}

//////////////
// Admin Page
//////////////

//Output value

function valCheck ($input) {

 if($input !== '') {
     $input = htmlentities($input);
     echo $input;
 } else {
     false;
 }

}

//Check if member of stuff exist

function existUser($data){

    $exist = false;
    $users = '../../../../data/users.txt';

    if( strpos(file_get_contents($users),$data) !== false) {
        $exist = true;
    }

    return $exist;
}

//Write a member of stuff

function addUser($data){

        $users = '../../../../data/users.txt';
        $file = fopen($users, 'a');
        fwrite($file, $data.PHP_EOL);
        fclose($file);

}