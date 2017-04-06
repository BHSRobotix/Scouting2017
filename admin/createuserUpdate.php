<?php
include "../includes/sessionCheck.php";
include "../includes/globalVars.php";

if ($_SESSION['role'] != "admin") {
    header("Location: /index.php");
} else {    
    $query = "INSERT INTO ".$usersTable." (team, username, password, realname, role, creationdate) VALUES ("
            . $db->quote($_POST['team']) . ","
            . $db->quote($_POST['username']) . ","
            . $db->quote($_POST['username']) . ","
            . $db->quote($_POST['realname']) . ","
            . $db->quote($_POST['role']) . ","
            . "'".date("Y-m-d H:i:s") . "');";
    
    $result = $db->query($query);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Create User Update</title>
    <?php include "../includes/allCss.php" ?>
</head>
<body>
    <?php include "../includes/userHeader.php" ?>
    <div class="container">
        <?php if ($result) { ?>
            <div class="page-header"><h2 id="Header">Created user <?= $_POST['username'] ?></h2></div>
            <div>Successfully created a new user!  Their initial password is the same as their username.</div>
        <?php } else { ?>
            <div class="page-header"><h2 id="Header" class="error">Could not create user <?= $_POST['username'] ?></h2></div>
            <div>There was a problem with the database!  <span class="error">Most likely problem: duplicate username to an existing username.</span></div>
        <?php } ?>
    </div>
</body>
</html>