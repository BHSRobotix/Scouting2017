<?php 
$ourTeamNum = "2876";
$ourTeamName = "Devilbotz";
$ourScoutsName = "DevilScoutz";
//$ourTeamNum = "5347";
//$ourTeamName = "Gryphons";
//$ourScoutsName = "Gryphons Scouts";

$eventstatusTable = "eventstatus";
$teamsTable = "teams";
$usersTable = "users";
$pitdataTable = "pitdata";
$matchesTable = "matches";
$bluealliancerankingsTable = "bluealliancerankings";
$matchresultsTable = "matchresults";
$driverfeedbackTable = "driverfeedback";
$performancesTable = "performances";
$scrapedrankingsTable = "scrapedrankings";

$teamsLoaded = true;
$matchesLoaded = false;

$showFutureTeammates = true;

require_once $_SERVER["DOCUMENT_ROOT"] . "/includes/Db.php";
$db = new Db();

$queryEventStatus = "SELECT * FROM ".$eventstatusTable." WHERE active = 'true';";
$resultEventStatus = $db->query($queryEventStatus);
$rowEvtStatus = mysqli_fetch_assoc($resultEventStatus);
$currEvent = $rowEvtStatus["eventkey"];
$currEventName = $rowEvtStatus["eventShortName"];
$currMatchNumber = $rowEvtStatus["currentMatchNumber"];

?>