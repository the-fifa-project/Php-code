<?php
require 'dashboard_header.php';
require 'dashboard_navigation.php';

if (!isset($_SESSION['id']))
{
  header('location: ./dashboard_interconnector.php');
  exit;
}
?>

<div class="row justify-content-center">
  <div class="col-12 p-0">
    <h2 class="h4 p-1 bg-light rounded m-1 border shadow-sm">Owned Teams</h2>
  </div>
  <div class="col-12 row p-0">

    <div class="col-lg-6 my-1 p-0">
      <a href="team_detail.php?id={$allteam['teamId']}" class="bg-white border d-block p-1 rounded shadow-sm text-dark mx-1">
        <h2 class="h6">{$allteam['teamName']}</h2>
        <div class="d-flex justify-content-between">
          <p class="m-0">Goals: {$allteam['goals']}</p>
          <p class="m-0">Wins: {$allteam['wins']}</p>
          <p class="m-0">Loses: {$allteam['loses']}</p>
        </div>
        <div class="d-flex justify-content-between">
          <p class="m-0">Owner: {$allteam['ownerName']}</p>
          <p class="m-0">Spelers: 3</p>
        </div>
      </a>
    </div>

    <div class="col-lg-6 my-1 p-0">
      <a href="team_detail.php?id={$allteam['teamId']}" class="bg-white border d-block p-1 rounded shadow-sm text-dark mx-1">
        <h2 class="h6">{$allteam['teamName']}</h2>
        <div class="d-flex justify-content-between">
          <p class="m-0">Goals: {$allteam['goals']}</p>
          <p class="m-0">Wins: {$allteam['wins']}</p>
          <p class="m-0">Loses: {$allteam['loses']}</p>
        </div>
        <div class="d-flex justify-content-between">
          <p class="m-0">Owner: {$allteam['ownerName']}</p>
          <p class="m-0">Spelers: 3</p>
        </div>
      </a>
    </div>

    <div class="col-lg-6 my-1 p-0">
      <a href="team_detail.php?id={$allteam['teamId']}" class="bg-white border d-block p-1 rounded shadow-sm text-dark mx-1">
        <h2 class="h6">{$allteam['teamName']}</h2>
        <div class="d-flex justify-content-between">
          <p class="m-0">Goals: {$allteam['goals']}</p>
          <p class="m-0">Wins: {$allteam['wins']}</p>
          <p class="m-0">Loses: {$allteam['loses']}</p>
        </div>
        <div class="d-flex justify-content-between">
          <p class="m-0">Owner: {$allteam['ownerName']}</p>
          <p class="m-0">Spelers: 3</p>
        </div>
      </a>
    </div>

    <div class="col-lg-6 my-1 p-0">
      <a href="team_detail.php?id={$allteam['teamId']}" class="bg-white border d-block p-1 rounded shadow-sm text-dark mx-1">
        <h2 class="h6">{$allteam['teamName']}</h2>
        <div class="d-flex justify-content-between">
          <p class="m-0">Goals: {$allteam['goals']}</p>
          <p class="m-0">Wins: {$allteam['wins']}</p>
          <p class="m-0">Loses: {$allteam['loses']}</p>
        </div>
        <div class="d-flex justify-content-between">
          <p class="m-0">Owner: {$allteam['ownerName']}</p>
          <p class="m-0">Spelers: 3</p>
        </div>
      </a>
    </div>

  </div>
</div>

<?php
require 'dashboard_footer.php';
