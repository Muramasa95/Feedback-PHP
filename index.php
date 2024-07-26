<?php include 'inc/header.php'; ?>

<?php
  if (isset($_SESSION['username'])) {
    $user = $_SESSION['username'];
    $sql = "SELECT * FROM feedback WHERE username = '$user'";
    $result = mysqli_query($conn, $sql);
    $feedback = mysqli_fetch_all($result, MYSQLI_ASSOC);
  } else {
    $sql = 'SELECT * FROM feedback';
    $result = mysqli_query($conn, $sql);
    $feedback = mysqli_fetch_all($result, MYSQLI_ASSOC);
  }
?>
   
    <h2>Past Feedback</h2>

    <?php if (empty($feedback)): ?>
      <p class="lead mt3"> There is no feedback</p>
    <?php endif; ?>

    <?php foreach($feedback as $item): ?>
    <div class="card my-3 w-75">
     <div class="card-body text-center">
      <?php echo '"' . $item['content'] . '"'; ?>
        By <?php echo $item['username']; ?>
        <?php echo '(' . $item['date'] . ')'; ?>
     </div>
   </div>
<?php endforeach; ?>


<?php include 'inc/footer.php'; ?>
