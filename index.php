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
      <h4 class="display-4 text-white">INFO</h4>
      <p class="lead text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam laudantium reprehenderit inventore, ad est voluptate unde ullam explicabo, facilis id adipisci autem odit culpa architecto incidunt recusandae? Deserunt, dolorem ea?</p>
      
    </div>
    <div class="col-md-4">
    </div>
  </div>
</div>
<?php

require 'footer.php';
