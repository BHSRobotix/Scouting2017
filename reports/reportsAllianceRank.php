<?php
include "../includes/sessionCheck.php";
include "../includes/globalVars.php";

// Get the team to do a report on
$numGearCyclers = (isset($_REQUEST['numGearCyclers']) ? $_REQUEST["numGearCyclers"] : 20);
$numAutoGears = (isset($_REQUEST['numAutoGears']) ? $_REQUEST["numAutoGears"] : 20);
$numClimbers = (isset($_REQUEST['numClimbers']) ? $_REQUEST["numClimbers"] : 15);
$numHighGoals = (isset($_REQUEST['numHighGoals']) ? $_REQUEST["numHighGoals"] : 10);

$queryTBARankings = "SELECT * FROM ".$bluealliancerankingsTable." WHERE eventkey = '" . $currEvent . "';";
$resultTBARankings = $db->query($queryTBARankings);
while ($row = mysqli_fetch_assoc($resultTBARankings)) {
    $teamRanking[$row['teamnumber'].":RANK"] = $row['rank'];
    $teamRanking[$row['teamnumber'].":OPR"] = $row['oprs'];
    $msg = "\n".$msg . $teamnumber.":RANK=".$row['rank'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reports - Alliance Selection Helper</title>
    <?php include "../includes/allCss.php" ?>
</head>
<body>
    <!-- <?= $msg ?> -->
    <?php include "../includes/userHeader.php" ?>
    <div class="container">
        
        <h4>Top <?= $numGearCyclers ?> Tele-Op Gear Cyclers</h4>
        <table class="table table-striped">
            <thead>
                <tr><th>Team Number</th><th>Tele-Op Gears Delivered</th><th>Rank</th><th>OPR</th></tr>
            </thead>
            <tbody>
            <?php
            $query1 = "SELECT teamNumber, SUM(tele_gears_delivered) as teleopGearsDelivered FROM ".$performancesTable.", (SELECT @rank := 0) b WHERE eventkey='".$currEvent."' GROUP BY teamNumber ORDER BY teleopGearsDelivered DESC LIMIT " . $numGearCyclers . ";";
            $result1 = $db->query($query1);
            while ($row = mysqli_fetch_assoc($result1)) {
            ?>
                <tr>
                    <td><a href="reportsSingleTeam.php?tmNum=<?= $row["teamNumber"] ?>"><?= $row['teamNumber'] ?></a></td>
                    <td><?= $row['teleopGearsDelivered'] ?></td>
                    <td><?= $teamRanking[$row["teamNumber"].':RANK'] ?></td>
                    <td><?= $teamRanking[$row["teamNumber"].':OPR'] ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
        
        <h4>Top <?= $numAutoGears ?> Auto Gear Deliverers</h4>
        <table class="table table-striped">
            <thead>
                <tr><th>Team Number</th><th>Auto Gears Delivered</th><th>Rank</th><th>OPR</th></tr>
            </thead>
            <tbody>
            <?php
            $query1 = "SELECT teamNumber, COUNT(auto_gear) as autoGearsDelivered FROM ".$performancesTable." WHERE eventkey='".$currEvent."' AND auto_gear='DIT' GROUP BY teamNumber ORDER BY autoGearsDelivered DESC LIMIT " . $numAutoGears . ";";
            $result1 = $db->query($query1);
            while ($row = mysqli_fetch_assoc($result1)) {
            ?>
                <tr>
                    <td><a href="reportsSingleTeam.php?tmNum=<?= $row["teamNumber"] ?>"><?= $row['teamNumber'] ?></a></td>
                    <td><?= $row['autoGearsDelivered'] ?></td>
                    <td><?= $teamRanking[$row["teamNumber"].':RANK'] ?></td>
                    <td><?= $teamRanking[$row["teamNumber"].':OPR'] ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
        
        <h4>Top <?= $numClimbers ?> Climbers</h4>
        <table class="table table-striped">
            <thead>
                   <tr><th>Team Number</th><th>Success / Attempts</th><th>Rank</th><th>OPR</th></tr>
            </thead>
            <tbody>
            <?php
            $query1 = "SELECT teamNumber, SUM(tele_climb_outcome = 'YAY') as totalClimbSuccesses, SUM(tele_climb_attempt != 'NA') AS totalClimbAttempts FROM ".$performancesTable." WHERE eventkey='".$currEvent."' GROUP BY teamNumber ORDER BY totalClimbSuccesses DESC, totalClimbAttempts ASC LIMIT " . $numClimbers . ";";
            $result1 = $db->query($query1);
            while ($row = mysqli_fetch_assoc($result1)) {
            ?>
                <tr>
                    <td><a href="reportsSingleTeam.php?tmNum=<?= $row["teamNumber"] ?>"><?= $row['teamNumber'] ?></a></td>
                    <td><?= $row['totalClimbSuccesses'] ?> / <?= $row['totalClimbAttempts'] ?></td>
                    <td><?= $teamRanking[$row["teamNumber"].':RANK'] ?></td>
                    <td><?= $teamRanking[$row["teamNumber"].':OPR'] ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
        
        
        <h4>Top <?= $numHighGoals ?> High Goal Scorers</h4>
        <table class="table table-striped">
            <thead>
                   <tr><th>Team Number</th><th>Auto High Goals Made | Tele-op High Goals Made</th><th>Rank</th><th>OPR</th></tr>
            </thead>
            <tbody>
            <?php
            $query1 = "SELECT teamNumber, SUM(auto_shot_high_success) as autoHighShotsMade, SUM(tele_shot_high_success) AS teleHighShotsMade FROM ".$performancesTable." WHERE eventkey='".$currEvent."' GROUP BY teamNumber ORDER BY autoHighShotsMade DESC, teleHighShotsMade DESC LIMIT " . $numHighGoals . ";";
            $result1 = $db->query($query1);
            while ($row = mysqli_fetch_assoc($result1)) {
            ?>
                <tr>
                    <td><a href="reportsSingleTeam.php?tmNum=<?= $row["teamNumber"] ?>"><?= $row['teamNumber'] ?></a></td>
                    <td><?= $row['autoHighShotsMade'] ?> | <?= $row['teleHighShotsMade'] ?></td>
                    <td><?= $teamRanking[$row["teamNumber"].':RANK'] ?></td>
                    <td><?= $teamRanking[$row["teamNumber"].':OPR'] ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
        
        <?php
            // OLD QUERIES I STRANGELY CARE ABOUT
//             $query2 = "SELECT teamnumber, AVG(totalAllianceScore) AS avg_score, AVG(coopertitionPoints) AS avg_coop, (AVG(totalAllianceScore) - AVG(coopertitionPoints)) AS diff FROM ".$performancesTable." GROUP BY teamnumber ORDER BY diff DESC;";
//             $query3 = "SELECT teamnumber, AVG(compatibilityRating) AS avg_rating, GROUP_CONCAT(DISTINCT compatibilityReason) FROM ".$driverfeedbackTable." GROUP BY teamnumber ORDER BY avg_rating DESC;";
            ?>
        
        
    </div>
</body>
</html>
