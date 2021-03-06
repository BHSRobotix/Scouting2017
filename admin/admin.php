<?php
$subDir = true;
include "../includes/sessionCheck.php";
include "../includes/globalVars.php";
if ($_SESSION['role'] != "admin") {
    header("Location: ../index.php");
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Admin Panel</title>
    <?php include "../includes/allCss.php" ?>
<style>
.button-actions-set {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
</style>
</head>
<body>
    <?php include "../includes/userHeader.php" ?>
    <div class="container button-actions-set">
    
        <p><a href="../reports/reportsBlueAllianceRanks.php?freshen=true" class="btn btn-block btn-primary">Update TheBlueAlliance Rankings</a></p>
        <p><a href="updateCurrMatchNum.php" class="btn btn-block btn-info">Update Current Match Number</a></p>
        <p><a href="createuser.php" class="btn btn-block btn-success">Create a <?= $ourScoutsName ?> User</a></p>
        <?php if ($_SESSION['username'] == "ricko") { ?>
        <p><a href="loadteams.php?force=true&truncate=true" class="btn btn-block btn-warning">Reload Teams from The Blue Alliance</a></p>
        <p><a href="loadmatch.php?truncate=true" class="btn btn-block btn-warning">Reload Matches from The Blue Alliance</a></p>
        <?php } ?>
<!--         <p><a href="loadmatchManual.php" class="btn btn-block btn-primary">Enter Match Schedule Manually</a></p> -->
<!--         <p><a href="loadmatchresultsManual.php" class="btn btn-block btn-success">Enter Match Results Manually</a></p> -->
        <p><a href="postRankings.php" class="btn btn-block btn-danger">Post Rankings</a></p>
        
    </div>
</body>
</html>