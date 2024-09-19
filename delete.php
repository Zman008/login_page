<?php
    include("db_connect.php");
    session_start();
    $sql = "DELETE FROM user WHERE id = {$_SESSION['id']}";
    try {
        mysqli_query($connection, $sql);
        session_destroy();
        header("Location: login.php");
    } catch (mysqli_sql_exception) {
        echo "ERROR<br>";
    }
?>