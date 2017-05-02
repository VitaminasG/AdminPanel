<?php
session_start();
if(empty($_SESSION['user']) && empty($_SESSION['pass'])){
    header("Location: include/message.php");
    die();
}
include 'include/functions.php';
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
    <h1>Admin Panel</h1>
    <nav>
        <ul>
            <?php
            $menu = array(
                'index.php' => 'Back to Main Page',
            );

            foreach ($menu as $index => $name ){
                echo '<li><a href="'.$index.'">'.$name.'</a></li>';
            }
            ?>
        </ul>
        <div class="logout">
            <p><?php TimeMsg(); echo htmlentities($_SESSION['user']); ?>.</p>
            <a class="link" href="include/logout.php" >Logout</a>
        </div>
    </nav>
</header>
<?php
include 'include/moduls.php';
include 'include/footer.php';