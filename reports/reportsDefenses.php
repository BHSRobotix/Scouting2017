<?php 
include "../includes/sessionCheck.php";
include "../includes/globalVars.php";

// Get the team to do a report on
$method = $_SERVER['REQUEST_METHOD'];
$team = $ourTeamNum;
if ($method == "GET") {
    $team1 = $_GET["tmNum1"];
    $team2 = $_GET["tmNum2"];
    $team3 = $_GET["tmNum3"];
} else if ($method == "POST") {
    $team1 = $_POST["tmNum1"];
    $team2 = $_POST["tmNum2"];
    $team3 = $_POST["tmNum3"];
}

$defenses = array("Portcullis"=>"tele_def_cross_a_pc", "Cheval de Frise"=>"tele_def_cross_a_cdf",
    "Moat"=>"tele_def_cross_b_moat", "Ramparts"=>"tele_def_cross_b_ramp",
    "Drawbridge"=>"tele_def_cross_c_db", "Sally Port"=>"tele_def_cross_c_sp",
    "Rock Wall"=>"tele_def_cross_d_rw", "Rough Terrain"=>"tele_def_cross_d_rt", "Low Bar"=>"tele_def_cross_lowbar");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Team <?= $team ?></title>
    <?php include "../includes/allCss.php" ?>  
<style>
.table {
  margin-bottom: 0;
}
.page-header {
  padding-bottom: 4px;
  margin: 20px 0 20px;
}
/* .robot-disabled { */
/*   background-color:  */
/* } */
</style>
</head>
<body>
    <?php include "../includes/userHeader.php" ?>
    <div class="container">


        <!-- Scouted Performances data -->
        <div class="page-header"><h4>Defense Crossings</h4></div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col" colspan="2">Team <a href="reportsSingleTeam.php?tmNum=<?= $team1 ?>"><?= $team1 ?></a></th>
                    <th scope="col" colspan="2">Team <a href="reportsSingleTeam.php?tmNum=<?= $team2 ?>"><?= $team2 ?></a></th>
                    <th scope="col" colspan="2">Team <a href="reportsSingleTeam.php?tmNum=<?= $team3 ?>"><?= $team3 ?></a></th>
                </tr>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Auto</th>
                    <th scope="col">Teleop</th>
                    <th scope="col">Auto</th>
                    <th scope="col">Teleop</th>
                    <th scope="col">Auto</th>
                    <th scope="col">Teleop</th>
            </thead>
            <tbody>
            
            <?php
            foreach($defenses as $key => $value) {
                $cTeleTm1 = $db->query("SELECT SUM(".$value.") AS sumTotal FROM ".$performancesTable." WHERE eventkey = '" . $currEvent . "' AND teamnumber = '" . $team1 . "';");
                $rowcTeleTm1 = $cTeleTm1->fetch_assoc(); 
                $cAutoTm1 = $db->query("SELECT COUNT(*) AS sumTotal FROM ".$performancesTable." WHERE eventkey = '" . $currEvent . "' AND teamnumber = '" . $team1. "' AND auto_defense_crossed = '" . $key . "';");
                $rowcAutoTm1 = $cAutoTm1->fetch_assoc(); 
                $cTeleTm2 = $db->query("SELECT SUM(".$value.") AS sumTotal FROM ".$performancesTable." WHERE eventkey = '" . $currEvent . "' AND teamnumber = '" . $team2 . "';");
                $rowcTeleTm2 = $cTeleTm2->fetch_assoc(); 
                $cAutoTm2 = $db->query("SELECT COUNT(*) AS sumTotal FROM ".$performancesTable." WHERE eventkey = '" . $currEvent . "' AND teamnumber = '" . $team2. "' AND auto_defense_crossed = '" . $key . "';");
                $rowcAutoTm2 = $cAutoTm2->fetch_assoc(); 
                $cTeleTm3 = $db->query("SELECT SUM(".$value.") AS sumTotal FROM ".$performancesTable." WHERE eventkey = '" . $currEvent . "' AND teamnumber = '" . $team3 . "';");
                $rowcTeleTm3 = $cTeleTm3->fetch_assoc(); 
                $cAutoTm3 = $db->query("SELECT COUNT(*) AS sumTotal FROM ".$performancesTable." WHERE eventkey = '" . $currEvent . "' AND teamnumber = '" . $team3. "' AND auto_defense_crossed = '" . $key . "';");
                $rowcAutoTm3 = $cAutoTm3->fetch_assoc(); 
            ?>
                <tr>
                    <td><?= $key ?></td>
                    <td><?= $rowcAutoTm1['sumTotal'] ?> </td><td> <?= $rowcTeleTm1['sumTotal'] ?></td>
                    <td><?= $rowcAutoTm2['sumTotal'] ?> </td><td> <?= $rowcTeleTm2['sumTotal'] ?></td>
                    <td><?= $rowcAutoTm3['sumTotal'] ?> </td><td> <?= $rowcTeleTm3['sumTotal'] ?></td>
                </tr>
             <?php 
             }
             ?>
            </tbody>
        </table>

        
    </div>
</body>
</html>