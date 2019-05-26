<?php
/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 9-5-2019
 * Time: 15:45
 */

require 'header.php';

if (!isset($_SESSION['admin']))
{
    header('location: index.php');
    exit;
}
$sql = "SELECT * FROM `settings`";
$query = $db->query($sql);
$settings = $query->fetch(2);

$sql = "SELECT m.id as matchid, 
               t1.name as team1, 
               t2.name as team2, 
               m.time as time, 
               m.field as field,
               m.score_team1 as scoreT1,
               m.score_team2 as scoreT2
        FROM `matches` m
        INNER JOIN `teams` t1 ON `m`.`team1` = `t1`.`id`
        INNER JOIN `teams` t2 ON `m`.`team2` = `t2`.`id`";
$query = $db->query($sql);
$matches = $query->fetchAll(2);
$matchesCount = $query->rowCount();
$matchNumber = 1;

?>

<!-- search for nabvar for dashboard bootstrap 4 -->

<main>
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <?php
                if(isset($_GET['errmsg']))
                {
                    echo "<div class='col-12  mt-2'><p class='h3 alert-danger rounded py-1 px-2'>{$_GET['errmsg']}</p></div>";
                }
                else if(isset($_GET['sucmsg']))
                {
                    echo "<div class='col-12  mt-2'><p class='h3 alert-success rounded py-1 px-2'>{$_GET['sucmsg']}</p></div>";
                }
            ?>
            <div class="col-md-3 col-lg-2  p-0 m-1">

                <div class="shadow-sm border  p-1 w-100">

                    <h2 class="h4 border-bottom pb-1">Settings</h2>
                    <div class="time">
                        <button class="btn btn-info w-100 my-1" data-toggle="modal" data-target="#time-duration">Tijdsduur aanpassen</button>
                        <button class="btn btn-info w-100 my-1" data-toggle="modal" data-target="#time-break">Pauze tijd aanpassen</button>
                        <button class="btn btn-info w-100 my-1" data-toggle="modal" data-target="#time-half">match rust aanpassen</button>
                        <button class="btn btn-info w-100 my-1" data-toggle="modal" data-target="#fields">Velden aanpassen</button>
                        <button class="btn btn-warning text-white w-100 my-1" data-toggle="modal" data-target="#match-generate">Match Genereren</button>
                        <button class="btn btn-danger text-white w-100 my-1" data-toggle="modal" data-target="#match-delete">Match verwijderen</button>
                    </div>
                </div>

            </div>
            <?php
            if($matchesCount > 0)
            {
                echo "<div class=\"col m-1 p-0\">
                        <div class=\"shadow-sm border  p-1 w-100\">
                            <h2 class=\"h4 border-bottom pb-1\">Matches</h2>
                            <!-- make a competition setting -->
                            <table class=\"table table-sm table-borderless table-hover text-center\">
                                <thead class=\"thead-light\">
                                    <tr>
                                        <th scope=\"row\">#</th>
                                        <th>Team 1</th>
                                        <th>Team 2</th>
                                        <th>Tijd</th>
                                        <th>Veld</th>
                                        <th>Opties</th>
                                    </tr>
                                </thead>
                                <tbody>";
                foreach($matches as $match)
                {
                    echo "<tr>
                        <th scope='row'>Match $matchNumber</th>
                        <td>{$match['team1']}</td>
                        <td>{$match['team2']}</td>
                        <td>{$match['time']}</td>
                        <td>{$match['field']}</td>";
                    if($match['scoreT1'] !== NULL ||$match['scoreT2'] !== NULL || $match['scoreT1'] !== NULL && $match['scoreT2'] !== NULL)
                    {
                        echo "<td><button type=\"button\" class=\"btn text-danger\" data-toggle=\"modal\" data-target=\"#m{$match['matchid']}\" disabled>eind stand</button></td>";

                    } 
                    else 
                    {
                        echo "<td><button type=\"button\" class=\"btn text-primary\" data-toggle=\"modal\" data-target=\"#m{$match['matchid']}\">eind stand</button></td>";
                    }
                   $matchNumber++;
                }
                echo "</tbody>
                      </table>
                      </div>
                      </div>";
            }
            ?>
                    
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="time-duration" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="includes/controller.php" method="post" class="modal-content form">
            <input type="hidden" name="type" value="settingsEditor">
            <input type="hidden" name="setting" value="matchtime">
                <div class="modal-header">
                    <h5 class="modal-title" id="timeMatchLabel">Speel tijd aanpassen</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <p>Hier kan je de tijd van een wedstrijd instellen <strong>Let op</strong> de tijd moet in <strong>minuten</strong> gegeven worden</p>
                    </div>
                    <div class="formgroup">
                        <input type="number" value="<?=$settings['match_time']?>" name="matchTime" id="matchTime" min="0">
                        <label for="matchTime">Minuten</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" name="cancle" value="cancle" class="btn text-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="time-break" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="includes/controller.php" method="post" class="modal-content form">
            <input type="hidden" name="type" value="settingsEditor">
            <input type="hidden" name="setting" value="Break">
                <div class="modal-header">
                    <h5 class="modal-title" id="timeMatchLabel">Pauze tusse wedstrijden</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <p>Hier kan je de pauze tijd tussen wedstrijden instellen. <strong>Let op</strong> de tijd moet in <strong>minuten</strong> gegeven worden</p>
                    </div>
                    <div class="formgroup">
                        <input type="number" value="<?=$settings['break_time']?>" name="breakTime" id="BreakTime" min="0">
                        <label for="breakTime">Minuten</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" name="cancle" value="cancle" class="btn text-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="time-half" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="includes/controller.php" method="post" class="modal-content form">
            <input type="hidden" name="type" value="settingsEditor">
            <input type="hidden" name="setting" value="halftime">
                <div class="modal-header">
                    <h5 class="modal-title" id="timeMatchLabel">Rust instellen</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <p>Hier kan je de tijd van de rust instellen tussen de wedstrijden (tussen de 1ste en 2de helften). <strong>Let op</strong> de tijd moet in <strong>minuten</strong> gegeven worden</p>
                    </div>
                    <div class="formgroup">
                        <input type="number" value="<?=$settings['half_time']?>" name="halftime" id="halftime" min="0">
                        <label for="halftime">Minuten</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" name="cancle" value="cancle" class="btn text-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="fields" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="includes/controller.php" method="post" class="modal-content form">
            <input type="hidden" name="type" value="settingsEditor">
            <input type="hidden" name="setting" value="fields">
                <div class="modal-header">
                    <h5 class="modal-title" id="timeMatchLabel">Velden instellen</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <p>Hoeveel velden worden er gebruikt??</p>
                    </div>

                    <div class="formgroup">
                        <input type="number" name="fields" value="<?=$settings['fields']?>" id="fields" min="0">
                        <label for="fields">Velden</label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" name="cancle" value="cancle" class="btn text-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="match-generate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="includes/controller.php" method="post" class="modal-content form">
                <input type="hidden" name="type" value="generate">
                <div class="modal-header">
                    <h5 class="modal-title" id="timeMatchLabel">Compititie generator</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <p>Weet u zeker dat u een compititie wilt laten genereren? als u dit doet wordt de vorige compititie <span class="text-danger">verwijdert!</span></p>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" name="cancle" value="cancle" class="btn text-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Genereren!</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="match-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="includes/controller.php" method="post" class="modal-content form">
                <div class="modal-header">
                    <h5 class="modal-title" id="timeMatchLabel">Compititie verwijderen</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <p>Weet u zeker dat u de compititie wilt <span class="text-danger">verwijderen?</span>, <strong class="text-danger">DEZE FUNCTIE WERKT NOG NIET</strong></p>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" name="cancle" value="cancle" class="btn text-danger" data-dismiss="modal">Annuleer</button>
                    <button type="submit" class="btn btn-danger">Ja dat wil ik</button>
                </div>
            </form>
        </div>
    </div>
<?php
    if($matchesCount > 0)
    {
        foreach($matches as $match)
        {
            echo "<div class=\"modal fade\" id=\"m{$match['matchid']}\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"{$match['matchid']}Label\" aria-hidden=\"true\">
            <div class=\"modal-dialog\" role=\"document\">
              <form class=\"modal-content form\" action=\"includes/controller.php\" method='post'>
                <input type='hidden' name='type' value='MatchEind'>
                <input type='hidden' name='matchId' value='{$match['matchid']}'>
                <div class=\"modal-header\">
                  <h5 class=\"modal-title\" id=\"{$match['matchid']}Label\">Eind Stand {$match['team1']} - {$match['team2']}</h5>
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
?>
</main>

<!-- edit modals ! -->
<!-- Modal -->


<?php
require 'footer.php';
?>