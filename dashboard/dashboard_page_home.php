<?php
require 'dashboard_header.php';
require 'dashboard_navigation.php';

if (!isset($_SESSION['id']))
{
  header('location: ./dashboard_interconnector.php');
  exit;
}

$sql = "SELECT * FROM `teams` ORDER BY points DESC";
$query = $db->query($sql);
$teams = $query->fetchAll(2);

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
    
  <div class="col-11 p-0">
    <h2 class="h4 p-1 bg-light rounded m-1 border shadow-sm">Top 5 teams</h2>
  </div>
<?php
  $num = 1;
  foreach($teams as $team)
  {
    if ($num <= 5)
    {
      echo "<div class=\"col-md-2 border shadow-ms m-1 p-1 rounded\">";
      echo '<p>' . 'Positie: ' . $num . '<br> Team: ' . $team['name'] . '<br>Punten: ' . $team['points'] . '</p>';
      echo "</div>";
    }
    $num++;
  }
?>





<?php
require 'dashboard_footer.php';
