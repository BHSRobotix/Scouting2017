<?php 
include "../includes/sessionCheck.php";
include "../includes/globalVars.php";

// Get the team to do a report on
$method = $_SERVER['REQUEST_METHOD'];
$team = $ourTeamNum;
if ($method == "GET") {
    $team = $_GET["tmNum"];
} else if ($method == "POST") {
    $team = $_POST["tmNum"];
}

$queryTeamsTable = "SELECT * FROM ".$teamsTable." WHERE number = '" . $team . "';";
$resultTeamsTable = $db->query($queryTeamsTable);

$queryPitDataTable = "SELECT * FROM ".$pitdataTable." WHERE teamnumber = '" . $team . "';";
$resultPitDataTable = $db->query($queryPitDataTable);

$queryPerfomancesTable = "SELECT * FROM ".$performancesTable." WHERE eventkey = '" . $currEvent . "' AND teamnumber = '" . $team . "' ORDER BY matchnumber ASC;";
$resultPerfomancesTable = $db->query($queryPerfomancesTable);

$queryDriverfeedbackTable = "SELECT * FROM ".$driverfeedbackTable." WHERE eventkey = '" . $currEvent . "' AND teamnumber = '" . $team . "' ORDER BY scout ASC;";
$resultDriverfeedbackTable = $db->query($queryDriverfeedbackTable);

$queryMatchesTable = "SELECT * FROM ".$matchesTable." WHERE eventkey = '" . $currEvent . "' AND ( "
            . "redteam1 = '" . $team . "' OR redteam2 = '" . $team . "' OR redteam3 = '" . $team . "' OR "
            . "blueteam1 = '" . $team . "' OR blueteam2 = '" . $team . "' OR blueteam3 = '" . $team . "' "
            . ") ORDER BY matchnumber ASC;";
$resultMatchesTable = $db->query($queryMatchesTable);

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

<script>
    var reportType = "concise";
    var adjustColspans = function() {
        $("table.expandable").each(function() {
            var numAutoVis = $(this).find("tr.expandable-template").find("th.auto:visible, td.auto:visible").length;
            $(this).find("td.auto-span").attr("colspan", numAutoVis);
            var numTeleopVis = $(this).find("tr.expandable-template").find("th.teleop:visible, td.teleop:visible").length;
            $(this).find("td.teleop-span").attr("colspan", numTeleopVis);
        });
    };
    var toggleMultipleReportsVisibility = function() {
        $("tr.multi-report").each(function() {
            // find the class that helps me find the single-reports associated with this multi-report
            var className = $(this).attr("class").toString().match(/tm-\d+-qm-\d+/).toString();
            $("tr.single-report."+className).slideToggle();
            $(this).click(function() {
            	$("tr.single-report."+className).slideToggle();
            	$(this).toggleClass("open");
            });
        });            
    };
    var changeReportType = function() {
        reportType = reportType === "concise" ? "expanded" : "concise";
        $(".expanded").toggle(reportType === "expanded");
        $("#reportType").html(reportType);
        $("#reportTypeToggle span.action").html(reportType === "concise" ? "expanded" : "concise");
        adjustColspans();
    };
    $(document).ready(function() {
    	adjustColspans();
    	toggleMultipleReportsVisibility();
        $("#reportTypeToggle").click(function() {
        	changeReportType();
        });
//         $("#tr.multi-report").click(function() {
//             var className = $(this).attr("class").toString().match(/tm-\d+-qm-\d+/).toString();
//             $("tr.single-report."+className).slideToggle();
//         });
    });

