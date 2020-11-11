<?php

    require 'config.inc.php';

    readfile('header.tmpl.html');

    $elevatorName = '';
    $elevatorLocation = '';
    $elevatorOneWayMileage = '';
    $estimatedTruckingToLocation = '';
    $print = false;

    if (isset($_POST['submit'])) {
        // Assume form has been filled out properly.
        $ok = true;

        if (!isset($_POST['ElevatorName']) || $_POST['ElevatorName'] === ''){
            $ok = false;
        } else {
            $elevatorName = $_POST['ElevatorName'];
        }

        if (!isset($_POST['ElevatorLocation']) || $_POST['ElevatorLocation'] === ''){
            $ok = false;
        } else {
            $elevatorLocation = $_POST['ElevatorLocation'];
        }

        if (!isset($_POST['ElevatorOneWayMileage']) || $_POST['ElevatorOneWayMileage'] === ''){
            $ok = false;
        } else {
            $elevatorOneWayMileage = $_POST['ElevatorOneWayMileage'];
        }

        if (!isset($_POST['EstimatedTruckingToLocation']) || $_POST['EstimatedTruckingToLocation'] === ''){
            $ok = false;
        } else {
            $estimatedTruckingToLocation = $_POST['EstimatedTruckingToLocation'];
        }

        //  echo('$ok = ' . ($ok ? 'true' : 'false'));

        if ($ok) {
            if ($print) {
                printf('Elevator/Co-op Name: %s
                    <br>Elevator/Co-op Location: %s
                    <br>One-way Mileage: %s
                    <br>Estimated Trucking: %s',
                    htmlspecialchars($elevatorName, ENT_QUOTES),
                    htmlspecialchars($elevatorLocation, ENT_QUOTES),
                    htmlspecialchars($elevatorOneWayMileage, ENT_QUOTES),
                    htmlspecialchars($estimatedTruckingToLocation, ENT_QUOTES));
            } else {
                // Instantiate new DB connection...
                $db = new mysqli(
                    MYSQL_HOST, // dbServer .... if hosted, provide the server from the hosting provider
                    MYSQL_USER, // provide username
                    MYSQL_PASSWORD, // provide password
                    MYSQL_DATABASE // the name of the database to connect to
                );

                // // First approach ...
                // $sql = sprintf(
                //     "INSERT INTO Elevators (Name, LocationName, OneWayMiles, EstimatedTruckingToLocationOneWay)
                //     VALUES ('%s', '%s', %s, %s)",
                //     $db->real_escape_string($elevatorName),
                //     $db->real_escape_string($elevatorLocation),
                //     $db->real_escape_string($elevatorOneWayMileage),
                //     $db->real_escape_string($estimatedTruckingToLocation)
                // );
                
                // $db->query($sql);
                
                // Second approach ... prepared statemetns
                $stmt = $db->prepare(
                    "INSERT INTO Elevators (Name, LocationName, OneWayMiles, EstimatedTruckingToLocationOneWay)
                    VALUES (?, ?, ?, ?)"
                );
                $stmt->bind_param('ssid', $elevatorName, $elevatorLocation, $elevatorOneWayMileage, $estimatedTruckingToLocation);
                $stmt->execute();
    
                //echo '<p>New elevator added.</p>';
                // redirect
                header('Location: select.php');

                $db->close(); // Do not have to explicitly do this, b/c php will do this, but this is good practice.
            }
        }
    }
?>

<form action="" method="post">
    <div class="form-group">
        <label for="name">Elevator/Co-op Name:</label>
        <input type="text" class="form-control" name="ElevatorName" id="ElevatorName" value="<?php
            echo htmlspecialchars($elevatorName, ENT_QUOTES);
        ?>">
    </div>
    <div class="form-group">
        <label for="name">Elevator/Co-op Location:</label>
        <input type="text" class="form-control" name="ElevatorLocation" id="ElevatorLocation" value="<?php
            echo htmlspecialchars($elevatorLocation, ENT_QUOTES);
        ?>">
    </div>
    <div class="form-group">
        <label for="name">One-way Mileage:</label>
        <input type="text" class="form-control" name="ElevatorOneWayMileage" id="ElevatorOneWayMileage" value="<?php
            echo htmlspecialchars($elevatorOneWayMileage, ENT_QUOTES);
        ?>">
    </div>
    <div class="form-group">
        <label for="name">Estimated Trucking:</label>
        <input type="text" class="form-control" name="EstimatedTruckingToLocation" id="EstimatedTruckingToLocation" value="<?php
            echo htmlspecialchars($estimatedTruckingToLocation, ENT_QUOTES);
        ?>">
    </div>
    <input type="submit" name="submit" class="btn btn-primary" value="Submit">
</form>

<?php
    readfile('footer.tmpl.html');
?>