<?php
require 'header.php';

//$sql = "SELECT * FROM `teams`";
//$query = $db->query($sql);
//$teams = $query->fetchAll(2);
//
//echo '<pre>';
//$teamsArray = array();
//$compititionArry = array();
//$dataA = array();
//$arr1or2 = array(0, 1);
//
//foreach ($teams as $team) {
//  array_push($teamsArray, $team['name']);
//}
//
//$arrLength = count($teamsArray);
//$count = 1;
//
//for ($i = 0; $i < $arrLength; $i++) {
//  for ($j = 0; $j < count($teamsArray); $j++) {
//    if ($teamsArray[0] !== $teamsArray[$j]) {
//
//      $second = [$teamsArray[0], $teamsArray[$j]];
//      $newA = array_push($dataA, $second);
//    }
//  }
//  array_shift($teamsArray);
//}
//
//shuffle($dataA);
//
//?>
<!--<table class="table table-hover table-sm text-center">-->
<!--  <caption>List of competitions</caption>-->
<!--  <thead class="thead-dark">-->
<!--    <tr>-->
<!--      <th scope="col">Nummer</th>-->
<!--      <th scope="col">Teams 1</th>-->
<!--      <th scope="col">-</th>-->
<!--      <th scope="col">Team 2</th>-->
<!--    </tr>-->
<!--  </thead>-->
<!--  <tbody>-->
<!--    --><?php
//    for ($i = 0; $i < count($dataA); $i++) {
//      (int) $select1 = $arr1or2[0];
//      (int) $select2 = $arr1or2[1];
//      echo "<tr>
//        <th scope=\"row\">$count</th>
//        <td>{$dataA[$i][$select1]}</td>
//        <td>vs</td>
//        <td>{$dataA[$i][$select2]}</td>
//        </tr>";
//        shuffle($arr1or2);
//      $count++;
//    }
//    ?>
<!--  </tbody>-->
<!--</table>-->
<!---->
<?php
//
//$oefen = ['kees','piet','jan','klaas'];
//
//// (int) $num = count($oefen) -1;
//for ($i = 0; $i < count($oefen); $i++)
//{
//  echo "<p>$oefen[$i] - {$oefen[count($oefen) - ($i + 1)]}</p>";
//}
//$teams = array(1,2,3,4,5);
//
//for ($i = 0; $i < count($teams); $i++)
//{
//    echo "<p> Game $i:</p>";
//    for ($j = 0; $j < count($teams); $j++)
//    {
//        if ($teams[$i] !== $teams[$j] && $teams[$j] !== $teams[$i])
//        {
//            echo "<p>$teams[$j] - $teams[$i]</p>";
//        }
//    }
//}
//$array = array();
//$compitition = Validator::GetJson("includes/compititions.json");
$compitition = [0 => [1,2,"9:00", "1"],1 => [3,4,"9:00", "2"], 2 => [5,6,"9:00", "13"]];
var_dump($compitition);

Validator::SaveToJson("includes/compititions.json", $compitition);
