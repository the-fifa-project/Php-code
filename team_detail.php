<?php
require 'header.php';

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

//selecteert de gebruikers die in de team zitten
$sql = "SELECT `user_team`.`id` as user_team,
               `user_team`.`user` as user_id, 
               `user_team`.`team` as team_id, 
               `users`.`firstname` as fname, 
               `users`.`middlename` as Mname, 
               `users`.`lastname` as lname, 
               `teams`.`name` as Tname, 
               `teams`.`owner` as Towner, 
               `teams`.`goals` as goals, 
               `teams`.`wins` as wins, 
               `teams`.`loses` as Loses 
        FROM `user_team`
        INNER JOIN `users` ON user_team.user = users.id
        INNER JOIN `teams` ON user_team.team = teams.id
        WHERE user_team.team = :id";
$prepare = $db->prepare($sql);
$prepare->execute([
  'id' => $teamID
]);
$player = $prepare->fetch(2);
?>

<main>
  <div class="container">
    <div class="row my-4 shadow-lg p-4 rounded">
      <div class="col-sm-12">
        <h2 class="display-4"><?=$team['name']?></h2>
      </div>
      <div class="col-md-9 col-lg-10">
        <table class="table table-hover table-sm text-center">
          <caption>Spelers in het team</caption>
          <thead class="thead-light">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Rank</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="col">1</th>
              <th scope="col">Henk de potvis</th>
              <th scope="col">ceeper</th>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="col-md-3 col-lg-2 d-flex mb-auto">
        <div class="row mb-auto">


          <?php
          //checkt of someone is logged in
          if (!isset($_SESSION['id']))
          {
//              todo print text uit dat je moet ingelogd zijn om bij een team aan te sluiten en of iemand toevoegen!
          }

          // checkt of there is someone logged in and of he is a admin or owner
          // if he is an onwer/admin he can edit the team.
          if (isset($_SESSION['id']) && $team['owner'] === $_SESSION['id']|| isset($_SESSION['admin']))
          {
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
          if (isset($_SESSION['id']) && $player['user_id'] === $_SESSION['id'])
          {
            echo "<div class=\"col-md-12\">
            <button type=\"button\" class=\"w-100 btn btn-primary btn-sm mx-1 my-1\" style=\"font-size: 1rem\" data-toggle=\"modal\" data-target=\"#Modal-invite\">Speler Toevoegen</button>
          </div>";
          }

          // here prints out a button to join the team if he isn't joined the team
          else if(isset($_SESSION['id']))
          {
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
      if (isset($_SESSION['id']) && $team['owner'] === $_SESSION['id'] || isset($_SESSION['admin']))
      {
        echo "<!-- modal for edit (need to be team owner) -->
              <div id=\"Modal-edit\" class=\"modal fade\" role=\"dialog\">
                <div class=\"modal-dialog\">
                  <!-- Modal content-->
                  <form class=\"modal-content form p-1\" action=\"includes/controller.php\" method=\"post\">
                    <div class=\"modal-header\">
                      <!-- <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button> -->
                      <h4 class=\"modal-title\">Team Aanpassen</h4>
                    </div>
                    <div class=\"modal-body row\">
                      <input type='hidden' name='type' value='editteam'>
                      
                      <div class=\"form-group col-sm-12 mb-0\">
						            <p class=\"m-0\">Wil je jou team aanpassen? hier kan je jou team een andere naam geven</p>
                      </div>";

                      //checks of there is an error message seted
                      if (isset($_GET['editmsg']))
                      {
                        echo "<div class=\"form-group col-sm-12 shadow-sm bg-danger text-white px-2 py-1 rounded my-2\">
                                <p class=\"m-0\">ingevoerde teamnaam komt niet overeen!</p>
                              </div>";
                      }
                      echo "<input type=\"text\" name=\"new-team-name\" placeholder='bijv: snollebolekers' class=\"col mr-1 form-control shadow-sm\" id=\"team-name\">
                          </div>
                          
                          <div class=\"modal-footer\">
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
                      <input type='hidden' name='teamid' value='{$team['id']}'>";
                      //checks of there is an error message seted
                      if (isset($_GET['delmsg'])) 
                      {
					              echo  "<div class=\"form-group shadow-sm bg-danger text-white px-2 py-1 rounded my-2 col-sm-12\">
						                    <p class=\"m-0\">{$_GET['delmsg']}</p>
							                </div>";
				              }
                      echo "<input type=\"text\" name=\"team-name-confirm\" placeholder='{$team['name']}' class=\"col-12 mr-1 form-control shadow-sm text-danger\" id=\"email-login\">
                          </div>
            
                          <div class=\"modal-footer\">
                            <button type=\"button\" class=\"btn btn-default text-danger\" data-dismiss=\"modal\">Annuleer</button>
                            <button type=\"submit\" class=\"btn btn-danger\">Verwijderen</button>
                          </div>
                        </form>
                      </div>
                    </div>";
      }

      if (isset($_SESSION['id']) && $player['user_id'] === $_SESSION['id'])
      {

      }
      else if(isset($_SESSION['id']))
      {

      }
      ?>
      <!-- team join form -->
      <div id="Modal-join" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <form class="modal-content" action="includes/controller.php" method="post">
            <div class="modal-header">
              <h4 class="modal-title">Speler worden</h4>
            </div>

            <div class="modal-body">
              <p>Weet je zeker dat je deze team wilt joinen eenmaal gejoint kan je niet meer uit de team</p>
              <input type="hidden" name="type" value="joinTeam">
              <input type="hidden" name="teamId" value="<?=$team['id']?>">
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">annuleer</button>
              <button type="submit" class="btn btn-info">Deelnemen</button>
            </div>
          </form>
        </div>
      </div>

      <!-- speler inviten -->
      <div id="Modal-invite" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <form class="modal-content">
            <div class="modal-header was-validated" action="includes.controller.php" method="post">
              <h4 class="modal-title">Speler Inviten</h4>
            </div>
            <div class="modal-body">
              <!-- form -->
              
                <div class="form-group">
                  <select class="custom-select" required>
                    <option value="" selected>Selecteer een gebruiker</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                  </select>
                  <div class="invalid-feedback">Example invalid custom select feedback</div>
                </div>
                <input type="submit" class="btn btn-success" value="Toevoegen" name="submit">
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </form>
        </div>
      </div>

    </div>
</main>

<?php
require 'footer.php';
