<?php

require 'config.inc.php';

readfile('header.tmpl.html');

$originalPurchasePrice = 0.00;
$currentPrice = 0.00;
$boughtItFor = 0.00;
$couldSellItFor = 0.00;
$bushelsInContract = 5000;
$print = false;

if (isset($_POST['submit'])) {
    // Assume form has been filled out properly.
    $ok = true;

    if (!isset($_POST['OriginalPurchasePrice']) || $_POST['OriginalPurchasePrice'] === '') {
        $ok = false;
    } else {
        if (!is_numeric($_POST['OriginalPurchasePrice'])){
            $originalPurchasePrice = 0;
        } else {
            $originalPurchasePrice = $_POST['OriginalPurchasePrice'];
        }
    }

    if (!isset($_POST['CurrentPrice']) || $_POST['CurrentPrice'] === '') {
        $ok = false;
    } else {
        if (!is_numeric($_POST['CurrentPrice'])){
            $currentPrice = 0;
        } else {
            $currentPrice = $_POST['CurrentPrice'];
        }
    }

    if (!isset($_POST['BoughtItFor']) || $_POST['BoughtItFor'] === '') {
        $ok = false;
    } else {
        $boughtItFor = $_POST['BoughtItFor'];
    }

    if (!isset($_POST['CouldSellItFor']) || $_POST['CouldSellItFor'] === '') {
        $ok = false;
    } else {
        $couldSellItFor = $_POST['CouldSellItFor'];
    }

    //  echo('$ok = ' . ($ok ? 'true' : 'false'));

    if ($ok) {
        if ($print) {
            printf(
                'Original Purchase Price: %s
                    <br>Current Price: %s
                    <br>Bought It For: %s
                    <br>Could Sell It For: %s',
                htmlspecialchars($originalPurchasePrice, ENT_QUOTES),
                htmlspecialchars($currentPrice, ENT_QUOTES),
                htmlspecialchars($boughtItFor, ENT_QUOTES),
                htmlspecialchars($couldSellItFor, ENT_QUOTES)
            );
        } else {
            header('Location: select.php');

            $db->close(); // Do not have to explicitly do this, b/c php will do this, but this is good practice.
        }
    }
}
?>

<div class="container">
    <form action="" method="post">
        <div class="row">
            <div class="col-sm"><span class="font-weight-bold">Buy December 2021 $3.80 Put for $3.80</span></div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-sm"><span class="font-weight-bold">Original Purchase Price:</span><input type="text" class="form-control" name="OriginalPurchasePrice" id="OriginalPurchasePrice" value="<?php echo htmlspecialchars($originalPurchasePrice, ENT_QUOTES); ?>"></div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-sm"><span class="font-weight-bold">Current Price:</span><input type="text" class="form-control" name="CurrentPrice" id="CurrentPrice" value="<?php echo htmlspecialchars($currentPrice, ENT_QUOTES); ?>"></div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-sm"><span class="font-weight-bold">Bought it for:</span><div><?php echo "$".number_format(($originalPurchasePrice * $bushelsInContract), 2); ?></div></div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-sm"><span class="font-weight-bold">Could sell it for:</span><div><?php echo "$".number_format(($currentPrice * $bushelsInContract), 2); ?></div></div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-sm"><span class="font-weight-bold">Profit or Loss / bushel (5000)</span><div><?php echo "$".number_format((($currentPrice * $bushelsInContract) - ($originalPurchasePrice * $bushelsInContract)), 2); ?></div></div>
            </div>    
        </div>
        <input type="submit" name="submit" class="btn btn-primary" value="Submit">
    </form>
</div>

<?php
readfile('footer.tmpl.html');
?>