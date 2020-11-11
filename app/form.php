<?php
    $date = '';
    $cornContractMonth = '';
    $cornPrice = '';
    $soybeanContractMonth = '';
    $soybeanPrice = '';
    $elevatorName = '';
    $elevatorLocation = '';
    $elevatorOneWayMileage = '';
    $estimatedTruckingToLocation = '';
    $cornSpotPrice = '';
    $cornSpotBasis = '';
    $soybeanSpotPrice = '';
    $soybeanSpotBasis = '';
    $print = false;

    if (isset($_POST['submit'])) {
        // Assume form has been filled out properly.
        $ok = true;

        // Check all fields to ensure they've been properly filled out.
        if (!isset($_POST['Date']) || $_POST['Date'] === ''){
            $ok = false;
        } else {
            $date = $_POST['Date'];
        }

        if (!isset($_POST['CornContractMonth']) || $_POST['CornContractMonth'] === ''){
            $ok = false;
        } else {
            $cornContractMonth = $_POST['CornContractMonth'];
        }

        if (!isset($_POST['CornPrice']) || $_POST['CornPrice'] === ''){
            $ok = false;
        } else {
            $cornPrice = $_POST['CornPrice'];
        }

        if (!isset($_POST['SoybeanContractMonth']) || $_POST['SoybeanContractMonth'] === ''){
            $ok = false;
        } else {
            $soybeanContractMonth = $_POST['SoybeanContractMonth'];
        }

        if (!isset($_POST['SoybeanPrice']) || $_POST['SoybeanPrice'] === ''){
            $ok = false;
        } else {
            $soybeanPrice = $_POST['SoybeanPrice'];
        }

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

        if (!isset($_POST['CornSpotPrice']) || $_POST['CornSpotPrice'] === ''){
            $ok = false;
        } else {
            $cornSpotPrice = $_POST['CornSpotPrice'];
        }

        if (!isset($_POST['CornSpotBasis']) || $_POST['CornSpotBasis'] === ''){
            $ok = false;
        } else {
            $cornSpotBasis = $_POST['CornSpotBasis'];
        }

        if (!isset($_POST['SoybeanSpotPrice']) || $_POST['SoybeanSpotPrice'] === ''){
            $ok = false;
        } else {
            $soybeanSpotPrice = $_POST['SoybeanSpotPrice'];
        }

        if (!isset($_POST['SoybeanSpotBasis']) || $_POST['SoybeanSpotBasis'] === ''){
            $ok = false;
        } else {
            $soybeanSpotBasis = $_POST['SoybeanSpotBasis'];
        }

        //  echo('$ok = ' . ($ok ? 'true' : 'false'));

        if ($ok) {
            if ($print) {
                printf('Date: %s
                    <br>Front Month Corn Contract Month: %s
                    <br>Front Month Corn Contract Price: %s
                    <br>Front Month Soybean Contract Month: %s
                    <br>Front Month Soybean Contract Price: %s
                    <br>Elevator/Co-op Name: %s
                    <br>Elevator/Co-op Location: %s
                    <br>One-way Mileage: %s
                    <br>Estimated Trucking: %s
                    <br>Corn Spot Price: %s
                    <br>Corn Spot Basis: %s
                    <br>Soybean Spot Price: %s
                    <br>Soybean Spot Basis: %s',
                    htmlspecialchars($date, ENT_QUOTES),
                    htmlspecialchars($cornContractMonth, ENT_QUOTES),
                    htmlspecialchars($cornPrice, ENT_QUOTES),
                    htmlspecialchars($soybeanContractMonth, ENT_QUOTES),
                    htmlspecialchars($soybeanPrice, ENT_QUOTES),
                    htmlspecialchars($elevatorName, ENT_QUOTES),
                    htmlspecialchars($elevatorLocation, ENT_QUOTES),
                    htmlspecialchars($elevatorOneWayMileage, ENT_QUOTES),
                    htmlspecialchars($estimatedTruckingToLocation, ENT_QUOTES),
                    htmlspecialchars($cornSpotPrice, ENT_QUOTES),
                    htmlspecialchars($cornSpotBasis, ENT_QUOTES),
                    htmlspecialchars($soybeanSpotPrice, ENT_QUOTES),
                    htmlspecialchars($soybeanSpotBasis, ENT_QUOTES));
            } else {
                // Instantiate new DB connection...
                $db = new mysqli(
                    '', // dbServer .... if hosted, provide the server from the hosting provider
                    '', // provide username
                    '', // provide password
                    '' // the name of the database to connect to
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
    
                echo '<p>New elevator added.</p>';

                $db->close(); // Do not have to explicitly do this, b/c php will do this, but this is good practice.
            }
        }
    }
?>

<form action="" method="post">
    <hr>
    <hr>
    <div>
        <label>Date: <input type="text" name="Date" value="<?php
            echo htmlspecialchars($date, ENT_QUOTES);
        ?>" /></label>
    </div>
    <div>
        <label>Front Month Corn Contract Month: <input type="text" name="CornContractMonth" value="<?php
            echo htmlspecialchars($cornContractMonth, ENT_QUOTES);
        ?>" /></label>
    </div>
    <div>
        <label>Front Month Corn Contract Price: <input type="text" name="CornPrice" value="<?php
            echo htmlspecialchars($cornPrice, ENT_QUOTES);
        ?>" /></label>
    </div>
    <div>
        <label>Front Month Soybean Contract Month: <input type="text" name="SoybeanContractMonth" value="<?php
            echo htmlspecialchars($soybeanContractMonth, ENT_QUOTES);
        ?>" /></label>
    </div>
    <div>
        <label>Front Month Soybean Contract Price: <input type="text" name="SoybeanPrice" value="<?php
            echo htmlspecialchars($soybeanPrice, ENT_QUOTES);
        ?>" /></label>
    </div>
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
    <hr />
    <div>
        <label>Corn Spot Price: <input type="text" name="CornSpotPrice" value="<?php
            echo htmlspecialchars($cornSpotPrice, ENT_QUOTES);
        ?>" /></label>
    </div>
    <div>
        <label>Corn Spot Basis: <input type="text" name="CornSpotBasis" value="<?php
            echo htmlspecialchars($cornSpotBasis, ENT_QUOTES);
        ?>" /></label>
    </div>
    <div>
        <label>Soybean Spot Price: <input type="text" name="SoybeanSpotPrice" value="<?php
            echo htmlspecialchars($soybeanSpotPrice, ENT_QUOTES);
        ?>" /></label>
    </div>
    <div>
        <label>Soybean Spot Basis: <input type="text" name="SoybeanSpotBasis" value="<?php
            echo htmlspecialchars($soybeanSpotBasis, ENT_QUOTES);
        ?>" /></label>
    </div>
    <div>
        <input type="submit" name="submit" value="Submit" />
    </div>
    <hr />
    <hr />
</form>