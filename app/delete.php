<?php
    //delete.php?id=2

    if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        // redirect
        header('Location: select.php');
    }

    // Instantiate new DB connection...
    $db = new mysqli(
        '', // dbServer .... if hosted, provide the server from the hosting provider
        '', // provide username
        '', // provide password
        '' // the name of the database to connect to
    );

    // we've made sure $id only consists of digits....
    $sql = "DELETE FROM Elevators Where id=$id";
    $db->query($sql);
    echo '<p>Elevator deleted.</p><br><p><span><a href="select.php">Back to List</a></span></p>';
    $db->close();
?>