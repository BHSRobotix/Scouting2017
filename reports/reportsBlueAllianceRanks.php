<?php
include "../includes/sessionCheck.php";
include "../includes/globalVars.php";

// Freshen the data?
$freshen = ($_SESSION['role'] == "admin") && ($_GET["freshen"] == "true");
$msg = "";
if ($freshen) {

    // Get theBlueAlliance data and push it to the DB
    $rankingsUrl = "http://www.thebluealliance.com/api/v2/event/".$currEvent."/rankings?X-TBA-App-Id=frc2876:scouting-system:v01";
   
    $json = file_get_contents($rankingsUrl);    
    $rankings = json_decode($json, true);

    $db -> query("TRUNCATE TABLE ".$bluealliancerankingsTable.";"); //wipe everything
    $msg .= $bluealliancerankingsTable . " TABLE truncated!<br/>";
   
    $countRanks = 0;
    foreach($rankings as &$team) {
        // Skip the lead one
        if ($team[0] != "Rank") {
            $query = "INSERT INTO ".$bluealliancerankingsTable." (eventkey, teamnumber, rank, rankingScore, auto, scaleChallenge, goals, defense, record, played) VALUES ("
                    .$db->quote($currEvent).","
                    .$db->quote($team[1]).","
                    .$db->quote($team[0]).","
                    .$db->quote($team[2]).","
                    .$db->quote($team[3]).","
                    .$db->quote($team[4]).","
                    .$db->quote($team[5]).","
                    .$db->quote($team[6]).","
                    .$db->quote($team[7]).","
                    .$db->quote($team[8]).");";
            //$msg .=  $query.'<br/><br/>';
            $result = $db -> query($query);
            $countRanks++;
        }
    }

    $msg .= "Successfully reloaded ".$countRanks." team rankings from url:".$rankingsUrl."<br/>";

    $statsUrl = "http://www.thebluealliance.com/api/v2/event/".$currEvent."/stats?X-TBA-App-Id=frc2876:scouting-system:v01";
    
    $json = file_get_contents($statsUrl);    
    $stats = json_decode($json, true);

    // Update the table we just made with each of the thingies
    foreach($stats['oprs'] as $tm => $val) {
        $query = "UPDATE ".$bluealliancerankingsTable." SET oprs=".$db->quote($val)." WHERE teamnumber=".$db->quote($tm).";";
        //$msg .=  $query.'<br/><br/>';
        $result = $db -> query($query);
    }
    foreach($stats['ccwms'] as $tm => $val) {
        $query = "UPDATE ".$bluealliancerankingsTable." SET ccwms=".$db->quote($val)." WHERE teamnumber=".$db->quote($tm).";";
        //$msg .=  $query.'<br/><br/>';
        $result = $db -> query($query);
    }
    foreach($stats['dprs'] as $tm => $val) {
        $query = "UPDATE ".$bluealliancerankingsTable." SET dprs=".$db->quote($val)." WHERE teamnumber=".$db->quote($tm).";";
        //$msg .=  $query.'<br/><br/>';
        $result = $db -> query($query);
    }

    $msg .= "Successfully reloaded OPRS, CCWMS and DPRS rankings data for url:".$statsUrl."<br/>";

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Rankings From TBA</title>
  <script src="../includes/sortable.js"></script>
  <?php include "../includes/allCss.php" ?>
  <link rel="stylesheet" href="../includes/sortable-theme-bootstrap.css" />

</head>
<body>
    <?php include "../includes/userHeader.php" ?>
    <div class="container">
        <?php if ($freshen) { ?><div class="alert alert-warning" role="alert"><strong> <?= $msg ?> </strong></div><?php } ?>

        <div class="page-header"><h2>Reports - Rankings from The Blue Alliance</h2></div>

        <!-- table class="table table-striped sortable-theme-bootstrap" data-sortable-->
        <table data-sortable>
            <thead>
                <tr>
                    <th scope="col">Rank</th><th scope="col">Team #</th><th scope="col">Score</th>
                    <th scope="col">Auto</th><th scope="col">Challenge</th>
                    <th scope="col">Goals</th><th scope="col">Defense</th>
                    <th scope="col">Record</th><th scope="col">Played</th>
                    <th scope="col">OPRS</th><th scope="col">CCWMS</th><th scope="col">DPRS</th>
                </tr>
            </thead>
            <tbody>    
            <?php
            $query1 = "SELECT * FROM ".$bluealliancerankingsTable." WHERE eventkey = '".$currEvent."' ORDER BY rank ASC;";
            $result1 = $db->query($query1);
            while ($row = mysqli_fetch_assoc($result1)) {
            ?>
                <tr>
                    <td><?= $row['rank'] ?></td><td><a href="reportsSingleTeam.php?tmNum=<?= $row['teamnumber'] ?>"><?= $row['teamnumber'] ?></a></td><td><?= $row['rankingScore'] ?></td>
                    <td><?= $row['auto'] ?></td><td><?= $row['scaleChallenge'] ?></td>
                    <td><?= $row['goals'] ?></td><td><?= $row['defense'] ?></td>
                    <td><?= $row['record'] ?></td><td><?= $row['played'] ?></td>
                    <td><?= $row['oprs'] ?></td><td><?= $row['ccwms'] ?></td><td><?= $row['dprs'] ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
        

    </div>
        
</body>
</html>
