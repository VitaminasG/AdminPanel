<?php
session_start();
// a new session, deleting the previous session data.
session_regenerate_id(TRUE);

// defining empty variables;
$user = '';
$pass = '';
// if session exist insert in to variables and send to form;
if(isset($_SESSION['user']) && isset($_SESSION['pass'])){
    $user = $_SESSION['user'];
    $pass = $_SESSION['pass'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>P1-FMA</title>
    <link rel="stylesheet" type="text/css" href="css/style.css?v=1.1">
</head>
<body>
<header>
    <h1>Final Marked Assignment (P1-FMA)</h1>
    <nav>
        <ul>
            <?php include 'menu.php'?>
        </ul>
        <?php
        // Login form validation;
        $submit = 'Log In';
        $submited = false;
        $error = array();

        $clean = array();
        $wrong = array();

        $error_IS = false;
        $self = htmlentities($_SERVER['PHP_SELF']);

        if (isset($_POST['submit'])){
            $submited = true;
            // Username;
            if (isset($_POST['uname'])){
                $user = trim($_POST['uname']);
                if (ctype_alpha($_POST['uname'])){
                    $clean['user'] = htmlentities($user);
                } else {
                    $wrong['user'] = htmlentities($user);
                    $error_IS = true;
                    $error['uname'] = 'Incorect Username! Only letters.';
                }
            }

            // Password;
            if (isset($_POST['pass'])){
                $pass = trim($_POST['pass']);
                if (ctype_alnum($_POST['pass'])){
                    $clean['pass'] = htmlentities($pass);
                } else {
                    $wrong['pass'] = htmlentities($pass);
                    $error_IS = true;
                    $error['pass'] = 'Incorect Password! Only letters and numbers';
                }
            }

        }

            ?>
            <!--    Checking if details match admin details    -->
        <?php if(validAdmin($user, $pass) == 1 ){ ?>
            <?php
            $username = $user;
            $password = $pass;
            $level = 1;
            $_SESSION['user'] = $username;
            $_SESSION['pass'] = $password;
            $_SESSION['level'] = $level;
            ?>
            <div class="logout">
                <p><?php TimeMsg(); echo htmlentities($user); ?>.</p>
                <a class="link" href="include/logout.php" >Logout</a>
            </div>
            <!--    Checking if details match user details    -->
        <?php } elseif (validUser($user, $pass) == 1){ ?>
            <?php
                $username = $user;
                $password = $pass;
                $level = 2;
                $_SESSION['user'] = $username;
                $_SESSION['pass'] = $password;
                $_SESSION['level'] = $level;
            ?>
            <div class="logout">
                <p><?php TimeMsg(); echo htmlentities($user); ?>.</p>
                <a class="link" href="include/logout.php" >Logout</a>
            </div>
            <!--     if non of above match and not empty fields, show message to try again       -->
        <?php } elseif ($user != '' && $pass != '' && validUser($user, $pass) == 0 && validAdmin($user, $pass) == 0){ ?>
            <div class="logout">
                <p>Incorrect login details</p>
                <a class="link" href="index.php" >Try again.</a>
            </div>
        <?php }else{ ?>
<!-- Login form with error fields -->
        <form method="post" action="<?php echo $self; ?>">

            <div class="container">
                <label for="user">Username</label>
                <input value="<?php if(!empty($wrong['user'])){echo $wrong['user'];} ?>" type="text" name="uname" id="user">

                <label for="password">Password</label>
                <input value="<?php if(!empty($wrong['pass'])){echo $wrong['pass'];}?>" type="password" name="pass" id="password">

                <input type="submit" name="submit" value="<?php echo htmlentities($submit); ?>">
            </div>
        </form>
        <div class="errorList">
            <?php if ($error_IS == true && !empty($error['uname'])){
                echo '<span class="small_error">'.$error['uname'].'</span>';
            }?>
            <?php if ($error_IS == true && !empty($error['pass'])){
                echo '<span class="small_error">'.$error['pass'].'</span>';
            }?>
        </div>
        <?php } ?>
    </nav>
</header>