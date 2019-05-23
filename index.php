<?php
/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 9-5-2019
 * Time: 15:40
 */
require 'header.php';

$sql = "SELECT * FROM `teams`";
$query = $db->query($sql);
$teams = $query->fetchAll(2);
// var_dump($teams);

$teamsArray = array(1,2,3,4);
$compititionArry = array();

//foreach ($teams as $team) {
//  array_push($teamsArray, $team['name']);
//}

$arrLength = count($teamsArray);
$count = 1;
?>

<div class="container">
  <div class="row">
    <div class="col-md-8">
      <table class="table table-hover table-sm text-center">
        <caption>List of competitions</caption>
        <thead class="thead-dark">
          <tr>
            <th scope="col">Nummer</th>
            <th scope="col">Teams 1</th>
            <th scope="col">-</th>
            <th scope="col">Team 2</th>
          </tr>
        </thead>
        <tbody>
          <?php
          for ($i = 0; $i < $arrLength; $i++) {
            for ($j = 0; $j < count($teamsArray); $j++) {
              if ($teamsArray[0] !== $teamsArray[$j]) {
                echo "<tr>
                <th scope=\"row\">$count</th>
                <td>$teamsArray[0]</td>
                <td>vs</td>
                <td>$teamsArray[$j]</td>
                </tr>";
                $count++;
              }
            }
            array_shift($teamsArray);
          }
          ?>
        </tbody>
      </table>
    </div>
    <div class="col-md-4">
      <h4 class="display-4">INFO</h4>
      <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam laudantium reprehenderit inventore, ad est voluptate unde ullam explicabo, facilis id adipisci autem odit culpa architecto incidunt recusandae? Deserunt, dolorem ea?</p>
    </div>
  </div>
</div>
<?php

require 'footer.php';
