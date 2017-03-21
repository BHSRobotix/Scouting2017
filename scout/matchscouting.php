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

<script>
    var increment = function(jqNumberInput) {
        var currVal = jqNumberInput.val();
        jqNumberInput.val(++currVal);
    };
    
    var decrement = function(jqNumberInput) {
        var currVal = jqNumberInput.val();
        jqNumberInput.val(currVal <= 0 ? 0 : --currVal);
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
        
        $(".btn-group button").click(function() {
            var jqInput = $(this).parent().find(':input[type="hidden"]');
            jqInput.val($(this).text());
            $(this).parent().find(".active").removeClass("active");
            $(this).addClass("active");
        });
        
        $(".trigger").click(function() {
            var triggeredId = $(this).parent().attr("rel").replace("trigger_","");
            $("#"+triggeredId).show();
        });
        $(".anti-trigger").click(function() {
            var triggeredId = $(this).parent().attr("rel").replace("trigger_","");
            $("#"+triggeredId).hide();
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

                <br/><br/>
                
                <!-- Autonomous -->
                <h4> Autonomous (first 15 seconds) </h4>

                <div class="subsection">Mobility</div>
                <div class="btn-group" role="group" aria-label="AutoMobility">
                    <button type="button" class="btn btn-default active">Does not move</button>
                    <button type="button" class="btn btn-default">Moves, no points</button>
                    <button type="button" class="btn btn-default">Drives 4 5</button>
                    <input type="hidden" name="autoMobility" value="Does not move"/>
                </div>
                
                <br/><br/>
                
                <div class="subsection">Gear</div>
                <div class="btn-group" role="group" aria-label="AutoGear" rel="trigger_autoGearPegLocationMoreInfo">
                    <button type="button" class="btn btn-default active anti-trigger">Does not deliver</button>
                    <button type="button" class="btn btn-default trigger">Delivers, too late</button>
                    <button type="button" class="btn btn-default trigger">Delivers and yay</button>
                    <input type="hidden" name="autoGear" value="Does not deliver"/>
                </div>
                
                <div class="conditional-info" id="autoGearPegLocationMoreInfo">
                <br/>
                <strong>Which Peg:</strong>
                <div class="btn-group" role="group" aria-label="AutoGearPegLocation">
                    <button type="button" class="btn btn-default">Boiler side</button>
                    <button type="button" class="btn btn-default active">Center</button>
                    <button type="button" class="btn btn-default">Retrieval Zone side</button>
                    <input type="hidden" name="autoGearPegLocation" value="Center"/>
                </div>
                </div>
                
                <br/><br/>

                <div class="subsection">Hopper</div>
                <div class="btn-group" role="group" aria-label="AutoHopper">
                    <button type="button" class="btn btn-default active">Does not trigger</button>
                    <button type="button" class="btn btn-default">Triggers, collects few</button>
                    <button type="button" class="btn btn-default">Triggers, collects most</button>
                    <input type="hidden" name="autoHopper" value="Does not trigger"/>
                </div>
                
                <br/><br/>

                <div class="subsection">Shooting (Approximate)</div>
                <table class="counting">
                  <tr>
                    <th></th>
                    <th>Made</th>
                    <th>Missed</th>
                  </tr>
                  <tr>
                    <td>High</td>
                    <td nowrap><span class="minus"></span><input type="number" name="autoShootHighSuccess" value="0"/><span class="plus"></span> </td>
                    <td nowrap><span class="minus"></span><input type="number" name="autoShootHighMissed" value="0"/><span class="plus"></span> </td>
                  </tr>
                  <tr>
                    <td>Low</td>
                    <td nowrap><span class="minus"></span><input type="number" name="autoShootLowSuccess" value="0"/><span class="plus"></span> </td>
                    <td nowrap><span class="minus"></span><input type="number" name="autoShootLowMissed" value="0"/><span class="plus"></span> </td>
                  </tr>
                </table>                
                
                <br/><br/>
                
                <!-- Tele-Op -->
                <h4> Tele-Op </h4>
                
                <div class="subsection">Reliability</div>
                <div class="btn-group" role="group" aria-label="Reliability" rel="trigger_reliabilityMoreInfo">
                    <button type="button" class="btn btn-default active anti-trigger">No problems</button>
                    <button type="button" class="btn btn-default trigger">Lost Conx</button>
                    <button type="button" class="btn btn-default trigger">Broke</button>
                    <button type="button" class="btn btn-default trigger">Other</button>
                    <input type="hidden" name="reliability" value="No problems"/>
                </div>
                
                <div class="conditional-info" id="reliabilityMoreInfo">
                <br/>
                <strong>Describe:</strong>
                <input type="text" name="reliabilityComments" placeholder="How long? What broke? Regained? etc." size="40"/>
                </div>
                
                <br/><br/>
                
                <div class="subsection">Fuel Intake</div>
                <table class="counting">
                  <tr>
                    <th>Ground</th>
                    <th>Hopper</th>
                    <th>Station</th>
                  </tr>
                  <tr>
                    <td nowrap><span class="minus"></span><input type="number" name="fuelIntakeGround" value="0"/><span class="plus"></span> </td>
                    <td nowrap><span class="minus"></span><input type="number" name="fuelIntakeHopper" value="0"/><span class="plus"></span> </td>
                    <td nowrap><span class="minus"></span><input type="number" name="fuelIntakeStation" value="0"/><span class="plus"></span> </td>
                  </tr>
                </table>
                
                <br/><br/>


                <div class="subsection">Shooting</div>
                <strong>Location:</strong> (Check all that apply) <br/>
                <div class="checkbox">
                    <label><input type="checkbox" name="shootLocation[]" value="none">No shooting</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="shootLocation[]" value="key">Inside the key</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="shootLocation[]" value="neutralZone">Near the neutral zone</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="shootLocation[]" value="retrievalArea">Near the retrieval area</label>
                </div>
                
                <br/><br/>
                
                <strong>Shots Made:</strong> (Approximate)<br/>
                <table class="counting">
                  <tr>
                    <th>High</th>
                    <th>Low</th>
                  </tr>
                  <tr>
                    <td nowrap><span class="minus"></span><input type="number" name="teleShootHighSuccess" value="0"/><span class="plus"></span> </td>
                    <td nowrap><span class="minus"></span><input type="number" name="teleShootLowSuccess" value="0"/><span class="plus"></span> </td>
                  </tr>
                </table>
                
                <br/><br/>
                
                <div class="subsection">Gears</div>                
                <table class="counting">
                  <tr>
                    <th>From Ground</th>
                    <th>From Station</th>
                    <th>Delivered Successfully</th>
                  </tr>
                  <tr>
                    <td nowrap><span class="minus"></span><input type="number" name="gearsPickupGround" value="0"/><span class="plus"></span> </td>
                    <td nowrap><span class="minus"></span><input type="number" name="gearsPickupStation" value="0"/><span class="plus"></span> </td>
                    <td nowrap><span class="minus"></span><input type="number" name="gearsDelivered" value="0"/><span class="plus"></span> </td>
                  </tr>
                </table>
                
                <br/><br/>
                
                <div class="subsection">Climbing</div>
                <strong>Rope:</strong> <br/>
                <div class="btn-group" role="group" aria-label="ClimbingRope">
                    <button type="button" class="btn btn-default active">Does not attempt</button>
                    <button type="button" class="btn btn-default">Fails to catch rope</button>
                    <button type="button" class="btn btn-default">Climbs partially</button>
                    <button type="button" class="btn btn-default">Climbs to top</button>
                    <input type="hidden" name="climbingRope" value="Does not attempt"/>
                </div>
                <br/><br/>
                <strong>Touchpad:</strong> <br/>
                <div class="btn-group" role="group" aria-label="ClimbingTouchpad">
                    <button type="button" class="btn btn-default active">Does not activate</button>
                    <button type="button" class="btn btn-default">Fails to activate long enough</button>
                    <button type="button" class="btn btn-default">Activates successfully</button>
                    <input type="hidden" name="climbingTouchpad" value="Does not activate"/>
                </div>
                
                <br/><br/>
                
                <div class="subsection">Defense</div>
                <strong>Did they play significant defense?</strong> <br/>
                <div class="btn-group" role="group" aria-label="Defense" rel="trigger_defenseMoreInfo">
                    <button type="button" class="btn btn-default trigger">Yes</button>
                    <button type="button" class="btn btn-default active anti-trigger">No</button>
                    <input type="hidden" name="defense" value="No"/>
                </div>
                <br/>
                <div class="conditional-info" id="defenseMoreInfo">
                <strong>Describe their defense:</strong>
                <input type="text" name="defenseComments"/>
                </div>
                
                <br/><br/>
                               
                <div class="subsection">Additional Comments</div>
                <input type="text" name="generalComments" style="width: 300px;" />

                <br/><br/>
                                
                <input type="submit" class="btn btn-primary" value="Save to Server" name="submit">
            </form>
        </p>

    <?php } ?>
        
    </div>
    
</body>
</html>
