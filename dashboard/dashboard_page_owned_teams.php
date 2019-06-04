<?php
//teams<?php
require 'dashboard_header.php';
require 'dashboard_navigation.php';

if (!isset($_SESSION['id']))
{
  header('location: ./dashboard_interconnector.php');
  exit;
}

$sql = "SELECT t.*, u.firstname as owner  
        FROM `teams` t
        INNER JOIN `users` u
        ON t.owner = u.id
        WHERE t.owner = :id";
$prepare = $db->prepare($sql);
$prepare->execute([
  'id' => $_SESSION['id']
]);
$teams = $prepare->fetchAll(2);

echo'<div class="row justify-content-center">';

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
    <h2 class="h4 p-1 bg-light rounded m-1 border shadow-sm">Alle Teams</h2>
  </div>
  <div class="col-12 row p-0">
    
    <?php
      foreach ($teams as $team)
      {
        echo "
        <div class=\"col-xl-3 col-lg-4 col-md-6 my-1 p-0\">
          <a href=\"dashboard_page_team_details.php?id={$team['id']}\" class=\"bg-white border d-block p-1  px-2 rounded shadow-sm text-dark mx-1\">
            <h2 class=\"h6\">{$team['name']}</h2>
            <div class=\"d-flex justify-content-between\">
              <p class=\"m-0\">Owner: {$team['owner']}</p>
              <p class=\"m-0\">points: {$team['points']}</p>
            </div>
          </a>
        </div>";
      }
    ?>

  </div>
  <div class="col-12 p-1">
    <button type="button" class="btn btn-info btn-lg w-100" data-toggle="modal" data-target="#myModal">Team aanmaken</button>
  </div>
</div>
								
				
<!-- Modal create team -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <form class="modal-content p-1 form" action="../includes/controller.php" method="post">
      <div class="modal-header">
        <h4 class="modal-title">Team aanmaken</h4>
      </div>

      <div class="modal-body row">
        <input type='hidden' name='type' value='createteam'>
        <label for="team-name ml-2">Team naam</label>
        <input type="text" placeholder="Bijvoorbeeld: Warriors" name="team-name" class=" mr-1 form-control shadow-sm" id="team-name">
        <small id="team-name" class="form-text text-muted ml-2">Een team naam kan maar 30 karakters lang zijn</small>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="col-4 btn btn-success">Aanmaken</button>
      </div>
    </form>

  </div>
</div>


<?php
require 'dashboard_footer.php';
