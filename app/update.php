<?php
    //update.php?id=2

    require 'config.inc.php';

    if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        // redirect
        header('Location: select.php');
    }

    $elevatorName = '';
    $elevatorLocation = '';
    $elevatorOneWayMileage = '';
    $estimatedTruckingToLocation = '';
    $print = false;

    if (isset($_POST['submit'])) {
        // Assume form has been filled out properly.
        $ok = true;

        // Check all fields to ensure they've been properly filled out.
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

                // First approach ...
                $sql = sprintf(
                    "UPDATE Elevators Set Name='%s', LocationName='%s', OneWayMiles=%s, EstimatedTruckingToLocationOneWay=%s
                    WHERE id=%s",
                    $db->real_escape_string($elevatorName),
                    $db->real_escape_string($elevatorLocation),
                    $db->real_escape_string($elevatorOneWayMileage),
                    $db->real_escape_string($estimatedTruckingToLocation),
                    $id
                );
                
                $db->query($sql);
                
                // // Second approach ... prepared statemetns
                // $stmt = $db->prepare(
                //     "INSERT INTO Elevators (Name, LocationName, OneWayMiles, EstimatedTruckingToLocationOneWay)
                //     VALUES (?, ?, ?, ?)"
                // );
                // $stmt->bind_param('ssid', $elevatorName, $elevatorLocation, $elevatorOneWayMileage, $estimatedTruckingToLocation);
                // $stmt->execute();
    
                echo '<p>Elevator updated.</p>';

                $db->close(); // Do not have to explicitly do this, b/c php will do this, but this is good practice.
            }
        }
    } else {
        // Instantiate new DB connection...
        $db = new mysqli(
            MYSQL_HOST, // dbServer .... if hosted, provide the server from the hosting provider
            MYSQL_USER, // provide username
            MYSQL_PASSWORD, // provide password
            MYSQL_DATABASE // the name of the database to connect to
        );

        $sql = "SELECT Id, Name, LocationName, OneWayMiles, EstimatedTruckingToLocationOneWay From Elevators WHERE id=$id";
        $result = $db->query($sql);
        foreach ($result as $row) {
            $elevatorName = $row['Name'];
            $elevatorLocation = $row['LocationName'];
            $elevatorOneWayMileage = $row['OneWayMiles'];
            $estimatedTruckingToLocation = $row['EstimatedTruckingToLocationOneWay'];
        }
        $db->close(); // Do not have to explicitly do this, b/c php will do this, but this is good practice.
    }
?>

<form action="" method="post">
    <hr />
    <hr />
    <div>
        <label>Elevator/Co-op Name: <input type="text" name="ElevatorName" value="<?php
            echo htmlspecialchars($elevatorName, ENT_QUOTES);
        ?>" /></label>
    </div>
    <div>
        <label>Elevator/Co-op Location: <input type="text" name="ElevatorLocation" value="<?php
            echo htmlspecialchars($elevatorLocation, ENT_QUOTES);
        ?>" /></label>
    </div>
    <div>
        <label>One-way Mileage: <input type="text" name="ElevatorOneWayMileage" value="<?php
            echo htmlspecialchars($elevatorOneWayMileage, ENT_QUOTES);
        ?>" /></label>
    </div>
    <div>
        <label>Estimated Trucking: <input type="text" name="EstimatedTruckingToLocation" value="<?php
            echo htmlspecialchars($estimatedTruckingToLocation, ENT_QUOTES);
        ?>" /></label>
    </div>
    <div>
        <input type="submit" name="submit" value="Update" />
    </div>
    <hr />
    <hr />
</form>