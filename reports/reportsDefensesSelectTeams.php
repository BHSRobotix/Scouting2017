<?php
include "../includes/sessionCheck.php";
include "../includes/globalVars.php";

$allMatches = false;
$query = "";
if ($_GET["all"] == "true" || $_POST["all"] == "true") {
    $query = "SELECT * FROM ".$matchesTable." WHERE eventkey = '" . $currEvent . "' ORDER BY matchnumber ASC;";
    $allMatches = true;
} else {
    $query = "SELECT * FROM ".$matchesTable." WHERE eventkey = '" . $currEvent . "' AND ( "
            . "redteam1 = '" . $ourTeamNum . "' OR redteam2 = '" . $ourTeamNum . "' OR redteam3 = '" . $ourTeamNum . "' OR "
            . "blueteam1 = '" . $ourTeamNum . "' OR blueteam2 = '" . $ourTeamNum . "' OR blueteam3 = '" . $ourTeamNum . "' "
            . ") ORDER BY matchnumber ASC;";
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Reports - Select Teams to See Defensive Capabilities</title>
    <?php include "../includes/allCss.php" ?>
<style>
.input-group {
  max-width: 330px;
}
</style>
</head>
<body>
    <?php include "../includes/userHeader.php" ?>
    <div class="container">
        <div class="page-header"><h2>Reports - Select a Team</h2></div>
        <p>
            <h4>Query by Team Numbers</h4>
            <form action="reportsDefenses.php">
                <div class="input-group">
                    <input type="text" class="form-control" name="tmNum1" placeholder="Team #">
                    <input type="text" class="form-control" name="tmNum2" placeholder="Team #">
                    <input type="text" class="form-control" name="tmNum3" placeholder="Team #">
                    <br/>
                    <span class="input-group-btn"><input type="submit" class="btn btn-primary" value="Go"/></span>
                </div>
            </form>
        </p>
        <br/>
        <p>       
            <?php if ($allMatches) { ?>
                <h4>Query by Match - All matches (<a href="reportsDefensesSelectTeams.php?all=false">see only Devilbotz</a>)</h4>
            <?php } else { ?>
                <h4>Query by Match - Devilbotz matches (<a href="reportsDefensesSelectTeams.php?all=true">see all</a>)</h4>
            <?php }
            
            $result = $db->query($query);
            $zeroRows = true;
                
            while ($row = mysqli_fetch_assoc($result)) {
                $zeroRows = false;
            ?>
                <p>Match <?= $row["matchnumber"] ?></p>
                <p>
                    <a class="btn btn-danger" href="reportsDefenses.php?tmNum1=<?= $row["redteam1"] ?>&tmNum2=<?= $row["redteam2"] ?>&tmNum3=<?= $row["redteam3"] ?>">
                        Red Alliance (<?= $row["redteam1"] ?>, <?= $row["redteam2"] ?>, <?= $row["redteam3"] ?>)
                    </a>
                </p>
                <p>
                    <a class="btn btn-primary" href="reportsDefenses.php?tmNum1=<?= $row["blueteam1"] ?>&tmNum2=<?= $row["blueteam2"] ?>&tmNum3=<?= $row["blueteam3"] ?>">
                        Blue Alliance (<?= $row["blueteam1"] ?>, <?= $row["blueteam2"] ?>, <?= $row["blueteam3"] ?>)
                    </a>
                </p
            <?php
            }
            if ($zeroRows) {
            ?>
                <p class="alert alert-warning" role="alert">No matches in schedule (likely reason: no schedule released yet)</p>
            <?php    
            }
            ?>
        </p>
    </div>
</body>
</html>