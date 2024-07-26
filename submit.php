<?php include 'inc/header.php'; ?>

<?php 
  $name = $content = '';
  $nameErr = $contentErr = '';

  // form submit 
  if (isset($_POST['submit'])) {

    // validate content
    if(empty($_POST['content'])){
      $contentErr = 'Feedback is required!';
      
    } else {
      $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
  

  if (empty($nameErr) && empty($contentErr)) {
    $user = $_SESSION['username'];
    $sql = "INSERT INTO feedback (username, content) VALUES ('$user', '$content')";

    if (mysqli_query($conn, $sql)) {
      header('Location: index.php');
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
  }
}
?>



    <img src="img/logo.png" class="w-25 mb-3" alt="">
    <h2>Feedback</h2>
    <p class="lead text-center">Leave feedback for Cool Brand</p>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="mt-4 w-75">
      <div class="mb-3">
        <label for="content" class="form-label">Feedback</label>
        <textarea class="form-control <?php echo $contentErr ? 'is-invalid' : null; ?>" id="content" name="content" placeholder="Enter your feedback"></textarea>
        <div class="invalid-feedback">
          <?php echo $contentErr; ?>
        </div>
      </div>
      <div class="mb-3">
        <input type="submit" name="submit" value="Send" class="btn btn-dark w-100">
      </div>
    </form>

<?php include 'inc/footer.php'; ?>
