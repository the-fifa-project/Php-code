<?php


//checks of er een id is meegegeven
if (!isset($_GET['id'])) {
  header("location: teams.php");
  exit;
}

// select the information of the teams (owner, goals, wins and more)
$teamID = $_GET['id'];
$sql = "SELECT * FROM `teams` 
        WHERE id = :id";
$prepare = $db->prepare($sql);
$prepare->execute([
  'id' => $teamID
]);
$team = $prepare->fetch(2);

if(isset($_SESSION['id']))
{
  $sql = "SELECT * FROM `user_team`
          WHERE team = :tId
          AND user = :uId";
  $prepare = $db->prepare($sql);
  $prepare->execute([
    'tId' => $teamID,
    'uId' => $_SESSION['id']
  ]);
  $player = $prepare->fetch(2);
}

$sql = "SELECT u.firstname as first, 
               u.middlename as middle, 
               u.lastname as last FROM `user_team` ut 
        INNER JOIN `users` u ON ut.user = u.id
        WHERE ut.team = :id";
$prepare = $db->prepare($sql);
$prepare->execute([
  'id' => $teamID
]);
$teamPlayers = $prepare->fetchAll(2);

$sql = "SELECT * FROM `users`";
$query = $db->query($sql);
$users = $query->fetchAll(2);

$sql = "SELECT * FROM `matches`";
$query = $db->query($sql);
$matchesCount = $query->rowCount();
?>

<main>
  <div class="container">
    <div class="row my-4 shadow-lg p-4 rounded">
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
      <div class="col-sm-12">
        <h2 class="display-4"><?= $team['name'] ?></h2>
      </div>
      <div class="col-md-9 col-lg-10">
        <table class="table table-hover table-sm text-center">
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

      <div class="col-md-3 col-lg-2 d-flex mb-auto">
        <div class="row mb-auto">


          <?php
          //checkt of someone is logged in
          if (!isset($_SESSION['id'])) {
            //              todo print text uit dat je moet ingelogd zijn om bij een team aan te sluiten en of iemand toevoegen!
          }

          // checkt of there is someone logged in and of he is a admin or owner
          // if he is an onwer/admin he can edit the team.
          if (isset($_SESSION['id']) && $team['owner'] === $_SESSION['id'] || isset($_SESSION['admin'])) {
            echo "
            <!-- alleen te zien als je owner van een team bent! -->
            <div class=\"col-md-12\">
              <button type=\"button\" class=\"w-100 btn btn-warning text-white btn-sm mx-1 my-1\" style=\"font-size: 1rem\" data-toggle=\"modal\" data-target=\"#Modal-edit\">Team Aanpassen</button>
            </div>";
          }

          //checks of someone logged in and of he is an admin
          // if he is an admin than the button to delete a team is printed out
          if (isset($_SESSION['admin']) && $_SESSION['admin'] !== null && $_SESSION['admin'] === $_SESSION['id']) {
            echo "<!-- alleen te zien als je als admin bent ingelogd -->
            <div class=\"col-md-12\">
              <button type=\"button\" class=\"w-100 btn btn-danger btn-sm mx-1 my-1\" style=\"font-size: 1rem\" data-toggle=\"modal\" data-target=\"#Modal-delete\">Team Verwijderen</button>
            </div>";
          }

          // checks of an user is already in an team
          // if he is already in an team he can invite someone 
          if (isset($_SESSION['id']) && $player['user'] === $_SESSION['id']) {
            echo "<div class=\"col-md-12\">
            <button type=\"button\" class=\"w-100 btn btn-primary btn-sm mx-1 my-1\" style=\"font-size: 1rem\" data-toggle=\"modal\" data-target=\"#Modal-invite\">Speler Toevoegen</button>
          </div>";
          }

          // here prints out a button to join the team if he isn't joined the team
          else if (isset($_SESSION['id'])) {
            echo "<!-- alleen te zien als je niet in de team zit en bent ingelogd -->
            <div class=\"col-md-12\">
              <button type=\"button\" class=\"w-100 btn btn-info text-white btn-sm mx-1 my-1\" style=\"font-size: 1rem\" data-toggle=\"modal\" data-target=\"#Modal-join\">Deelnemen</button>
            </div>";
          }
          ?>
        </div>

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

      <?php
      //modal for the delete button same
      // checkt of there is someone logged in and of he is a admin or owner
      if (isset($_SESSION['id']) && $team['owner'] === $_SESSION['id'] || isset($_SESSION['admin'])) {
        echo "<!-- modal for edit (need to be team owner) -->
              <div id=\"Modal-edit\" class=\"modal fade\" role=\"dialog\">
                <div class=\"modal-dialog\">
                  <!-- Modal content-->
                  <form class=\"modal-content form \" action=\"includes/controller.php\" method=\"post\">
                    <div class=\"modal-header\">
                      <!-- <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button> -->
                      <h4 class=\"modal-title\">Team Aanpassen</h4>
                    </div>
                    <div class=\"modal-body row\">
                      <input type='hidden' name='type' value='editteam'>
                      <input type='hidden' name='teamid' value='$teamID'>
                      
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
                  <form class=\"modal-content form p-1\" action=\"includes/controller.php\" method=\"post\">
            
                    <div class=\"modal-header\">
                      <h4 class=\"modal-title\">Team Verwijderen</h4>
                    </div>
            
                    <div class=\"modal-body row\">
                      <p>Weet u zeker dat u team <span class='text-danger'>{$team['name']}</span> wilt verwijderen? Type de naam van de team in het balkje om de team te verwijderen.</p>
                      <input type='hidden' name='type' value='deleteteam'>
                      <input type='hidden' name='teamid' value='$teamID'>
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
          <form class=\"modal-content form was-validated\" action=\"includes/controller.php\" method=\"post\">
          <input type=\"hidden\" name=\"type\" value=\"inviteMember\">
          <input type=\"hidden\" name=\"teamId\" value=\"$teamID\">
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
                  <form class=\"modal-content\" action=\"includes/controller.php\" method=\"post\">
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
      

    </div>
</main>

<?php
require 'footer.php';
