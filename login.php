<?php 
    include("db_connect.php");
    session_start();
?>

<?php 
    $usernameErr = "";
    $passwordErr = "";
    $successMsg = "";

    function checkUsername($username) {
        global $connection;
        $sql = "SELECT * FROM user WHERE username = '$username'";
        $result = mysqli_query($connection, $sql);
        if (mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function checkPassword($username, $password) {
        global $connection;
        $sql = "SELECT * FROM user WHERE username = '$username'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($result);
        if ($row['password'] == $password) {
            return true;
        } else {
            return false;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        if (!checkUsername($username)) {
            $usernameErr = "Username does not exist";
        } else if (!checkPassword($username, $password)) {
            $passwordErr = "Incorrect Password";
        } else {
            $sql = "SELECT * FROM user WHERE username = '$username'";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_assoc($result);
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['contact'] = $row['contact'];
            $_SESSION['address'] = $row['address'];
            $successMsg = "Login Successful";
            header("Location: user.php");
        }
    }

    mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <form class="registration-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <h2 style="margin-top: 0px;">Sign In</h2>
        <div class="form-control">
            <input type="text" id="username" name="username" placeholder="Username" required>
            <div class="errorMsg"><?php echo $usernameErr ?></div>
        </div>
        <div class="form-control">
            <input type="password" id="password" name="password" placeholder="Password" required>
            <div class="errorMsg"><?php echo $passwordErr ?></div>
        </div>
        <div class="forgot-password">
            <a href="forgotPassword.php" style="font-size: small;">Forgot Password?</a>
        </div>
        <div class="form-control">
            <input type="submit" value="Login">
            <div class="successMsg"><?php echo $successMsg ?></div>
        </div>
        <hr>
        <p style="font-size: small;">Don't have an account? <a href="register.php">Register</a></p>
        <p style="font-size: small;"><a href="admin_login.php">Admin Login</a></p>
    </form>
</body>
</html>
