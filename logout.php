<!-- <?php include 'inc/header.php'; ?> -->

<?php
session_unset();
session_destroy();
header('Location: /index.php');
exit;
?>

<!-- <?php include 'inc/footer.php'; ?> -->
