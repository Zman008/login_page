<?php 
    include("db_connect.php");
?>

<?php 
    $usernameErr = "";
    $result = "";
    
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

    function checkAnswer($username, $securityQ) {
        global $connection;
        $sql = "SELECT * FROM user WHERE username = '$username'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($result);
        if ($row['securityQ'] == $securityQ) {
            return true;
        } else {
            return false;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $securityQ = filter_input(INPUT_POST, "securityQ", FILTER_SANITIZE_SPECIAL_CHARS);

        if (!checkUsername($username)) {
            $usernameErr = "Username does not exist";
        } else if (!checkAnswer($username, $securityQ)) {
            $result = "Answer does not match";
        } else {
            $sql = "SELECT * FROM user WHERE username = '$username'";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_assoc($result);
            $result = "Success: Your password is '" . $row['password'] . "'";
        }
    }

    mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Recovery</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <form class="registration-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <h2 style="margin-top: 0px;">Password Recovery</h2>
        <div class="form-control">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required>
            <div class="errorMsg"><?php echo $usernameErr ?></div>
        </div>
        <div class="form-control">
            <label for="securityQ">What was the name of your first school?</label>
            <input type="text" id="securityQ" name="securityQ" required>
        </div>
        <div class="form-control">
            <input type="submit" value="Submit">
        </div>
        <hr>
        <div class="result"><?php echo $result ?></div>
    </form>
</body>
</html>
