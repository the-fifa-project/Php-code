<?php
require 'dashboard_header.php';
require 'dashboard_navigation.php';

if (!isset($_SESSION['id']) || !isset($_GET['id']))
{
  header('location: ./dashboard_interconnector.php');
  exit;
}

$team_id = $_GET['id'];

$sql = "SELECT ut.user as user,
               u.firstname as first,
               u.middlename as middle,
               u.lastname as last
        FROM `user_team` ut
        INNER JOIN `users` u ON ut.user = u.id
        INNER JOIN `teams` t ON ut.team = t.id
        WHERE ut.team = :team";
$prepare = $db->prepare($sql);
$prepare->execute([
  'team' => $team_id
]);
$players = $prepare->fetchAll(2);

$sql = "SELECT * from `teams` t
        WHERE t.id = :team";
$prepare = $db->prepare($sql);
$prepare->execute([
  'team' => $team_id
]);
$team = $prepare->fetch(2);

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
  
?>
  
  <div class="col-12 p-0">
    <div class="bg-light rounded m-1 border shadow-sm d-flex justify-content-between">
      <h2 class="h4 p-1 ml-2">Team: <?=$team['name']?></h2>
      <p class="h4 p-1 mr-5">Points: <?=$team['points']?></p>
    </div>
  </div>

  <div class="col-md-3 ml-3 p-0">
    <table class="border w-100 table-sm table-borderless table-hover">
      <thead>
        <tr>
          <th scope="col">Spelers</th>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach ($players as $player) 
          {
            echo '<tr>';
            echo "<td class='rounded px-2'>{$player['first']} {$player['middle']} {$player['last']}</td>";
            echo '</tr>';
          }
        ?>
      </tbody>
    </table>
  </div>
  <div class="col-md-3 ml-1 p-0 border">
  <?php
          // checkt of there is someone logged in and of he is a admin or owner
          // if he is an onwer/admin he can edit the team.
          if (isset($_SESSION['id']) && $team['owner'] === $_SESSION['id'] || isset($_SESSION['admin'])) {
            echo "
            <!-- alleen te zien als je owner van een team bent! -->
            <div class=\"col-md-12\">
              <button type=\"button\" class=\"w-100 btn btn-warning text-white btn-sm mx-0 my-1\" style=\"font-size: 1rem\" data-toggle=\"modal\" data-target=\"#Modal-edit\">Team Aanpassen</button>
            </div>";
          }

          //checks of someone logged in and of he is an admin
          // if he is an admin than the button to delete a team is printed out
          if (isset($_SESSION['admin']) && $_SESSION['admin'] !== null && $_SESSION['admin'] === $_SESSION['id']) {
            echo "<!-- alleen te zien als je als admin bent ingelogd -->
            <div class=\"col-md-12\">
              <button type=\"button\" class=\"w-100 btn btn-danger btn-sm mx-0 my-1\" style=\"font-size: 1rem\" data-toggle=\"modal\" data-target=\"#Modal-delete\">Team Verwijderen</button>
            </div>";
          }

          // checks of an user is already in an team
          // if he is already in an team he can invite someone 
          if (isset($_SESSION['id']) && $players[0]['user'] === $_SESSION['id']) {
            echo "<div class=\"col-md-12\">
            <button type=\"button\" class=\"w-100 btn btn-primary btn-sm mx-0 my-1\" style=\"font-size: 1rem\" data-toggle=\"modal\" data-target=\"#Modal-invite\">Speler Toevoegen</button>
          </div>";
          }

          // here prints out a button to join the team if he isn't joined the team
          else if (isset($_SESSION['id'])) {
            echo "<!-- alleen te zien als je niet in de team zit en bent ingelogd -->
            <div class=\"col-md-12\">
              <button type=\"button\" class=\"w-100 btn btn-info text-white btn-sm mx-0 my-1\" style=\"font-size: 1rem\" data-toggle=\"modal\" data-target=\"#Modal-join\">Deelnemen</button>
            </div>";
          }
          ?> 
  </div>
</div>

