<?php
include "../includes/sessionCheck.php";
include "../includes/globalVars.php";

$allMatches = ($_GET["all"] == "true" || $_POST["all"] == "true");
$query = "SELECT * FROM ".$matchesTable." WHERE eventkey = '" . $currEvent . "' ORDER BY matchnumber ASC;";

?>
<!DOCTYPE html>
<html>
<head>
    <title>Select Team for Match Scouting</title>
    <?php include "../includes/allCss.php" ?>
<style>
form {
  max-width: 330px;
  padding: 15px;
}
</style>

</head>
<body>
    <?php include "../includes/userHeader.php" ?>
    <div class="container">
        <div class="page-header">
            <?php if ($allMatches) { ?>
                <h2>Select a Team and Match to Scout - All matches (<a href="matchscoutingSelect.php?all=false">see only current matches</a>)</h2>
            <?php } else { ?>
                <h2>Select a Team and Match to Scout - Current matches (<a href="matchscoutingSelect.php?all=true">see all</a>)</h2>
            <?php } ?>
        </div>
        
        <?php
            $result = $db->query($query);
            $zeroRows = true;

            while ($row = mysqli_fetch_assoc($result)) {
                $zeroRows = false;
                if ($allMatches || ($row["matchnumber"] >= $currMatchNumber)) {
            ?>
            <p>Match <?= $row["matchnumber"] ?></p>
            <p>
                <a class="btn btn-danger" href="matchscouting.php?tmNum=<?= $row["redteam1"] ?>&matchNum=<?= $row["matchnumber"] ?>&source=schedule"><?= $row["redteam1"] ?></a>
                <a class="btn btn-danger" href="matchscouting.php?tmNum=<?= $row["redteam2"] ?>&matchNum=<?= $row["matchnumber"] ?>&source=schedule"><?= $row["redteam2"] ?></a>
                <a class="btn btn-danger" href="matchscouting.php?tmNum=<?= $row["redteam3"] ?>&matchNum=<?= $row["matchnumber"] ?>&source=schedule"><?= $row["redteam3"] ?></a>
            </p>
            <p>
                <a class="btn btn-primary" href="matchscouting.php?tmNum=<?= $row["blueteam1"] ?>&matchNum=<?= $row["matchnumber"] ?>&source=schedule"><?= $row["blueteam1"] ?></a>
                <a class="btn btn-primary" href="matchscouting.php?tmNum=<?= $row["blueteam2"] ?>&matchNum=<?= $row["matchnumber"] ?>&source=schedule"><?= $row["blueteam2"] ?></a>
                <a class="btn btn-primary" href="matchscouting.php?tmNum=<?= $row["blueteam3"] ?>&matchNum=<?= $row["matchnumber"] ?>&source=schedule"><?= $row["blueteam3"] ?></a>
            </p>
            <?php
                }
            }
            if ($zeroRows || $allMatches) {
            ?>  
            <?php if ($zeroRows) { ?><p class="alert alert-warning" role="alert">No matches in schedule (likely reason: no schedule released yet)</p><?php } ?>
            <p>
                <form action="matchscouting.php" method="post">
                    Manually choose a match and team:<br/>            
                    <input class="form-control" type="text" name="matchNum" placeholder="Match Number" /> <br/>
                    <input class="form-control" type="text" name="tmNum" placeholder="Team Number" /><br/>
                    <input type="submit" class="btn btn-primary" value=" Go "/>
                </form>
            </p>
            <?php    
            }
            ?>
            </div>
            
        </div>
    </div>
</body>
</html>