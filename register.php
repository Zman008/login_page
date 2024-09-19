<?php 
    include("db_connect.php");
?>

<?php
    $usernameErr = "";
    $emailErr = "";
    $contactErr = "";
    $registerMsg = "";
    
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

    function checkEmail($email) {
        global $connection;
        $sql = "SELECT * FROM user WHERE email = '$email'";
        $result = mysqli_query($connection, $sql);
        if (mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function checkContact($contact) {
        global $connection;
        $sql = "SELECT * FROM user WHERE contact = '$contact'";
        $result = mysqli_query($connection, $sql);
        if (mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $contact = filter_input(INPUT_POST, "contact", FILTER_SANITIZE_SPECIAL_CHARS);
        $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_SPECIAL_CHARS);
        $sq = filter_input(INPUT_POST, "sq", FILTER_SANITIZE_SPECIAL_CHARS);
        
        if (checkUsername($username)) {
            $usernameErr = "Username already exists";
        } else if (checkEmail($email)) {
            $emailErr = "Email already exists";
        } else if (checkContact($contact)) {
            $contactErr = "Contact already exists";
        } else {
            password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO 
                    user (username, password, contact, email, address, securityQ) 
                    VALUES 
                    ('$username', '$password', '$contact', '$email', '$address', '$sq')";
            try {
                mysqli_query($connection, $sql);
                $registerMsg = "User Registered Successfully";
            } catch (mysqli_sql_exception) {
                echo "ERROR<br>";
            }
        }
    }

    mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <form class="registration-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <h2 style="margin-top: 0px;">Registration</h2>
        <div class="form-control">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            <div class="errorMsg"><?php echo $usernameErr ?></div>
        </div>
        <div class="form-control">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-control">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <div class="errorMsg"><?php echo $emailErr ?></div>
        </div>  
        <div class="form-control">
            <label for="contact">Contact No.</label>
            <input type="text" id="contact" name="contact" required>
            <div class="errorMsg"><?php echo $contactErr ?></div>
        </div>
        <div class="form-control">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" required>
        </div>
        <div class="form-control">
            <label for="sq">Security Question:</label>
            <p>What was your first school?</p>
            <input type="text" id="sq" name="sq" required>
        </div>
        <div class="form-control">
            <input type="submit" value="Register">
            <div class="registerMsg"> <?php echo $registerMsg; ?></div>
            <div style="text-align: center;">
                <a href="login.php">Sign In</a>
            </div>
        </div>
    </form>
</body>
</html>