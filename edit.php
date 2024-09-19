<?php 
    include("db_connect.php");
    session_start();
?>

<?php
    $usernameErr = "";
    $emailErr = "";
    $contactErr = "";
    $registerMsg = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $contact = filter_input(INPUT_POST, "contact", FILTER_SANITIZE_SPECIAL_CHARS);
        $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_SPECIAL_CHARS);
        
        $sql = "UPDATE user SET
                    username = '$username', contact = '$contact', email = '$email', address = '$address' 
                WHERE 
                    id = {$_SESSION['id']};";
        try {
            mysqli_query($connection, $sql);
            $registerMsg = "User Updated Successfully";
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['contact'] = $contact;
            $_SESSION['address'] = $address;
            header("Location: user.php");
        } catch (mysqli_sql_exception) {
            echo "ERROR<br>";
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
        <h2 style="margin-top: 0px;">Edit Profile</h2>
        <div class="form-control">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required value="<?php echo htmlspecialchars($_SESSION['username']); ?>">
            <div class="errorMsg"><?php echo $usernameErr ?></div>
        </div>
        <div class="form-control">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required  value="<?php echo htmlspecialchars($_SESSION['email']); ?>">
            <div class="errorMsg"><?php echo $emailErr ?></div>
        </div>  
        <div class="form-control">
            <label for="contact">Contact No.</label>
            <input type="text" id="contact" name="contact" required value="<?php echo htmlspecialchars($_SESSION['contact']); ?>">
            <div class="errorMsg"><?php echo $contactErr ?></div>
        </div>
        <div class="form-control">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" required value="<?php echo htmlspecialchars($_SESSION['address']); ?>">
        </div>
        <div class="form-control">
            <input type="submit" value="Update">
            <div class="registerMsg"> <?php echo $registerMsg; ?></div>
        </div>
    </form>
</body>
</html>