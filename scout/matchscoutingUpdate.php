<?php
include "../includes/sessionCheck.php";
include "../includes/globalVars.php";

// Normalize some fields
$reliability = "NP";
switch ($_POST['reliability']) {
	case "Lost Conx":
		$reliability = "CX";
		break;
	case "Broke":
		$reliability = "BK";
		break;
	case "Other":
		$reliability = "O";
		break;
}
$reliabilityComments = ($reliability != "NP") ? $_POST['reliabilityComments'] : "";
$autoMobility = "NA";
switch ($_POST['autoMobility']) {
	case "Moves, no points":
		$autoMobility = "D40";
		break;
	case "Drives 4 5":
		$autoMobility = "D45";
		break;
}
$autoGear = "NA";
switch ($_POST['autoGear']) {
	case "Delivers, too late":
		$autoGear = "DTL";
		break;
	case "Delivers and yay":
		$autoGear = "DIT";
		break;
}
$autoGearPegLocation = ($autoGear != "NA") ? substr($_POST['autoGearPegLocation'],0,1) : "";
$autoHopper = "NA";
switch ($_POST['autoHopper']) {
	case "Triggers, collects few":
		$autoHopper = "TF";
		break;
	case "Triggers, collects most":
		$autoHopper = "TM";
		break;
}
$autoShootHighAttempted = intval($_POST['autoShootHighSuccess']) + intval($_POST['autoShootHighMissed']);
$autoShootLowAttempted = intval($_POST['autoShootLowSuccess']) + intval($_POST['autoShootLowMissed']);
// Tele-op
$shotLocations = "";
if(!empty($_POST['shootLocation'])){  //check that at least one checkbox was checked
    foreach($_POST['shootLocation'] as $loc){
        $shotLocations .= (strlen($shotLocations) > 0 ? "," : "") . $loc;
    }
}

$climbingRope = "NA";
switch ($_POST['climbingRope']) {
	case "Fails to catch rope":
		$climbingRope = "F2R";
		break;
	case "Climbs partially":
		$climbingRope = "CP";
		break;
	case "Climbs to top":
		$climbingRope = "CTOP";
		break;
}
$climbingTouchpad = "NA";
switch ($_POST['climbingTouchpad']) {
	case "Fails to activate long enough":
		$climbingTouchpad = "F2A";
		break;
	case "Activates successfully":
		$climbingTouchpad = "YAY";
		break;
}
$defenseComments = ($_POST['defense'] != "No") ? $_POST['defenseComments'] : "";

$query = "INSERT INTO ".$performancesTable." (matchnumber, eventkey, teamnumber, "
        . " functional_code, functional_comments, auto_mobility, auto_gear, auto_gear_peg_location, auto_hopper, "
        . " auto_shot_high_attempt, auto_shot_high_success, auto_shot_low_attempt, auto_shot_low_success, "
        . " tele_fuel_acquire_floor, tele_fuel_acquire_hopper, tele_fuel_acquire_station, "
        . " tele_shot_low_success, tele_shot_high_success, tele_shot_location, "
        . " tele_gears_acquire_station, tele_gears_acquire_floor, tele_gears_delivered, "
        . " tele_climb_attempt, tele_climb_outcome, "
        . " tele_defense, tele_defense_comments, "
        . " comment, scout "
        . ") VALUES ("
        . $db->quote($_POST['matchnumber']) . ","
        . $db->quote($currEvent) . "," 
        . $db->quote($_POST['teamnumber']) . "," 
        . $db->quote($reliability) . "," 
        . $db->quote($reliabilityComments) . "," 
        . $db->quote($autoMobility) . "," 
        . $db->quote($autoGear) . "," 
        . $db->quote($autoGearPegLocation) . "," 
        . $db->quote($autoHopper) . "," 
        . $db->quote($autoShootHighAttempted) . "," 
        . $db->quote($_POST['autoShootHighSuccess']) . "," 
        . $db->quote($autoShootLowAttempted) . "," 
        . $db->quote($_POST['autoShootLowSuccess']) . "," 
        . $db->quote($_POST['fuelIntakeGround']) . "," 
        . $db->quote($_POST['fuelIntakeHopper']) . "," 
        . $db->quote($_POST['fuelIntakeStation']) . "," 
        . $db->quote($_POST['teleShootLowSuccess']) . "," 
        . $db->quote($_POST['teleShootHighSuccess']) . "," 
        . $db->quote($shotLocations) . "," 
        . $db->quote($_POST['gearsPickupStation']) . "," 
        . $db->quote($_POST['gearsPickupGround']) . "," 
        . $db->quote($_POST['gearsDelivered']) . "," 
        . $db->quote($climbingRope) . "," 
        . $db->quote($climbingTouchpad) . "," 
        . $db->quote($_POST['defense']) . "," 
        . $db->quote($defenseComments) . "," 
        . $db->quote($_POST['generalComments']) . "," 
        . $db->quote($_SESSION['username']) . ");";

$result = $db->query($query);

// Update the current match number too
$queryUpdateMatchNum = "UPDATE ".$eventstatusTable." SET currentMatchNumber=".$db->quote($_POST['matchnumber'])." WHERE active='true';";
$resultUpdateMatchNum = $db -> query($queryUpdateMatchNum);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Match Scouting for Team <?= $_POST['teamnumber'] ?> and Match <?= $_POST['matchnumber'] ?></title>
    <?php include "../includes/allCss.php" ?>
</head>
<body>
    <?php include "../includes/userHeader.php" ?>
    <div class="container">
        <div class="page-header"><h2>Match Scouting for Team <?= $_POST['teamnumber'] ?> and Match <?= $_POST['matchnumber'] ?></h2></div>
        <p>
            <?php if ($result) { ?>
                Successfully created a match scouting report!
            <?php } else { ?>
                There was a problem with the database!
            <?php } ?>
            <br/>
            <br/>
            
            <a class="btn btn-lg btn-primary" href="matchscoutingSelect.php">Scout another match</a>
            
        </p>
    </div>
</body>
</html>
