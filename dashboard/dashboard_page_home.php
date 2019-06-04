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
//var_dump($teams);


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

<div>
	<h1>Top Vijf Teams</h1>
	<?php
	$counter = 0;
		foreach ($teams as $team) {
			if ($counter < 5) 
			{
			echo "<h1> {$team['name']} : {$team['points']} </h1>";
			}
			$counter++;

		}
	?>







<?php
require 'dashboard_footer.php';
