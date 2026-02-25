<?php
session_start();

if(!isset($_SESSION['role'])){
    header('Location: ../login.php');
    exit();
}

if($_SESSION['role'] != 'admin'){
    header('Location: ../login.php');
    exit();
}
?>

<h2>Welcome  <?php echo $_SESSION['username']; ?></h2>
<a href="../logout.php">Logout</a>