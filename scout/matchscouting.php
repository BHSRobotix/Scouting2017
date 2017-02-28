<?php
include "../includes/sessionCheck.php";
include "../includes/globalVars.php";

// Get the team to do a report on
$method = $_SERVER['REQUEST_METHOD'];
$team = $ourTeamNum;
$matchnumber = "1";
if ($method == "GET") {
    $team = $_GET["tmNum"];
    $matchnumber = $_GET["matchNum"];
    $source = $_GET["source"];
} else if ($method == "POST") {
    $team = $_POST["tmNum"];
    $matchnumber = $_POST["matchNum"];
    $source = $_POST["source"];
}

// Some quick and dirty error checking, in case manual team numbers put in
if ($source != "schedule") {
    $inputErrors = false;
    $inputErrorsMsg = "";
    $query = "SELECT * FROM ".$teamsTable." WHERE number=" . $team . " AND eventkey=" . $db->quote($currEvent) . ";";
    $result = $db->query($query);
    if ($result->num_rows != 1) {
        $inputErrors = true;
        $inputErrorsMsg .= "Team ".$team." is not at this competition.<br/>";
    }
    if (intval($matchnumber) > 120) {
        $inputErrors = true;
        $inputErrorsMsg .= "The match number appears invalid.<br/>";    
    }
}

// Get team name from DB for niceness
$queryTeamsTable = "SELECT * FROM ".$teamsTable." WHERE number = '" . $team . "';";
$resultTeamsTable = $db->query($queryTeamsTable);
$row = mysqli_fetch_assoc($resultTeamsTable);
$teamName = $row['name'];

?>
<!DOCTYPE html>
<html>
<head>
    <title>Match Scouting</title>
    <?php include "../includes/allCss.php" ?>

<style>
h4 {
    color: skyblue;
}
</style>
<script>
    var increment = function(jqNumberInput) {
        var currVal = jqNumberInput.val();
        jqNumberInput.val(++currVal);
    };
    
    var decrement = function(jqNumberInput) {
        var currVal = jqNumberInput.val();
        jqNumberInput.val(--currVal);
    };
    
    $(document).ready(function() {
        $(".minus").click(function() {
            var jqEl = $(this).parent().find(':input[type="number"]');
            decrement(jqEl);
        });
        $(".plus").click(function() {
            var jqEl = $(this).parent().find(':input[type="number"]');
            increment(jqEl);
        });
    });

</script>
</head>

