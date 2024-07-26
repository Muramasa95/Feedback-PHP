<?php include 'inc/header.php'; ?>

<?php 

// $user = $_SESSION['username']; 
echo ($user);
?>

    <h2>Profile</h2>

    <p class="text-center"><?php echo "Welcome " . $_SESSION['username'] . "." ?></p>

<?php include 'inc/footer.php'; ?>