<?php
      //modal for the delete button same
      // checkt of there is someone logged in and of he is a admin or owner
      if (isset($_SESSION['id']) && $team['owner'] === $_SESSION['id'] || isset($_SESSION['admin'])) {
        echo "<!-- modal for edit (need to be team owner) -->
              <div id=\"Modal-edit\" class=\"modal fade\" role=\"dialog\">
                <div class=\"modal-dialog\">
                  <!-- Modal content-->
                  <form class=\"modal-content form \" action=\"../includes/controller.php\" method=\"post\">
                    <div class=\"modal-header\">
                      <!-- <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button> -->
                      <h4 class=\"modal-title\">Team Aanpassen</h4>
                    </div>
                    <div class=\"modal-body row\">
                      <input type='hidden' name='type' value='editteam'>
                      <input type='hidden' name='teamid' value='$team_id'>
                      
                      <div class=\"form-group col-sm-12 mb-0\">
						            <p class=\"m-0 mb-2\">Wil je jou team aanpassen? hier kan je jou team een andere naam geven</p>
                      </div>
                      <input type=\"text\" name=\"new-team-name\" placeholder='bijv: snollebolekers' class=\"col form-control mx-2 shadow-sm\" id=\"team-name\">
                    </div>";

        if ($team['entered'] !== null) {
          echo "<div class=\"form-group col-sm-12 mx-3 custom-control custom-switch\">
                              <input type=\"checkbox\" class=\"custom-control-input\" name='competitionSwitch' id=\"competitionSwitch\" checked>
                              <label class=\"custom-control-label\" for=\"competitionSwitch\">Deel nemen aan competitie</label>
                            </div>";
        } else {
          echo "<div class=\"form-group col-sm-12 mx-3 custom-control custom-switch\">
                              <input type=\"checkbox\" class=\"custom-control-input\" name='competitionSwitch' id=\"competitionSwitch\">
                              <label class=\"custom-control-label\" for=\"competitionSwitch\">Deel nemen aan competitie</label>
                            </div>";
        }
        echo "<div class=\"modal-footer\">
                            <button type=\"button\" class=\"btn btn-default text-danger\" data-dismiss=\"modal\">Annulleer</button>
                            <button type=\"submit\" class=\"col-4 btn btn-warning text-white\">Aanpassen</button>
                          </div>
                        </form>
                      </div>
                    </div>";
      }

      if (isset($_SESSION['admin']) && $_SESSION['admin'] !== null && $_SESSION['admin'] === $_SESSION['id']) {
        echo "<div id=\"Modal-delete\" class=\"modal fade\" role=\"dialog\">
                <div class=\"modal-dialog\">
                  
                  <!-- Modal content-->
                  <form class=\"modal-content form p-1\" action=\"../includes/controller.php\" method=\"post\">
            
                    <div class=\"modal-header\">
                      <h4 class=\"modal-title\">Team Verwijderen</h4>
                    </div>
            
                    <div class=\"modal-body row\">
                      <p>Weet u zeker dat u team <span class='text-danger'>{$team['name']}</span> wilt verwijderen? Type de naam van de team in het balkje om de team te verwijderen.</p>
                      <input type='hidden' name='type' value='deleteteam'>
                      <input type='hidden' name='teamid' value='$team_id'>
                      <input type=\"text\" name=\"team-name-confirm\" placeholder='{$team['name']}' class=\"col-12 mr-1 form-control shadow-sm text-danger\" id=\"email-login\">
                    </div>
            
                    <div class=\"modal-footer\">
                      <button type=\"button\" class=\"btn btn-default text-danger\" data-dismiss=\"modal\">Annuleer</button>
                      <button type=\"submit\" class=\"btn btn-danger\">Verwijderen</button>
                    </div>
                  </form>
                </div>
              </div>";
      }

      if (isset($_SESSION['id']) && $player['user'] === $_SESSION['id']) 
      {
        echo "<div id=\"Modal-invite\" class=\"modal fade\" role=\"dialog\">
        <div class=\"modal-dialog\">
          <form class=\"modal-content form was-validated\" action=\"../includes/controller.php\" method=\"post\">
          <input type=\"hidden\" name=\"type\" value=\"inviteMember\">
          <input type=\"hidden\" name=\"teamId\" value=\"$team_id\">
          <div class=\"modal-header was-validated\" action=\"includes.controller.php\" method=\"post\">
              <h4 class=\"modal-title\">Speler Inviten</h4>
            </div>

            <div class=\"modal-body\">
              <p>Hier kan je een gebruiker inviten</p>
              <div class=\"form-group\">
                <select name=\"playerToInvite\" class=\"custom-select\" required>
                  <option value=\"\" selected>Selecteer een gebruiker</option>";
                  foreach ($users as $user) 
                  {
                    echo "<option value=\"{$user['id']}\">{$user['firstname']} {$user['middlename']} {$user['lastname']} </option>";
                  }
                  echo "</select>
                <div class=\"invalid-feedback\">Geen gebruiker geselecteerd</div>
              </div>
            </div>
            <div class=\"modal-footer\">
              <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Annuleer</button>
              <button type=\"submit\" class=\"btn btn-success\">Toevoegen</button>
            </div>
          </form>
        </div>
      </div>";
      } 
      else if (isset($_SESSION['id'])) 
      {
        echo "<div id=\"Modal-join\" class=\"modal fade\" role=\"dialog\">
                <div class=\"modal-dialog\">
                  <form class=\"modal-content\" action=\"../includes/controller.php\" method=\"post\">
                    <input type='hidden' name='type' value='joinTeam'>
                    <div class=\"modal-header\">
                      <h4 class=\"modal-title\">Speler worden</h4>
                    </div>

                    <div class=\"modal-body\">
                      <p>Weet je zeker dat je deze team wilt joinen eenmaal gejoint kan je niet meer uit de team</p>
                      <input type=\"hidden\" name=\"type\" value=\"joinTeam\">
                      <input type=\"hidden\" name=\"teamId\" value=\"$teamID\">
                    </div>

                    <div class=\"modal-footer\">
                      <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">annuleer</button>
                      <button type=\"submit\" class=\"btn btn-info\">Deelnemen</button>
                    </div>
                  </form>
                </div>
              </div>";
      }
      ?>




<?php
require 'dashboard_footer.php';
