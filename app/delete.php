<?php
    require 'config.inc.php';
    
    readfile('header.tmpl.html');

    //delete.php?id=2
    if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        // redirect
        header('Location: select.php');
    }

    // Instantiate new DB connection...
    $db = new mysqli(
        MYSQL_HOST, // dbServer .... if hosted, provide the server from the hosting provider
        MYSQL_USER, // provide username
        MYSQL_PASSWORD, // provide password
        MYSQL_DATABASE // the name of the database to connect to
    );

    // we've made sure $id only consists of digits....
    $sql = "DELETE FROM Elevators Where id=$id";
    $db->query($sql);
    echo '<p>Elevator deleted.</p><br><p><span><a href="select.php">Back to List</a></span></p>';
    $db->close();
    readfile('footer.tmpl.html');
?>