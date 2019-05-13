<?php
/**
 * Created by PhpStorm.
 * User: GekkeGlenn
 * Date: 16-4-2019
 * Time: 12:01
 */

require 'header.php';
	
$sql = "SELECT `users`.`firstname` as owner, `teams`.`name` as name, `teams`.`goals` as goals, `teams`.`wins` as wins, `teams`.`loses` as loses, `users`.`id` as ownerid 
                FROM `teams` 
                LEFT JOIN `users` 
                ON `teams`.`owner` = `users`.id";
$query = $db->query($sql);
$teams = $query->fetchAll(2);

if (isset($_SESSION['id']))
{
    $sql = "SELECT `users`.`firstname` as owner, `teams`.`name` as name, `teams`.`goals` as goals, `teams`.`wins` as wins, `teams`.`loses` as loses, `users`.`id` as ownerid 
                FROM `teams` 
                INNER JOIN `users` 
                ON `teams`.`owner` = `users`.id 
                WHERE `teams`.owner = :userid";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':userid' => $_SESSION['id']
    ]);
    $yourTeams = $prepare->fetchAll(2);
}
else
{

}
 ?>

    <main>
        <div class="container">
            <div class="row">

                <div class="teams your-teams">
                    <h2>Your Teams</h2>
                    <?php
                    if (isset($_SESSION['id']))
                    {
                        foreach ($yourTeams as $yourTeam)
                        {
                            echo "<a href=\"team-detail.php?id=1\" class=\"team-card\">";
                            echo "<h3>{$yourTeam['name']}</h3>";
                            echo "<span class=\"stats\">";
                            echo "
                                 <p class=\"goals\">Goals: {$yourTeam['goals']}</p>
                                 <p class=\"wins\">Wins: {$yourTeam['wins']}</p>
                                 <p class=\"loses\">Loses: {$yourTeam['loses']}</p>";
                            echo "</span>
                             <span class=\"members\">";
                            echo "<p class=\"owner\">Owner: {$yourTeam['owner']}</p>
                                 <p class=\"players\">Players: 6</p>
                                </span>
                            </a>";
                        }
                        echo "
                    <form action=\"includes/controller.php\" method=\"post\">
                        <input type=\"hidden\" name=\"type\" value=\"createteam\">
                        <input type=\"text\" name=\"teamname\" placeholder='team naam'>
                        <input type=\"submit\" name=\"submit\"   value=\"Nieuw team aanmaken!\">
                    </form>";
                    }
                    else
                    {
                        echo "<p>Om teams te kunnen aanmaken en of zien moet je <a href='login.php'>ingelogd</a> zijn, Nog geen account <a href='register.php'>registreer</a> nu!</p>.";
                    }
                    ?>
<!--                        <a href="team-detail.php?id=1" class="team-card">-->
<!--                            <h3>Amokes</h3>-->
<!--                            <span class="stats">-->
<!--                             <p class="goals">Goals: 3</p>-->
<!--                             <p class="wins">Wins: 2</p>-->
<!--                             <p class="loses">Loses: 1</p>-->
<!--                         </span>-->
<!--                         <span class="members">-->
<!--                             <p class="owner">Owner: Glenn</p>-->
<!--                             <p class="players">Players: 6</p>-->
<!--                            </span>-->
<!--                    </a>-->

<!--                    als je hier op een div klikt moet er een popup komen!-->
                </div>
                <div id="teams">
                    <h2>All Teams</h2>
                    <div class="teams all-teams">

                    <?php
                            foreach ($teams as $team)
                            {
                                echo "<a href=\"team-detail.php?id=1\" class=\"team-card\">";
                                echo "<h3>{$team['name']}</h3>";
                                echo "<span class=\"stats\">";
                                echo "
                             <p class=\"goals\">Goals: {$team['goals']}</p>
                             <p class=\"wins\">Wins: {$team['wins']}</p>
                             <p class=\"loses\">Loses: {$team['loses']}</p>";
                                echo "</span>
                         <span class=\"members\">";
                                echo "<p class=\"owner\">Owner: {$team['owner']}</p>
                             <p class=\"players\">Players: 6</p>
                            </span>
                        </a>";
                            }
                    ?>

<!--                    <a href="team-detail.php?id=1" class="team-card">-->
<!--                        <h3>Amokes</h3>-->
<!--                        <span class="stats">-->
<!--                             <p class="goals">Goals: 3</p>-->
<!--                             <p class="wins">Wins: 2</p>-->
<!--                             <p class="loses">Loses: 1</p>-->
<!--                         </span>-->
<!--                        <span class="members">-->
<!--                             <p class="owner">Owner: Glenn</p>-->
<!--                             <p class="players">Players: 6</p>-->
<!--                            </span>-->
<!--                    </a>-->
<!---->
<!--                    <a href="team-detail.php?id=1" class="team-card">-->
<!--                        <h3>Amokes</h3>-->
<!--                        <span class="stats">-->
<!--                             <p class="goals">Goals: 3</p>-->
<!--                             <p class="wins">Wins: 2</p>-->
<!--                             <p class="loses">Loses: 1</p>-->
<!--                         </span>-->
<!--                        <span class="members">-->
<!--                             <p class="owner">Owner: Glenn</p>-->
<!--                             <p class="players">Players: 6</p>-->
<!--                            </span>-->
<!--                    </a>-->
<!---->
<!---->
<!--                    <a href="team-detail.php?id=1" class="team-card">-->
<!--                        <h3>Amokes</h3>-->
<!--                        <span class="stats">-->
<!--                             <p class="goals">Goals: 3</p>-->
<!--                             <p class="wins">Wins: 2</p>-->
<!--                             <p class="loses">Loses: 1</p>-->
<!--                         </span>-->
<!--                        <span class="members">-->
<!--                             <p class="owner">Owner: Glenn</p>-->
<!--                             <p class="players">Players: 6</p>-->
<!--                            </span>-->
<!--                    </a>-->
                </div>
            </div>
            </div>
        </div>
    </main>
<?php
require 'footer.php';




