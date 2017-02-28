<?php
include "../includes/sessionCheck.php";
include "../includes/globalVars.php";

$allEvents = ($_GET["allEvents"] == "true" || $_POST["allEvents"] == "true");
$query = "SELECT * FROM ".$matchesTable." WHERE eventkey = '" . $currEvent . "' ORDER BY matchnumber ASC;";
$query = "SELECT * FROM ".$matchesTable." WHERE eventkey = '" . $currEvent . "' ORDER BY matchnumber ASC;";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reports - Scouts Stats</title>
    <?php include "../includes/allCss.php" ?>
</head>
<body>
    <?php include "../includes/userHeader.php" ?>
    <div class="container">
        <div class="page-header"><h2>Reports - Scouts Stats</h2></div>
        
        <!-- Match Scouting -->
        <div class="page-header">			
            <?php if ($allEvents) { ?>
                <h4>Match Scouting All-Stars - All Events (<a href="reportsScoutsStats.php?allEvents=false">see only <?= $currEventName ?></a>)</h4>
            <?php } else { ?>
                <h4>Match Scouting All-Stars - <?= $currEventName ?> (<a href="reportsScoutsStats.php?allEvents=true">see all events</a>)</h4>
            <?php } ?>
	    </div>
        <table class="table table-striped">
            <thead>
                <tr><th scope="col">Scout</th><th scope="col"># Matches Scouted</th></tr>
            </thead>
            <tbody>    
            <?php
            if ($allEvents) {
                $query1 = "SELECT scout, COUNT(*) AS num_reports FROM ".$performancesTable." GROUP BY scout ORDER BY num_reports DESC;";
	    } else {
	        $query1 = "SELECT scout, COUNT(*) AS num_reports FROM ".$performancesTable." WHERE eventkey = '" . $currEvent . "' GROUP BY scout ORDER BY num_reports DESC;";
	    }
            $result1 = $db->query($query1);
            while ($row = mysqli_fetch_assoc($result1)) {
            ?>
                <tr><td><?= $row['scout'] ?></td><td><?= $row['num_reports'] ?></td></tr>
            <?php
            }
            ?>
            </tbody>
        </table>
        
        <!-- Pit Scouting -->
        <div class="page-header"><h4>Pit Scouting All-Stars</h4></div>
        <table class="table table-striped">
            <thead>
                <tr><th scope="col">Scout</th><th scope="col"># Pits Scouted</th></tr>
            </thead>
            <tbody>    
            <?php
            $query2 = "SELECT scout, COUNT(*) AS num_reports FROM ".$pitdataTable." GROUP BY scout ORDER BY num_reports DESC;";
            $result2 = $db->query($query2);
            while ($row = mysqli_fetch_assoc($result2)) {
            ?>
                <tr><td><?= $row['scout'] ?></td><td><?= $row['num_reports'] ?></td></tr>
            <?php
            }
            ?>
            </tbody>
        </table>


    </div>
        
</body>
</html>