<body>
    <?php include "../includes/userHeader.php" ?>

    <div class="container">
    
    <?php if ($inputErrors) { ?>
        <div class="alert alert-danger" role="alert"><?= $inputErrorsMsg ?></div>
        <a class="btn btn-primary" href="javascript:window.history.back()"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Go Back</a>
    <?php } else { ?>

        <div class="page-header"><h2>Match Scouting</h2></div>

        <div class="page-header"><h3>Team: <?= $team ?> - <?= $teamName ?> <br/>Match: <?= $matchnumber ?></h3></div>

        <p>
            <form action="matchscoutingUpdate.php" method="post">
                <input type="hidden" name="teamnumber" value="<?= $team ?>"/>
                <input type="hidden" name="matchnumber" value="<?= $matchnumber ?>"/>
                
                Are they functional? <br>
                <input type="radio" name="isFunctional" value="yes" id= "funcyes"> <label for= "funcyes"> Yes </label> 
                <input type="radio" name="isFunctional" value="no" id= "funcno"> <label for= "funcno"> No </label>

                <br/><br/>

                <h4> Autonomous </h4>

                Did they <strong> reach </strong> during <strong> autonomous</strong>? <br/>
                <input type="radio" name="autoReach" value="yes" id="autoreachYes"> <label for= "autoreachYes"> Yes </label> <br/>
                <input type="radio" name="autoReach" value="no"  id="autoreachNo" > <label for= "autoreachNo"> No </label> <br/>
                
                <br/><br/>

                Did they <strong> cross a defense </strong> during <strong> autonomous</strong>? <br/>
                <table>
                <tr>
                <td><input type="radio" name="autoCross" value="Portcullis"      id="autocrossPortcullis"   > <label for= "autocrossPortcullis"> <span class="defense portcullis"></span> </label> </td>
                <td><input type="radio" name="autoCross" value="Cheval de Frise" id="autocrossChevalDeFrise"> <label for= "autocrossChevalDeFrise"> <span class="defense chevaldefrise"></span> </label> </td>
                </tr>

                <tr>
                <td><input type="radio" name="autoCross" value="Moat"          id="autocrossMoat"         > <label for= "autocrossMoat"> <span class="defense moat"></span> </label> </td>
                <td><input type="radio" name="autoCross" value="Ramparts"      id="autocrossRamparts"     > <label for= "autocrossRamparts"> <span class="defense ramparts"></span> </label> </td>
                </tr>

                <tr>
                <td><input type="radio" name="autoCross" value="Drawbridge"    id="autocrossDrawbridge"   > <label for= "autocrossDrawbridge"> <span class="defense drawbridge"></span> </label> </td>
                <td><input type="radio" name="autoCross" value="Sally Port"    id="autocrossSallyPort"    > <label for= "autocrossSallyPort"> <span class="defense sallyport"></span> </label> </td>
                </tr>

                <tr>
                <td><input type="radio" name="autoCross" value="Rock Wall"     id="autocrossRockWall"     > <label for= "autocrossRockWall"> <span class="defense rockwall"></span> </label> </td>
                <td><input type="radio" name="autoCross" value="Rough Terrain" id="autocrossRoughTerrain" > <label for= "autocrossRoughTerrain"> <span class="defense roughterrain"></span> </label> </td>
                </tr>

                <tr>
                <td><input type="radio" name="autoCross" value="Low Bar"       id="autocrossLowBar"       > <label for= "autocrossLowBar"> <span class="defense lowbar"></span> </label> </td>
                <td><input type="radio" name="autoCross" value="None"          id="autocrossNone"         > <label for= "autocrossNone"> <span>None</span> </td>
                </tr>
                </table>
                
                <br/><br/>

                Did they <strong> shoot </strong> during <strong> autonomous</strong>? <br/>
                <input type="radio" name="autoShoot" value="didntShoot" id="autoDidntShoot">
                <label for= "autoDidntShoot"> No autonomous shot attempted </label>
                <br/>
                <input type="radio" name="autoShoot" value="missedLow" id="autoShootMissedLow">
                <label for= "autoShootMissedLow"> They shot at the low goal and missed </label>
                <br/>
                <input type="radio" name="autoShoot" value="madeLow" id="autoShootMadeLow">
                <label for= "autoShootMadeLow"> They shot at the low goal and scored </label>
                <br/>
                <input type="radio" name="autoShoot" value="missedHigh" id="autoShootMissedHigh">
                <label for= "autoShootMissedHigh"> They shot at the high goal and missed </label>
                <br/>
                <input type="radio" name="autoShoot" value="madeHigh" id="autoShootMadeHigh">
                <label for= "autoShootMadeHigh"> They shot at the high goal and scored </label>

                <br/><br/>
                
                <h4> Tele-Op </h4>
                
                How many times did they <strong> cross each defense </strong> ? <br/>
                <table>
                <tr>
                <td nowrap><span class="defense portcullis"></span><br/><span class="minus"></span><input type="number" name="telecrossPortcullis" value="0"/><span class="plus"></span> </td>
                <td nowrap><span class="defense chevaldefrise"></span><br/><span class="minus"></span><input type="number" name="telecrossChevalDeFrise" value="0"/><span class="plus"></span> </td>
                </tr>

                <tr>
                <td><span class="defense moat"></span> <span class="minus"></span><input type="number" name="telecrossMoat" value="0"/><span class="plus"></span> </td>
                <td><span class="defense ramparts"></span> <span class="minus"></span><input type="number" name="telecrossRamparts" value="0"/><span class="plus"></span> </td>
                </tr>

                <tr>
                <td><span class="defense drawbridge"></span> <span class="minus"></span><input type="number" name="telecrossDrawbridge" value="0"/><span class="plus"></span> </td>
                <td><span class="defense sallyport"></span> <span class="minus"></span><input type="number" name="telecrossSallyPort" value="0"/><span class="plus"></span> </td>
                </tr>

                <tr>
                <td><span class="defense rockwall"></span> <span class="minus"></span><input type="number" name="telecrossRockWall" value="0"/><span class="plus"></span> </td>
                <td><span class="defense roughterrain"></span> <span class="minus"></span><input type="number" name="telecrossRoughTerrain" value="0"/><span class="plus"></span> </td>
                </tr>

                <tr>
                <td><span class="defense lowbar"></span> <span class="minus"></span><input type="number" name="telecrossLowBar" value="0"/><span class="plus"></span> </td>
                <td></td>
                </tr>
                </table>
                
                <br/><br/>


                Did they <strong> shoot </strong> during <strong> tele-op</strong>? <br/>
                <table>
                <tr>
                <td> </td>
                <td>Made </td>
                <td>Missed </td>
                </tr>
                
                <tr>
                <td>Low Goal</td>
                <td><span class="minus"></span><input type="number" name="teleShotLowSuccess" value="0"/><span class="plus"></span></td>
                <td><span class="minus"></span><input type="number" name="teleShotLowMissed" value="0"/><span class="plus"></span></td>
                </tr>
                
                <tr>
                <td>High Goal</td>
                <td><span class="minus"></span><input type="number" name="teleShotHighSuccess" value="0"/><span class="plus"></span></td>
                <td><span class="minus"></span><input type="number" name="teleShotHighMissed" value="0"/><span class="plus"></span></td>
                </tr>

                </table> 
                
                <br/><br/>
                
                Did they <strong> challenge the tower</strong>? <br>
                <input type="radio" name="teleChallenged" value="1" id= "teleChallengedYes"> <label for= "teleChallengedYes"> Yes </label> 
                <input type="radio" name="teleChallenged" value="0" id= "teleChallengedNo"> <label for= "teleChallengedNo"> No </label>

                <br/><br/>
                
                Did they <strong> scale the tower</strong>? <br>
                <input type="radio" name="teleScaled" value="1" id= "teleScaledYes"> <label for= "teleScaledYes"> Yes </label> 
                <input type="radio" name="teleScaled" value="0" id= "teleScaledNo"> <label for= "teleScaledNo"> No </label>

                <br/><br/>

                
                <strong><font size="3" color="deepskyblue"> Additional Comments </font></strong> <br>
                <input type="text" name="comments" style="width: 300px;" />

                <br/><br/>
                                
                <input type="submit" class="btn btn-primary" value="Save to Server" name="submit">
            </form>
        </p>

    <?php } ?>
        
    </div>
    
</body>
</html>
