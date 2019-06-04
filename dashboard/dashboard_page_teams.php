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
        ON t.owner = u.id";
$query = $db->query($sql);
$teams = $query->fetchAll(2);


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



<?php
require 'dashboard_footer.php';