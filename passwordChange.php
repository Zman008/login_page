<?php 
    include("db_connect.php");
    session_start();
?>

<?php 
    $passwordErr = "";
    $successMsg = "";

    function checkPassword($password) {
        global $connection;
        $sql = "SELECT * FROM user WHERE id = '$_SESSION[id]'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($result);
        if ($row['password'] == $password) {
            return true;
        } else {
            return false;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        $newPassword = filter_input(INPUT_POST, "newPassword", FILTER_SANITIZE_SPECIAL_CHARS);

        if (!checkPassword($password)) {
            $passwordErr = "Incorrect Password";
        } else {
            $sql = "UPDATE user SET password = '$newPassword'
                    WHERE id = {$_SESSION['id']};";
            $result = mysqli_query($connection, $sql);
            $successMsg = "Password Change Successful";
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
    <title>Change Password</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <form class="registration-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <h2 style="margin-top: 0px;">Change Password</h2>
        <div class="form-control">
            <input type="password" id="password" name="password" placeholder="Old Password" required>
            <div class="errorMsg"><?php echo $passwordErr ?></div>
            <div class="form-control">
                <input type="text" id="newPassword" name="newPassword" placeholder="New Password" required>
            </div>
        </div>
        <div class="form-control">
            <input type="submit" value="Submit">
            <div class="successMsg"><?php echo $successMsg ?></div>
        </div>
    </form>
</body>
</html>
