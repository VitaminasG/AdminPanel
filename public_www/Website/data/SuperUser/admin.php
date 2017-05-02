<?php
session_start();
$user = $_SESSION['user'];
$pass = $_SESSION['pass'];
$level = $_SESSION['level'];

if(empty($_SESSION['user']) && empty($_SESSION['pass']) && empty($_SESSION['level'])){
    header("Location: ../../include/message.php");
    die();
} else {
    if($level != 1){
        header("Location: ../../include/message.php");
        die();
    }
}

include '../../include/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>P1-FMA</title>
    <link rel="stylesheet" type="text/css" href="../../css/style.css?v=1.1">
</head>
<body>
<header>
    <h1>Admin Panel</h1>
    <nav>
        <ul>
        <?php
            $menu = array(
            '../../index.php' => 'Back to Main Page',
            '../../intra.php' => 'Intranet'
            );

            foreach ($menu as $index => $name ){
            echo '<li><a href="'.$index.'">'.$name.'</a></li>';
            }
        ?>
        </ul>
            <div class="logout">
                <p><?php TimeMsg(); echo $_SESSION['user']; ?>.</p>
                <a class="link" href="../../include/logout.php" >Logout</a>
            </div>
    </nav>
</header>
<main>
    <?php
    $self = htmlentities($_SERVER['PHP_SELF']);
    $submit = 'Submit';
    $submited = false;

    $error = array();
    $clean = array();

    $error_IS = false;

    $title = ' ';

    $name = $lname = $mail = $user = $pass = '';

        if (isset($_POST['submit'])){
            $submited = true;
            // Title;
            if (isset($_POST['title']) && $_POST['title'] !== ' ' ){
                $title = $_POST['title'];
                $clean['title'] = htmlentities($title);
            } else {
                $title = ' ';
                $error['title'] = 'Please, select title!';
                $error_IS = true;
            }

            // First Name;
            if (isset($_POST['fname'])){
                $fname = trim($_POST['fname']);
                if (ctype_alpha($fname)){
                    $clean['fname'] = htmlentities($fname);
                    $name = $fname;
                } else {
                    $error_IS = true;
                    $error['fname'] = 'Incorect first name! Only letters.';
                }
            }

            // Last Name;
            if (isset($_POST['sname'])){
                $sname = trim($_POST['sname']);
                if (ctype_alpha($sname)){
                    $clean['sname'] = htmlentities($sname);
                    $lname = $sname;
                } else {
                    $error_IS = true;
                    $error['sname'] = 'Incorect Surname! Only letters.';
                }
            }

            // Email;
            if (isset($_POST['email'])){
                $email = trim($_POST['email']);
                if (filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $clean['email'] = htmlentities($email);
                    $mail = $email;
                } else {
                    $error_IS = true;
                    $error['email'] = 'Incorect Email!.';
                }
            }

            // Username;
            if (isset($_POST['user'])){
                $userName = trim($_POST['user']);
                if (ctype_alpha($_POST['user'])){
                    $clean['user'] = htmlentities($userName);
                    $user = $userName;
                } else {
                    $error_IS = true;
                    $error['user'] = 'Incorect Username! Only letters.';
                }
            }

            // Password;
            if (isset($_POST['pass'])){
                $passWord = trim($_POST['pass']);
                if (ctype_alnum($_POST['pass'])){
                    $clean['pass'] = htmlentities($passWord);
                    $pass = $passWord;
                } else {
                    $error_IS = true;
                    $error['pass'] = 'Incorect Password! Only letters and numbers';
                }
            }
        }
    ?>
        <form id="regst" method="post" action="<?php echo $self; ?>">
            <fieldset>
                <label for="title">Title:</label>
                <select name="title" id="title">
                    <option <?php if ($title == ' ' ){echo 'selected';} ?> value=" "></option>
                    <option <?php if ($title == 'Mr' ){echo 'selected';} ?> value="Mr">Mr</option>
                    <option <?php if ($title == 'Mrs' ){echo 'selected';} ?> value="Mrs">Mrs</option>
                    <option <?php if ($title == 'Miss' ){echo 'selected';} ?> value="Miss">Miss</option>
                    <option <?php if ($title == 'Ms' ){echo 'selected';} ?> value="Ms">Ms</option>
                    <option <?php if ($title == 'Dr.' ){echo 'selected';} ?> value="Dr.">Dr.</option>
                    <option <?php if ($title == 'Prof.' ){echo 'selected';} ?> value="Prof.">Prof.</option>
                </select>
                <?php if(!empty($error['title'])){ echo '<p class="req">'.$error['title'].'</p>';}?>

                <label for="first">First name:</label>
                <input type="text" name="fname" id="first" value="<?php valCheck ($name); ?>"><span class="req"> *</span>
                <?php if(!empty($error['fname'])){ echo '<p class="req">'.$error['fname'].'</p>';}?>

                <label for="surname">Surname:</label>
                <input type="text" name="sname" id="surname" value="<?php valCheck ($lname); ?>"><span class="req"> *</span>
                <?php if(!empty($error['sname'])){ echo '<p class="req">'.$error['sname'].'</p>';}?>

                <label for="mail">Email:</label>
                <input type="email" name="email" id="mail" value="<?php valCheck ($mail); ?>"><span class="req"> *</span>
                <?php if(!empty($error['email'])){ echo '<p class="req">'.$error['email'].'</p>';}?>

                <label for="user">Username:</label>
                <input type="text" name="user" id="user" value="<?php valCheck ($user); ?>"><span class="req"> *</span>
                <?php if(!empty($error['user'])){ echo '<p class="req">'.$error['user'].'</p>';}?>

                <label for="pass">Password:</label>
                <input type="password" name="pass" id="pass" value="<?php valCheck ($pass); ?>"><span class="req"> *</span>
                <?php if(!empty($error['pass'])){ echo '<p class="req">'.$error['pass'].'</p>';}?>

                <input type="submit" name="submit" value="<?php echo htmlentities($submit); ?>">
            </fieldset>
        </form>
    <p class="req">* - Required fields</p>
    <?php
    if ($submited == true && $error_IS == false){
        $clean = implode(',',$clean);
        if(existUser($clean) !== true){
            addUser($clean);
            echo '<p>Member of stuff was added to a system.</p>';
        } else {
            echo '<p>Oops! Member of stuff already exist.</p>';
        }
    }
    ?>
</main>
<?php include '../../include/footer.php'?>