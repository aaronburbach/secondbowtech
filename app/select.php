<div>
    <ul>
<?php

    require 'config.inc.php';

    // Instantiate new DB connection...
    $db = new mysqli(
        MYSQL_HOST, // dbServer .... if hosted, provide the server from the hosting provider
        MYSQL_USER, // provide username
        MYSQL_PASSWORD, // provide password
        MYSQL_DATABASE // the name of the database to connect to
    );

    $sql = 'SELECT Id, Name, LocationName, OneWayMiles, EstimatedTruckingToLocationOneWay FROM Elevators';

    $result = $db->query($sql);

    // Bare bones ... need to protect the delete URL
    foreach ($result as $row) {
        printf(
            '<li>
                <span style="font-weight:bold;">%s - %s</span><br>
                <span>%s miles, $%s / mile</span><br>
                <span><a href="update.php?id=%s">update</a></span>
                <span><a href="delete.php?id=%s">delete</a></span>
            </li>',
            htmlspecialchars($row['Name'], ENT_QUOTES),
            htmlspecialchars($row['LocationName'], ENT_QUOTES),
            htmlspecialchars($row['OneWayMiles'], ENT_QUOTES),
            htmlspecialchars($row['EstimatedTruckingToLocationOneWay'], ENT_QUOTES),
            htmlspecialchars($row['Id'], ENT_QUOTES),
            htmlspecialchars($row['Id'], ENT_QUOTES)
        );
    }

    $db->close();

?>
    </ul>
</div>