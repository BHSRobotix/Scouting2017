<?php
include "../includes/sessionCheck.php";
include "../includes/globalVars.php";

?>
<!DOCTYPE html>
<html>
<head>
    <title>Reports - Alliance Selection Helper</title>
    <?php include "../includes/allCss.php" ?>
</head>
<body>

    <?php include "../includes/userHeader.php" ?>
    <div class="container">
        
        <h4>Top 10 High Shooters</h4>
        <table class="table table-striped">
            <thead>
                   <tr><th scope="col">Rank</th><th scope="col">Team Number</th><th scope="col">High Shots Made</th><th scope="col">High Shots Attempted</th></tr>
            </thead>
            <tbody>
            <?php
            $query1 = "SELECT teamNumber, SUM(tele_shot_high_success) as totalHiShotsMade, SUM(tele_shot_high_attempt) AS totalHiShotsTaken FROM ".$performancesTable." WHERE eventkey='".$currEvent."' GROUP BY teamNumber ORDER BY totalHiShotsMade DESC, totalHiShotsTaken ASC LIMIT 10;";
            $result1 = $db->query($query1);
            while ($row = mysqli_fetch_assoc($result1)) {
            ?>
                <tr>
                    <td><?= $row["rank"] ?></td>
                    <td><a href="reportsSingleTeam.php?tmNum=<?= $row["teamNumber"] ?>"><?= $row['teamNumber'] ?></a></td>
                    <td><?= $row['totalHiShotsMade'] ?></td>
                    <td><?= $row['totalHiShotsTaken'] ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
        
        <h4>Top 10 Low Shooters</h4>
        <table class="table table-striped">
            <thead>
                   <tr><th scope="col">Rank</th><th scope="col">Team Number</th><th scope="col">Low Shots Made</th><th scope="col">Low Shots Attempted</th></tr>
            </thead>
            <tbody>
            <?php
            $query1 = "SELECT teamNumber, SUM(tele_shot_low_success) as totalLoShotsMade, SUM(tele_shot_low_attempt) AS totalLoShotsTaken FROM ".$performancesTable." WHERE eventkey='".$currEvent."' GROUP BY teamNumber ORDER BY totalLoShotsMade DESC, totalLoShotsTaken ASC LIMIT 10;";
            $result1 = $db->query($query1);
            while ($row = mysqli_fetch_assoc($result1)) {
            ?>
                <tr>
                    <td><?= $row["rank"] ?></td>
                    <td><a href="reportsSingleTeam.php?tmNum=<?= $row["teamNumber"] ?>"><?= $row['teamNumber'] ?></a></td>
                    <td><?= $row['totalLoShotsMade'] ?></td>
                    <td><?= $row['totalLoShotsTaken'] ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
        

        <h4>Top 5 Scalers</h4>
        <table class="table table-striped">
            <thead>
                   <tr><th scope="col">Rank</th><th scope="col">Team Number</th><th scope="col">Successful Scales</th></tr>
            </thead>
            <tbody>
            <?php
            $query1 = "SELECT teamNumber, SUM(tele_scaled) as totalScaled FROM ".$performancesTable." WHERE eventkey='".$currEvent."' GROUP BY teamNumber ORDER BY totalScaled DESC LIMIT 5;";
            $result1 = $db->query($query1);
            while ($row = mysqli_fetch_assoc($result1)) {
            ?>
                <tr>
                    <td><?= $row["rank"] ?></td>
                    <td><a href="reportsSingleTeam.php?tmNum=<?= $row["teamNumber"] ?>"><?= $row['teamNumber'] ?></a></td>
                    <td><?= $row['totalScaled'] ?></td>
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
