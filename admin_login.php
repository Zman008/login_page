<?php
    session_start();
    include("db_connect.php");

    $usernameErr = "";
    $passwordErr = "";

    function checkUsername($username) {
        global $connection;
        $sql = "SELECT * FROM admin WHERE username = '$username'";
        $result = mysqli_query($connection, $sql);
        if (mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function checkPassword($username, $password) {
        global $connection;
        $sql = "SELECT * FROM admin WHERE username = '$username'";
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
            $sql = "SELECT * FROM admin WHERE username = '$username'";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $row['username'];
            header("Location: admin.php");
        }
    }

    mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <form class="registration-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <h2 style="margin-top: 0px;">Admin Login</h2>
        <div class="form-control">
            <input type="text" id="username" name="username" placeholder="Username" required>
            <div class="errorMsg"><?php echo $usernameErr ?></div>
        </div>
        <div class="form-control">
            <input type="password" id="password" name="password" placeholder="Password" required>
            <div class="errorMsg"><?php echo $passwordErr ?></div>
        </div>
        <div class="form-control">
            <input type="submit" value="Login">
        </div>
    </form>
</body>
</html>
