<?php
    session_start();
    include("db_connect.php");
    if (!isset($_SESSION['username'])) {
        header("Location: admin_login.php");
    }

    $sql = "SELECT * FROM user";
    $result = mysqli_query($connection, $sql);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Admin</title>
</head>
<body>   

    <div class="container">
        <h1>Users</h1>
        <button onclick="window.location.href='logout.php';">Logout</button>
    </div>
    <table border="1">
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Address</th>
        </tr>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['contact']; ?></td>
                <td><?php echo $user['address']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>