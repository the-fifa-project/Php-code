<?php
require '../includes/config.php';

//checks of there is set an session

if (!isset($_SESSION['id']))
{
  header('location: ../index.php');
  exit;
}

$nav = $_GET['navderection'];

// dashboard home connector
if ($nav === '2sH65u7^lj')
{
  header("location: ./dashboard_page_home.php");
  exit;
}

// dashboard teams
if ($nav === '6L$6IQo2$c')
{
  header("location: ./dashboard_page_teams.php");
  exit;
}

// dashboard joined teams
if ($nav === '7hHIh1Lz$1')
{
  header("location: ./dashboard_page_joined_teams.php");
  exit;
}

// dashboard owned teams
if ($nav === '50cKcixZ*o')
{
  header("location: ./dashboard_page_owned_teams.php");
  exit;
}

// dashboard competition
if ($nav === 'BJbaVM@U41')
{
  header("location: ./dashboard_page_competition.php");
  exit;
}

// dashboard admin settings
if ($nav === 'yUOnR0A0l' && isset($_SESSION['admin']))
{
  header("location: ./dashboard_admin_settings.php");
  exit;
}

// dashboard user config
if ($nav === '4t1J62oOs' && isset($_SESSION['admin']))
{
  header("location: ./dashboard_admin_user_config.php");
  exit;
}

//laatste check
if (isset($_SESSION['id']))
{
  header("location: ./dashboard_page_home.php");
  exit;
}

header('location: ../index.php');
exit;