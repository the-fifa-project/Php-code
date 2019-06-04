<?php
require 'dashboard_header.php';
require 'dashboard_navigation.php';

if (!isset($_SESSION['id']) && !isset($_SESSION['admin']))
{
  header('location: ./dashboard_interconnector.php');
}

$sql = "SELECT * FROM `settings` WHERE id = 1";
$query = $db->query($sql);
$settings = $query->fetch(2);

$sql = "SELECT entered FROM `teams` WHERE entered is not null";
$query = $db->query($sql);
$totalTeams = $query->rowCount();

echo'<div class="row">';

if (isset($_GET['err']))
{
  $error = $_GET['err'];
  echo "<div class=\"col-12 p-0\"><h2 class=\"h4 p-1 ml-2 alert-danger rounded m-1 border shadow-sm\">$error</h2></div>";
}
else if (isset($_GET['succ']))
{
  $success = $_GET['succ'];
  echo "<div class=\"col-12 p-0\"><h2 class=\"h4 p-1 ml-2 alert-success rounded m-1 border shadow-sm\">$success</h2></div>";
}
  
?>

<div class="col-12 p-0">
  <h2 class="h4 p-1 bg-light rounded m-1 border shadow-sm">Settings</h2>
</div>

<div class="col-md-3 border rounded shadow-sm m-1">
  <h2 class="h3 border-bottom py-2">Tijd</h2>
  <form action="../includes/controller.php" method="post">
  <input type="hidden" name="type" value="timeSettings">
    <div class="form-group w-100">
      <label for="match_time">Wedstrijd Lengte <span class="text-muted">(In minuten)</span></label>
      <div class="form-inline align-items-center">
        <input type="number" min="0" name="match_time" class="form-control w-50" id="match_time" value="<?=$settings['match_time']?>">
        <p class="ml-1 h6">Minuten</p>
      </div>
      <small id="match_time" class="form-text text-muted">Tijd van hoelang een wedstrijd duurt</small>
    </div>

    <div class="form-group w-100">
      <label for="half_time">Wedstrijd rust lengte <span class="text-muted">(In minuten)</span></label>
      <div class="form-inline align-items-center">
        <input type="number" min="0" name="half_time" class="form-control w-50" id="half_time" value="<?=$settings['half_time']?>">
        <p class="ml-1 h6">Minuten</p>
      </div>
      <small id="half_time" class="form-text text-muted">Tijd van hoelang een rust in een wedstrijd duurt</small>
    </div>

    <div class="form-group w-100">
      <label for="break_time">Pauze tijd lengte <span class="text-muted">(In minuten)</span></label>
      <div class="form-inline align-items-center">
        <input type="number" min="0" name="break_time" class="form-control w-50" id="break_time" value="<?=$settings['break_time']?>">
        <p class="ml-1 h6">Minuten</p>
      </div>
      <small id="break_time" class="form-text text-muted">Tijd van hoelang een wedstrijd duurt</small>
    </div>

    <button type="submit" class="btn btn-success mb-3">Opslaan</button>
  </form>
</div>

<div class="col-md-3 border rounded shadow-sm m-1 mb-auto">
  <h2 class="h3 border-bottom py-2">Velden</h2>
  <form action="../includes/controller.php" method="post">
    <input type="hidden" name="type" value="fieldSettings">
    <div class="form-group w-100">
      <label for="fields">Aantal velden</label>
      <div class="form-inline align-items-center">
        <input type="number" min="0" name="fields" class="form-control w-50" id="fields" value="<?=$settings['fields']?>">
        <p class="ml-1 h6">Velden</p>
      </div>
      <small id="fields" class="form-text text-muted">Je moet minimaal 1 veld hebben wil je een compentitie beginnen!</small>
    </div>

    <button type="submit" class="btn btn-success mb-3">Opslaan</button>
  </form>
</div>

<div class="col-md-3 border rounded shadow-sm m-1 mb-auto">
  <h2 class="h3 border-bottom py-2">Compentitie</h2>
  <form action="../includes/controller.php" method="post">
    <input type="hidden" name="type" value="competitionGenerate">
    <div class="form-group w-100">
      <label for="startTime">Tijd hoelaat de eerste wedstrijd wordt gespeeld</label>
      <div class="form-inline align-items-center">
        <input type="time" name="startTime" class="form-control w-50" id="startTime" value="09:00">
        <p class="ml-1 h6">Tijd</p>
      </div>
      <small id="fields" class="form-text text-muted">Als je een compentitie wil starten moeten er minimaal 2 teams geentert zijn, anders kan er geen compentitie gemaakt worden. Er zijn op dit moment <span class="text-warning"><?=$totalTeams?> teams</span> die mee doen aan de competitie</small>
    </div>

    <button type="submit" class="btn btn-success mb-3">Opslaan</button>
  </form>
</div>







<?php
require 'dashboard_footer.php';
