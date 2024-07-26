<?php include 'inc/header.php'; ?>

<?php 
  if (isset($_SESSION['username'])){
    header('Location: /index.php');
  }
  
  function validatePass($pass) {
    $uppercase = preg_match('@[A-Z]@', $pass);
    $lowercase = preg_match('@[a-z]@', $pass);
    $number = preg_match('@[0-9]@', $pass);
    $specialChar = preg_match('/[\W]/', $pass);

    if (strlen($pass) < 8 || !$uppercase === true || $number === true ||!$lowercase === true || !$specialChar === true) {
        return false;
    } else {
        return true;
    }
  }

  function check_user_duplication($user, $conn) {
    $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();  

    if($stmt->num_rows > 0) {
      $stmt->close();
      return true;
    } else {
      $stmt->close();
      return false;
    }
}

  $user = $pass = '';
  $userErr = $passErr = '';

  // form submit 
  if (isset($_POST['submit'])) {

    // validate user
    if(empty($_POST['user'])) {
      $userErr = 'Username is required!';
      
    } else if (!check_user_duplication($_POST['user'], $conn)) {
        $userErr = 'Username is taken!';

    } else {
      $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
  
    // validate pass
    if(empty($_POST['pass'])) {
      $passErr = 'Password is required!';
      
    } else if (!validatePass($_POST['pass'])) {
      $passErr = 'Password should be more than 8 characters, and have at least one of these: 1 uppercase, 1 lowercase, 1 number, 1 symbol.';

    } else {
      $pass = $_POST['pass'];

    }

  if(empty($userErr) && empty($passErr)){
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES ('$user', '$hashed_pass')";

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $user, $hashed_pass);

    if ($stmt->execute()) {
      $stmt->close();
      header('Location: /login.php');
    } else {
        echo "Error: " . $stmt->error;
    }
  }
}
?>

    <h2>Register</h2>
    <p class="lead text-center">Register a new user</p>
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
        <input type="submit" name="submit" value="Register" class="btn btn-dark w-100">
      </div>
    </form>

<?php include 'inc/footer.php'; ?>
