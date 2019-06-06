<?php

class Calculator
{
  public function MatchPointsCalculator($score_team1, $score_team2, $db, $match_id, $table)
  {

    $points_team1 = 0;
    $points_team2 = 0;
    if ($score_team1 > $score_team2)
    {
      $points_team1 = 3;
      $points_team2 = 0;
    }
    else if ($score_team1 < $score_team2)
    {
      $points_team1 = 0;
      $points_team2 += 3;
    }
    else if ($score_team1 === $score_team2)
    {
      $points_team1 = 1;
      $points_team2 = 1;
    }

    $sql = "UPDATE `$table`
            SET `score_team1` = :score1, 
                `score_team2` = :score2,
                `points_team1` = :points1,
                `points_team2` = :points2
            WHERE id = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        'score1' => $score_team1,
        'score2' => $score_team2,
        'points1' => $points_team1,
        'points2' => $points_team2,
        'id' => $match_id
    ]);
  }

  public function TeamPointsCalculator($id_team1, $id_team2, $db)
  {
    $pointsTeamOne = 0;
    $pointsTeamTwo = 0;

    //gets alle points of team1 if he is in the team1 place in the database
    $sql = "SELECT points_team1 FROM `matches` WHERE team1 = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
      'id' => $id_team1
    ]);
    $points_team1 = $prepare->fetchAll(2);

    foreach($points_team1 as $points)
    {
      $pointsTeamOne += $points['points_team1'];
    }
    
    //gets alle points of team1 if he is in the team2 place in the database
    $sql = "SELECT points_team2 FROM `matches` WHERE team2 = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
      'id' => $id_team1
    ]);
    $points_team1 = $prepare->fetchAll(2);

    foreach($points_team1 as $points)
    {
      $pointsTeamOne += $points['points_team1'];
    }
    
    //gets alle points of team2 if he is in the team1 place in the database
    $sql = "SELECT points_team1 FROM `matches` WHERE team1 = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
      'id' => $id_team2
    ]);
    $points_team2 = $prepare->fetchAll(2);
    
    foreach($points_team2 as $points)
    {
      $pointsTeamTwo += $points['points_team1'];
    }

    //gets alle points of team2 if he is in the team2 place in the database
    $sql = "SELECT points_team2 FROM `matches` WHERE team2 = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
      'id' => $id_team2
    ]);
    $points_team2 = $prepare->fetchAll(2);

    foreach($points_team2 as $points)
    {
      $pointsTeamTwo += $points['points_team2'];
    }

    $sql = "UPDATE `teams`
            SET `points` = :points
            WHERE id = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
      'id' => $id_team1,
      'points' => $pointsTeamOne
    ]);

    $sql = "UPDATE `teams`
            SET `points` = :points
            WHERE id = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
      'id' => $id_team2,
      'points' => $pointsTeamTwo
    ]);
  }

}