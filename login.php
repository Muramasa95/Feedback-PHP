<?php include 'inc/header.php'; ?>

<?php 
  if (isset($_SESSION['username'])){
    header('Location: /index.php');
  }

  $user = $pass = '';
  $userErr = $passErr = '';

  // form submit 
  if (isset($_POST['submit'])) {

    // validate user
    if(empty($_POST['user'])) {
      $userErr = 'User is required!';
      
    } else {
      $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
  
    // validate pass
    if(empty($_POST['pass'])) {
      $passErr = 'Password is required!';
      
    } else {
      $pass = $_POST['pass'];

    }

    if (empty($userErr) && empty($passErr)) {
      $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
      $stmt->bind_param("s", $user);
      $stmt->execute();
      $stmt->store_result();

      if ($stmt->num_rows > 0) {
          $stmt->bind_result($hashed_pass);
          $stmt->fetch();

          if (password_verify($pass, $hashed_pass)) {
              $_SESSION['username'] = $user;
              header('Location: /index.php');
              exit();
          } else {
              echo 'Login information are not correct!';
          }
      } else {
          echo 'Login information are not correct!';
      }
      $stmt->close();
    }
}
?>

    <h2>Login</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="mt-4 w-75">
      <div class="mb-3">
        <label for="user" class="form-label">Username</label>
        <input type="text" class="form-control <?php echo $userErr ? 'is-invalid' : null; ?>" id="user" name="user" placeholder="Enter your username">
        <div class="invalid-feedback">
          <?php echo $userErr; ?>
        </div>
      </div>
      <div class="mb-3">
        <label for="pass" class="form-label">Password</label>
        <input type="password" class="form-control <?php echo $passErr ? 'is-invalid' : null; ?>" id="pass" name="pass" placeholder="Enter your password">
        <div class="invalid-feedback">
          <?php echo $passErr; ?>
        </div>
      </div>
      <div class="mb-3">
        <input type="submit" name="submit" value="Login" class="btn btn-dark w-100">
      </div>
    </form>

<?php include 'inc/footer.php'; ?>
