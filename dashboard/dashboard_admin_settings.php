<?php
require 'dashboard_header.php';
require 'dashboard_navigation.php';

if (!isset($_SESSION['id']) && !isset($_SESSION['admin']))
{
  header('location: ./dashboard_interconnector.php');
}
?>








<?php
require 'dashboard_footer.php';
