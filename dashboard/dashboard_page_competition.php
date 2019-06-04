<?php
require 'dashboard_header.php';
require 'dashboard_navigation.php';

if (!isset($_SESSION['id'])) 
{
  header('location: ./dashboard_interconnector.php');
  exit;
}

$sql = "SELECT m.id as match_id, m.time as time, m.field as field, t1.name as team1, t2.name as team2, m.score_team1 as scoreT1, m.score_team2 as scoreT2
        FROM `matches` m 
        INNER JOIN `teams` t1 ON m.team1 = t1.id
        INNER JOIN `teams` t2 ON m.team2 = t2.id";
$query = $db->query($sql);
$matches = $query->fetchAll(2);
$matchesCount = $query->rowCount();

echo'<div class="row justify-content-center">';

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
  
?>

  <div class="col-12 p-0">
    <h2 class="h4 p-1 bg-light rounded m-1 border shadow-sm">Competities</h2>
  </div>
<div class="col-12 row p-0">
  <table class="table table-borderless">
    <thead>
      <tr>
        <th scope="col">Match</th>
        <th scope="col">Team 1</th>
        <th scope="col">Team 2</th>
        <th scope="col">Tijd</th>
        <th scope="col">Veld</th>
        <?="<th scope=\"col\">Optie</th>"?>
      </tr>
    </thead>
    <tbody>
      <?php
        $matchCount = 1;
        foreach ($matches as $match)
        {
          echo '<tr>';
          echo "<td scope=\"row\">$matchCount</td>";
          echo "<td>{$match['team1']}</td>";
          echo "<td>{$match['team2']}</td>";
          echo "<td>{$match['time']}</td>";
          echo "<td>{$match['field']}</td>";
          if (isset($_SESSION['admin']))
          {
            if($match['scoreT1'] !== NULL || $match['scoreT2'] !== NULL || $match['scoreT1'] !== NULL && $match['scoreT2'] !== NULL)
            {
              echo "<td><button type=\"button\" class=\"btn text-warning\" data-toggle=\"modal\" data-target=\"#m{$match['match_id']}\">Edit</button></td>";
            } 
            else 
            {
              echo "<td><button type=\"button\" class=\"btn text-primary\" data-toggle=\"modal\" data-target=\"#m{$match['match_id']}\">eind stand</button></td>";
            }
          }
          echo '</tr>';
          $matchCount++;
        }
      ?>
    </tbody>
  </table>
</div>

<?php
if($matchesCount > 0)
  {
    foreach($matches as $match)
    {
      echo "<div class=\"modal fade\" id=\"m{$match['match_id']}\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"{$match['match_id']}Label\" aria-hidden=\"true\">
              <div class=\"modal-dialog\" role=\"document\">
                <form class=\"modal-content form\" action=\"../includes/controller.php\" method='post'>
                  <input type='hidden' name='type' value='MatchEind'>
                  <input type='hidden' name='match_id' value='{$match['match_id']}'>
                  <div class=\"modal-header\">
                    <h5 class=\"modal-title\" id=\"{$match['match_id']}Label\">Eind Stand {$match['team1']} - {$match['team2']}</h5>
                  </div>

                  <div class=\"modal-body\">
                      <div class=\"form-group\">
                        <label for=\"scoreTeamOne\">{$match['team1']}</label>
                        <input type=\"number\" name=\"scoreTeamOne\" min='0' class=\"form-control mb-2 mr-sm-2\" id=\"scoreTeamOne\" placeholder=\"Score {$match['team1']}\" required>
                      </div>
                      <div class=\"form-group\">
                        <label for=\"scoreTeamTwo\">{$match['team2']}</label>
                        <input type=\"number\" name=\"scoreTeamTwo\" min='0' class=\"form-control mb-2 mr-sm-2\" id=\"scoreTeamTwo\" placeholder=\"Score {$match['team2']}\" required>
                      </div>
                  </div>
            
                  <div class=\"modal-footer\">
                    <button type=\"button\" name=\"cancle\" value=\"cancle\" class=\"btn text-danger\" data-dismiss=\"modal\">Annuleer</button>";
                    if($match['scoreT1'] !== NULL ||$match['scoreT2'] !== NULL)
                    {
                      echo "<button type=\"submit\" class=\"btn btn-success\" disabled>Opslaan</button>";
                    } 
                    else 
                    {
                      echo "<button type=\"submit\" class=\"btn btn-success\">Opslaan</button>";
                    }
                echo "</div>
              </form>
            </div>
          </div>";
  }
}

require 'dashboard_footer.php';