</script>
</head>
<body>
    <?php include "../includes/userHeader.php" ?>
    <div class="container">

        <?php $row = mysqli_fetch_assoc($resultTeamsTable); ?>
        <div class="page-header">
            <table class="table table-striped">
                <tr>
                    <td rowspan="3"><h2><?= $team ?></h2></td>
                    <td><strong><?= $row['name'] ?></strong></td>
                </tr>
                <tr><td><?= $row['location'] ?></td></tr>
                <tr><td><?= $row['url'] ?></td></tr>
            </table>
        </div>
        
        
        <!-- Pit data -->
        <?php $row = mysqli_fetch_assoc($resultPitDataTable); ?>
        <?php if (isset($row)) { ?>
        <h6>Pictures (collected by <?= $row['scout'] ?>)</h6>
        <?php if (isset($row['robotPicture'])) { ?><p><img src="<?= $row['robotPicture'] ?>"/></p><?php } else { ?><p class="alert alert-warning">No robot picture for this team</p><?php } ?>
        <?php if (isset($row['driverPicture'])) { ?><p><img src="<?= $row['driverPicture'] ?>"/></p><?php } else { ?><p class="alert alert-warning">No driver picture for this team</p><?php } ?>
        <?php } else { ?>
        <p class="alert alert-warning">No pictures collected.  <a href="/scout/pitscouting.php?tmNum=<?= $team ?>">Collect now!</a></p>
        <?php } ?>
        

        <!-- Scouted Performances data -->
        <div class="page-header">
            <h4>Scouted Performances</h4>
            <span id="reportType">concise</span> <span id="reportTypeToggle">[<span class="action">expanded</span>]</span>
        </div>
        <table class="table table-striped expandable">
            <thead>
                <tr>
                    <th class="concise"></th>
                    <th class="auto-span concise" colspan="3">Auto</th>
                    <th class="teleop-span concise" colspan="5">Teleop</th>
                    <th class="expanded"></th>
                </tr>
                <tr class="expandable-template">
                    <th class="concise">QM#</th>
                    <th class="auto concise"><span class="sw sw-mobility"></span><span class="expanded">Mobility</span></th>
                    <th class="auto concise"><span class="sw sw-gear"></span><span class="expanded">Gear</span></th>
                    <th class="auto expanded"><span class="sw sw-hopper"></span><span class="expanded">Hopper</span></th>
                    <th class="auto concise"><span class="sw sw-highshot"></span><span class="expanded">Boiler High</span></th>
                    <th class="auto expanded"><span class="sw sw-lowshot"></span><span class="expanded">Boiler Low</span></th>
                    <th class="teleop concise"><span class="sw sw-fuel"></span><span class="expanded">Fuel Intake</span></th>
                    <th class="teleop concise"><span class="sw sw-highshot"></span><span class="expanded">Boiler High</span></th>
                    <th class="teleop expanded"><span class="sw sw-lowshot"></span><span class="expanded">Boiler Low</span></th>
                    <th class="teleop expanded"><span class="expanded">Shot Location</span></th>
                    <th class="teleop concise"><span class="sw sw-gear"></span><span class="expanded">Gears</span></th>
                    <th class="teleop expanded"><span class="sw sw-rope"></span><span class="expanded">Rope</span></th>
                    <th class="teleop concise"><span class="sw sw-touchpad"></span><span class="expanded">Touchpad</span></th>
                    <th class="teleop concise"><span class="sw sw-defense"></span><span class="expanded">Defense</span></th>
                    <th class="expanded"><span class="sw sw-scout"></span><span class="expanded">Scout</span></th>
                </tr>
            </thead>
            <tbody>
            
            <?php
            $zeroPerfs = true;
            $matchComments = "";
            $summaryRow = array();   // combine multiple matches into this summaryRow
            $summaryRow['matchnumber'] = -1;
            $summaryRow['numRows'] = 0;
            $mmVal = "MM";
            $mmClz = "alert alert-warning"; // "mismatch"
            while ($row = mysqli_fetch_assoc($resultPerfomancesTable)) {
                $zeroPerfs = false;
                $functional = true;
                $matchnum = $row['matchnumber'];
                if (!empty($row['comment'])) {
                    $matchComments .= "<tr><td>Q".$matchnum."</td><td>".$row['comment']."</td><td>".$row['scout']."</td></tr>";
                }
                if ($row['functional_code'] != "NP") {
                	$functional = false;
                	$matchComments .= "<tr><td>Q".$matchnum."</td><td><b>".$row['functional_code'].": </b>".$row['functional_comments']."</td><td>".$row['scout']."</td></tr>";                	 
                }
                if (!empty($row['tele_defense_comments'])) {
                	$matchComments .= "<tr><td>Q".$matchnum."</td><td><b>Def: </b>".$row['tele_defense_comments']."</td><td>".$row['scout']."</td></tr>";                	 
                }

                if ($matchnum == $summaryRow['matchnumber']) {
                	$summaryRow['numRows'] = $summaryRow['numRows'] + 1;
                	$summaryRow['functional_code'] = ($summaryRow['functional_code'] == $row['functional_code'] ? $row['functional_code'] : $mmVal);
                	$summaryRow['auto_mobility'] = ($summaryRow['auto_mobility'] == $row['auto_mobility'] ? $row['auto_mobility'] : $mmVal);
                	$summaryRow['auto_gear'] = ($summaryRow['auto_gear'] == $row['auto_gear'] ? $row['auto_gear'] : $mmVal);
                	$summaryRow['auto_gear_peg_location'] = ($summaryRow['auto_gear_peg_location'] == $row['auto_gear_peg_location'] ? $row['auto_gear_peg_location'] : $mmVal);
                	$summaryRow['auto_hopper'] = ($summaryRow['auto_hopper'] == $row['auto_hopper'] ? $row['auto_hopper'] : $mmVal);

                	$summaryRow['auto_shot_high_attempt'] = $summaryRow['auto_shot_high_attempt'] + $row['auto_shot_high_attempt'];
                	$summaryRow['auto_shot_high_success'] = $summaryRow['auto_shot_high_success'] + $row['auto_shot_high_success'];
                	$summaryRow['auto_shot_low_attempt'] = $summaryRow['auto_shot_low_attempt'] + $row['auto_shot_low_attempt'];
                	$summaryRow['auto_shot_low_success'] = $summaryRow['auto_shot_low_success'] + $row['auto_shot_low_success'];
                	$summaryRow['tele_fuel_acquire_floor'] = $summaryRow['tele_fuel_acquire_floor'] + $row['tele_fuel_acquire_floor'];
                	$summaryRow['tele_fuel_acquire_hopper'] = $summaryRow['tele_fuel_acquire_hopper'] + $row['tele_fuel_acquire_hopper'];
                	$summaryRow['tele_fuel_acquire_station'] = $summaryRow['tele_fuel_acquire_station'] + $row['tele_fuel_acquire_station'];
                	$summaryRow['tele_shot_high_success'] = $summaryRow['tele_shot_high_success'] + $row['tele_shot_high_success'];
                	$summaryRow['tele_shot_low_success'] = $summaryRow['tele_shot_low_success'] + $row['tele_shot_low_success'];

                	$summaryRow['tele_shot_location'] = ($summaryRow['tele_shot_location'] == $row['tele_shot_location'] ? $row['tele_shot_location'] : $mmVal);
                	
                	$summaryRow['tele_gears_acquire_floor'] = $summaryRow['tele_gears_acquire_floor'] + $row['tele_gears_acquire_floor'];
                	$summaryRow['tele_gears_acquire_station'] = $summaryRow['tele_gears_acquire_station'] + $row['tele_gears_acquire_station'];
                	$summaryRow['tele_gears_delivered'] = $summaryRow['tele_gears_delivered'] + $row['tele_gears_delivered'];
                	 
                	$summaryRow['tele_climb_attempt'] = ($summaryRow['tele_climb_attempt'] == $row['tele_climb_attempt'] ? $row['tele_climb_attempt'] : $mmVal);
                	$summaryRow['tele_climb_outcome'] = ($summaryRow['tele_climb_outcome'] == $row['tele_climb_outcome'] ? $row['tele_climb_outcome'] : $mmVal);
                	$summaryRow['tele_defense'] = ($summaryRow['tele_defense'] == $row['tele_defense'] ? $row['tele_defense'] : $mmVal);
                } else {
                    // create the summary row if the number of rows of the last one is > 1
                    if ($summaryRow['numRows'] > 1) {
                    	$rowClass = "tm-".$team."-qm-".$summaryRow['matchnumber'];
                   	?>
                   	    <tr class="multi-report <?= $rowClass ?><?php if ($summaryRow['functional_code'] != "NP") { ?> alert alert-danger<?php } ?>">
                    	    <td class="concise"><?= $summaryRow['matchnumber'] ?></td>
                    	    <td class="auto concise <?= $summaryRow['auto_mobility'] != $mmVal ? $mmClz : "" ?>"><?= $summaryRow['auto_mobility'] == "NA" ? "0" : ($summaryRow['auto_mobility'] == "D40" ? "<b>0</b>" : ($summaryRow['auto_mobility'] == "D45" ?"<b>5</b>" : "")) ?></td>                
                    	    <td class="auto concise <?= ($summaryRow['auto_gear'] == $mmVal || $summaryRow['auto_gear_peg_location'] == $mmVal) ? $mmClz : "" ?>">
                    	        <span class="expanded"><?= $summaryRow['auto_gear'] ?><?= $summaryRow['auto_gear'] != "NA" ? ":" : "" ?></span>
                    	        <?= $summaryRow['auto_gear'] == "DIT" ? "<b>" : "" ?><?= $summaryRow['auto_gear_peg_location'] ?><?= $summaryRow['auto_mobility'] == "DIT" ? "</b>" : "" ?>
                    	    </td>
                    	    <td class="auto expanded <?= $summaryRow['auto_hopper'] == $mmVal ? $mmClz : "" ?>"><?= $summaryRow['auto_hopper'] ?></td>
                    	    <td class="auto concise"><?= $summaryRow['auto_shot_high_success']/$summaryRow['numRows'] ?> / <?= $summaryRow['auto_shot_high_attempt']/$summaryRow['numRows'] ?></td>
                    	    <td class="auto expanded"><?= $summaryRow['auto_shot_low_success']/$summaryRow['numRows'] ?> / <?= $summaryRow['auto_shot_low_attempt']/$summaryRow['numRows'] ?></td>
                    	    <td class="teleop concise"><?= $summaryRow['tele_fuel_acquire_floor']/$summaryRow['numRows'] ?> | <?= $summaryRow['tele_fuel_acquire_hopper']/$summaryRow['numRows'] ?> | <?= $summaryRow['tele_fuel_acquire_station']/$summaryRow['numRows'] ?></td>
                    	    <td class="teleop concise"><?= $summaryRow['tele_shot_high_success']/$summaryRow['numRows'] ?></td>
                    	    <td class="teleop expanded"><?= $summaryRow['tele_shot_low_success']/$summaryRow['numRows'] ?></td>
                    	    <td class="teleop expanded <?= $summaryRow['tele_shot_location'] == $mmVal ? $mmClz : "" ?>"><?= $summaryRow['tele_shot_location'] ?></td>
                    	    <td class="teleop concise"><?= $summaryRow['tele_gears_acquire_floor']/$summaryRow['numRows'] ?> | <?= $summaryRow['tele_gears_acquire_station']/$summaryRow['numRows'] ?> | <b><?= $summaryRow['tele_gears_delivered']/$summaryRow['numRows'] ?></b></td>
                    	    <td class="teleop expanded <?= $summaryRow['tele_climb_attempt'] == $mmVal ? $mmClz : "" ?>"><?= $summaryRow['tele_climb_attempt'] ?></td>
                            <td class="teleop concise <?= $summaryRow['tele_climb_outcome'] == $mmVal ? $mmClz : "" ?>"><?= $summaryRow['tele_climb_outcome'] == "YAY" ? "<span class='fa fa-check-circle'></span>" : "" ?></td>
                            <td class="teleop concise <?= $summaryRow['tele_defense'] == $mmVal ? $mmClz : "" ?>"><?= $summaryRow['tele_defense'] == "Yes" ? "<span class='fa fa-check-circle'></span>" : "" ?></td>
                            <td class="expanded">multiple</td>
                        </tr>                    	                                    
                    <?php
                    }
                   	// reset the summary as if every time is the start of a new summary (obv. some of these will be not be more than one row)
                   	$summaryRow['matchnumber'] = $matchnum;
                   	$summaryRow['numRows'] = 1;
                   	$summaryRow['functional_code'] = $row['functional_code'];
                   	$summaryRow['auto_mobility'] = $row['auto_mobility'];
                   	$summaryRow['auto_gear'] = $row['auto_gear'];
                   	$summaryRow['auto_gear_peg_location'] = $row['auto_gear_peg_location'];
                   	$summaryRow['auto_hopper'] = $row['auto_hopper'];
                   	$summaryRow['auto_shot_high_attempt'] = $row['auto_shot_high_attempt'];
                   	$summaryRow['auto_shot_high_success'] = $row['auto_shot_high_success'];
                   	$summaryRow['auto_shot_low_attempt'] = $row['auto_shot_low_attempt'];
                   	$summaryRow['auto_shot_low_success'] = $row['auto_shot_low_success'];
                   	$summaryRow['tele_fuel_acquire_floor'] = $row['tele_fuel_acquire_floor'];
                   	$summaryRow['tele_fuel_acquire_hopper'] = $row['tele_fuel_acquire_hopper'];
                   	$summaryRow['tele_fuel_acquire_station'] = $row['tele_fuel_acquire_station'];
                   	$summaryRow['tele_shot_high_success'] = $row['tele_shot_high_success'];
                   	$summaryRow['tele_shot_low_success'] = $row['tele_shot_low_success'];
                   	$summaryRow['tele_shot_location'] = $row['tele_shot_location'];
                   	$summaryRow['tele_gears_acquire_floor'] = $row['tele_gears_acquire_floor'];
                   	$summaryRow['tele_gears_acquire_station'] = $row['tele_gears_acquire_station'];
                   	$summaryRow['tele_gears_delivered'] = $row['tele_gears_delivered'];
                   	$summaryRow['tele_climb_attempt'] = $row['tele_climb_attempt'];
                   	$summaryRow['tele_climb_outcome'] = $row['tele_climb_outcome'];
                   	$summaryRow['tele_defense'] = $row['tele_defense'];
                }                  

                $rowClass = "tm-".$team."-qm-".$matchnum;
            ?>
            
                <tr class="single-report <?= $rowClass ?><?php if (!$functional) { ?> alert alert-danger<?php } ?>">
                    <td class="concise"><?= $matchnum ?></td>
                    <td class="auto concise"><?= $row['auto_mobility'] == "NA" ? "0" : ($row['auto_mobility'] == "D40" ? "<b>0</b>" : "<b>5</b>") ?></td>                
                    <td class="auto concise">
                        <span class="expanded"><?= $row['auto_gear'] ?><?= $row['auto_gear'] != "NA" ? ":" : "" ?></span>
                        <?= $row['auto_gear'] == "DIT" ? "<b>" : "" ?><?= $row['auto_gear_peg_location'] ?><?= $row['auto_mobility'] == "DIT" ? "</b>" : "" ?>
                    </td>
                    <td class="auto expanded"><?= $row['auto_hopper'] ?></td>
                    <td class="auto concise"><?= $row['auto_shot_high_success'] ?> / <?= $row['auto_shot_high_attempt'] ?></td>
                    <td class="auto expanded"><?= $row['auto_shot_low_success'] ?> / <?= $row['auto_shot_low_attempt'] ?></td>
                    <td class="teleop concise"><?= $row['tele_fuel_acquire_floor'] ?> | <?= $row['tele_fuel_acquire_hopper'] ?> | <?= $row['tele_fuel_acquire_station'] ?></td>
                    <td class="teleop concise"><?= $row['tele_shot_high_success'] ?></td>
                    <td class="teleop expanded"><?= $row['tele_shot_low_success'] ?></td>
                    <td class="teleop expanded"><?= $row['tele_shot_location'] ?></td>
                    <td class="teleop concise"><?= $row['tele_gears_acquire_floor'] ?> | <?= $row['tele_gears_acquire_station'] ?> | <b><?= $row['tele_gears_delivered'] ?></b></td>
                    <td class="teleop expanded"><?= $row['tele_climb_attempt'] ?></td>
                    <td class="teleop concise"><?= $row['tele_climb_outcome'] == "YAY" ? "<span class='fa fa-check-circle'></span>" : "" ?></td>
                    <td class="teleop concise"><?= $row['tele_defense'] == "Yes" ? "<span class='fa fa-check-circle'></span>" : "" ?></td>
                    <td class="expanded"><?= $row['scout'] ?></td>
                </tr>
             <?php 
             }
             if ($zeroPerfs) {
                echo "<tr><td colspan='10'>No performances scouted for this team.</td></tr>";
             }
             ?>
            </tbody>
        </table>

        <div class="page-header"><h4>Scouted Comments</h4></div>
        <?php if (empty($matchComments)) { ?>
        <p class="alert alert-warning">No comments on this team.</p>
        <?php } else { ?>
        <table class="table table-striped">
            <thead><tr><th>Match</th><th>Comment</th><th>Scout</th></tr></thead>
            <tbody><?= $matchComments ?></tbody>            
        </table>
        <?php } ?>

        
        <!-- Driver Feedback data -->
        <div class="page-header"><h4>Drive Team Comments</h4></div>
        <?php
        $driveComments = "";
        while ($row = mysqli_fetch_assoc($resultDriverfeedbackTable)) {
            if (!empty($row['comments'])) {
                $driveComments .= "<tr><td>".$row['comments']."</td><td>".$row['scout']."</td></tr>";
            }
        }
        ?>
        <?php if (empty($driveComments)) { ?>
        <p class="alert alert-warning">No comments on this team.</p>
        <?php } else { ?>
        <table class="table table-striped">
            <thead><tr><th>Comment</th><th>Scout</th></tr></thead>
            <tbody><?= $driveComments ?></tbody>
        </table>
        <?php } ?>
        

        <!--  TODO - add match results data back in? -->
        
    </div>
</body>
</html>