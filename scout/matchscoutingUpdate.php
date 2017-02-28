<?php
include "../includes/sessionCheck.php";
include "../includes/globalVars.php";

$autoLowGoalAttempts = ($_POST['autoShoot'] == "missedLow" || $_POST['autoShoot'] == "madeLow") ? 1 : 0;
$autoLowGoalSuccess = ($_POST['autoShoot'] == "madeLow") ? 1 : 0;
$autoHighGoalAttempts = ($_POST['autoShoot'] == "missedHigh" || $_POST['autoShoot'] == "madeHigh") ? 1 : 0;
$autoHighGoalSuccess = ($_POST['autoShoot'] == "madeHigh") ? 1 : 0;

$teleopLowShotsAttempted = intval($_POST['teleShotLowSuccess']) + intval($_POST['teleShotLowMissed']);
$teleopHighShotsAttempted = intval($_POST['teleShotHighSuccess']) + intval($_POST['teleShotHighMissed']);

$query = "INSERT INTO ".$performancesTable." (matchnumber, eventkey, teamnumber, "
        . " isFunctional, auto_reach, auto_defense_crossed, auto_shot_low_attempt, auto_shot_low_success, auto_shot_high_attempt, auto_shot_high_success, "
        . " tele_def_cross_lowbar, tele_def_cross_a_pc, tele_def_cross_a_cdf, tele_def_cross_b_moat, tele_def_cross_b_ramp, "
        . " tele_def_cross_c_db, tele_def_cross_c_sp, tele_def_cross_d_rw, tele_def_cross_d_rt, "
        . " tele_shot_low_attempt, tele_shot_low_success, tele_shot_high_attempt, tele_shot_high_success, "
        . " tele_challenged, tele_scaled, comment, scout "
        . ") VALUES ("
        . $db->quote($_POST['matchnumber']) . "," 
        . $db->quote($currEvent) . "," 
        . $db->quote($_POST['teamnumber']) . "," 
        . $db->quote($_POST['isFunctional']) . "," 
        . $db->quote($_POST['autoReach']) . "," 
        . $db->quote($_POST['autoCross']) . "," 
        . $db->quote($autoLowGoalAttempts) . "," 
        . $db->quote($autoLowGoalSuccess) . "," 
        . $db->quote($autoHighGoalAttempts) . "," 
        . $db->quote($autoHighGoalSuccess) . "," 
        . $db->quote($_POST['telecrossLowBar']) . "," 
        . $db->quote($_POST['telecrossPortcullis']) . "," 
        . $db->quote($_POST['telecrossChevalDeFrise']) . ","
        . $db->quote($_POST['telecrossMoat']) . "," 
        . $db->quote($_POST['telecrossRamparts']) . "," 
        . $db->quote($_POST['telecrossDrawbridge']) . "," 
        . $db->quote($_POST['telecrossSallyPort']) . "," 
        . $db->quote($_POST['telecrossRockWall']) . "," 
        . $db->quote($_POST['telecrossRoughTerrain']) . "," 
        . $db->quote($teleopLowShotsAttempted) . "," 
        . $db->quote($_POST['teleShotLowSuccess']) . "," 
        . $db->quote($teleopHighShotsAttempted) . ","
        . $db->quote($_POST['teleShotHighSuccess']) . "," 
        . $db->quote($_POST['teleChallenged']) . "," 
        . $db->quote($_POST['teleScaled']) . ","
        . $db->quote($_POST['comments']) . "," 
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
