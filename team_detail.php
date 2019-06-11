<?php
require 'header.php';

//checks of er een id is meegegeven
if (!isset($_GET['id'])) {
  header("location: teams.php");
  exit;
}

// select the information of the teams (owner, goals, wins and more)
$teamID = $_GET['id'];
$sql = "SELECT t.*, 
               u.firstname as first,
               u.middlename as middle,
               u.lastname as last
        FROM `teams` t
        INNER JOIN `users` u ON t.owner = u.id
        WHERE t.id = :id";
$prepare = $db->prepare($sql);
$prepare->execute([
  'id' => $teamID
]);
$team = $prepare->fetch(2);
$ownerName = "{$team['first']} {$team['middle']} {$team['last']}";

$sql = "SELECT u.firstname as first, 
               u.middlename as middle, 
               u.lastname as last 
        FROM `user_team` ut 
        INNER JOIN `users` u ON ut.user = u.id
        WHERE ut.team = :id";
$prepare = $db->prepare($sql);
$prepare->execute([
  'id' => $teamID
]);
$teamPlayers = $prepare->fetchAll(2);
?>

<main>
  <div class="container">
    <div class="row my-4 shadow-lg p-4 rounded">
      <div class="col-sm-12">
        <div class="d-flex justify-content-between">
          <div class="d-flex align-items-center">
            <h2 class="display-4"><?= $team['name'] ?></h2>
            <small class="form-text text-muted m-0 ml-1 h6">Eigenaar: <?=$ownerName?></small>
          </div>
          <h2 class="display-4">Points: <?=$team['points']?></h2>
        </div>
      </div>
      <div class="col-md-9 col-lg-10">
        <table class="w-100 table-sm table-borderless table-hover">
          <caption>Spelers in het team</caption>
          <thead class="thead-light">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $count = 1;
              foreach ($teamPlayers as $teamplayer)
              {
                echo "<tr>
                        <th scope=\"col\">$count</th>
                        <th scope=\"col\">{$teamplayer['first']} {$teamplayer['middle']} {$teamplayer['last']}</th>
                      </tr>";
                      $count++;
              }
            ?>
          </tbody>
        </table>
      </div>

      <!-- <div class="col-sm-12">
        <h2 class="display-4">Statstieken</h2>
      </div>
      <div class="col-md-4 col-lg-3">
        <ul>
          <li>Goals: 33</li>
          <li>Wins: 4</li>
          <li>Loses: 5</li>
        </ul>
      </div>
      <div class="col-md-8 col-lg-9">
        <table class="table table-hover table-sm text-center">
          <caption>Team Statstieken</caption>
          <thead class="thead-light">
            <tr>
              <th scope="col">Goals</th>
              <th scope="col">Gewonnen / Verloren</th>
              <th scope="col">Tegenstander</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="col">3</th>
              <th scope="col">verloren</th>
              <th scope="col">de vieze henkies</th>
            </tr>
          </tbody>
        </table>
      </div> -->
      <!-- end row -->
    </div>
</main>

<?php
require 'footer.php';

?>