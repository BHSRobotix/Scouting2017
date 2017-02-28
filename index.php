<?php include "includes/sessionCheck.php" ?>
<?php include "includes/globalVars.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Choose your adventure!</title>
  <?php include "includes/allCss.php" ?>

<style>
.button-actions-set {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
</style>
  
</head>

<body role="document">

  <!-- Fixed navbar -->
  <?php include "includes/userHeader.php" ?>
    
  <!-- Primary Page Layout --> 
  <div class="container button-actions-set" role="main">

      <p><a href="reports/teams.php" class="btn btn-block btn-primary">Team List</a></p>
      <p><a href="scout/matchscoutingSelect.php" class="btn btn-block btn-success">Match Scouting</a></p>
      <p><a href="driver/driverfeedbackSelect.php" class="btn btn-block btn-info">Driver Feedback</a></p>
      <p><a href="reports/reportsMain.php" class="btn btn-block btn-warning">Reports</a></p>
      <?php if ($_SESSION['role'] == "admin") { ?><p><a href="admin/admin.php" class="btn btn-block btn-danger">Admin</a></p><?php } ?>
      <p><a href="logout.php" class="btn btn-block btn-default">Log Out</a></p>
  </div>

</body>
</html>

