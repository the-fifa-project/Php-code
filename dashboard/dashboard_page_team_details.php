<?php
require 'dashboard_header.php';
require 'dashboard_navigation.php';

if (!isset($_SESSION['id']) || !isset($_GET['id']))
{
  header('location: ./dashboard_interconnector.php');
  exit;
}

$team_id = $_GET['id'];
?>







<?php
require 'dashboard_footer.php';
