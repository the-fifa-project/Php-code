<?php
require 'dashboard_header.php';
require 'dashboard_navigation.php';

if (!isset($_SESSION['id']) && !isset($_SESSION['admin']))
{
  header('location: ./dashboard_interconnector.php');
}

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

function generateRandomString($length) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#%^*';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

echo generateRandomString(15);
exit;
?>


<?php
  $teams = [
    1 => [
      'id' => 1,
      'points' => 0
    ],
    2 => [
      'id' => 2,
      'points' => 0
    ],
    3 => [
      'id' => 3,
      'points' => 0
    ],
    4 => [
      'id' => 4,
      'points' => 0
    ]
  ];

  $match = [
    1 => [
      'id1' => 1,
      'id2' => 2,
      'score1' => 2,
      'score2' => 2,
      'points1' => 0,
      'points2' => 0
    ],
    2 => [
      'id1' => 1,
      'id2' => 3,
      'score1' => 4,
      'score2' => 2,
      'points1' => 0,
      'points2' => 0
    ]
  ];

  echo '<pre>';
  foreach($match as &$m)
  {
    $score1 = $m['score1'];
    $score2 = $m['score2'];
    $points1 = $m['points1'];
    $points2 = $m['points2'];

    echo "<p>before caclulation: $score1 - $score2 : $points1 - $points2</p>";
    if ($score1 > $score2)
    {
      $points1 += 3;
      $points2 += 0;
    }
    else if ($m['score1'] < $m['score2'])
    {
      $points1 += 0;
      $points2 += 3;
    }
    else if ($m['score1'] === $m['score2'])
    {
      $points1 += 1;
      $points2 += 1;
    }
    echo "<p>after caclulation: $score1 - $score2 : $points1 - $points2</p>";

    $m['points1'] = $points1;
    $m['points2'] = $points2;
  }
  var_dump($match[1]);

  $sql = "SELECT points_team1 FROM `matches` WHERE team1 = 2";
  $query = $db->query($sql);
  $pointsOfTeamOne = $query->fetchAll(2);
  
  $sql = "SELECT points_team2 FROM `matches` WHERE team2 = 2";
  $query = $db->query($sql);
  $pointsOfTeamTwo = $query->fetchAll(2);

  var_dump($pointsOfTeamOne);
  var_dump($pointsOfTeamTwo);

  $pointsOne = 0;
  $pointsTwo = 0;

  foreach($pointsOfTeamOne as &$poto)
  {
    $pointsOne += $poto['points_team1'];
  }

  foreach($pointsOfTeamTwo as &$pott)
  {
    $pointsTwo += $pott['points_team2'];
  }

  $sum = $pointsOne + $pointsTwo;
  echo $sum;

  $teams[1]['points'] = $sum;
  echo '<h2>teams</h2>';
  var_dump($teams);










?>












<?php
require 'dashboard_footer.php';
