<?php
/**
 * Created by PhpStorm.
 * User: GekkeGlenn
 * Date: 16-4-2019
 * Time: 12:01
 */

require 'header.php';
	
$sql = "SELECT * FROM teams";
$query = $db->query($sql);
$teams = $query->fetchAll(2);
 ?>
    <main>
        <div class="container">
            <div class="row">
                <div class="your-teams">
                    <h2>Your Teams</h2>
<!--                    for each-->
                    <a href="team-detail.php?id=1" class="team-card">
teste
                    </a>
                    <?php
                    if (isset($_SESSION['id']))
                    {
                        foreach ($teams as $team)
                        {
                            if (isset($_SESSION['id']))
                            {
                                echo "<a href=\"team-detail.php?id={$team['id']}\">{$team['name']}</a>";
                            }
                        }
                        echo "<div class=\"team-creator\">

    <div class="Teams">

        <div class="Teams-Info">

            <div class="Your-Teams">
                <h2>Your Team(s)</h2>
            </div>

            <div class="All-Teams">
                <h2>All Teams</h2>
            </div>

        </div>

        <div class="Your-Team-Names">
            <div class="Your-Team-Name">
                <h3>TEAM NAME</h3>

                <div class="Scores">
                    <p>Goals: 3</p>
                    <p>Wins: 2</p>
                    <p>Loses: 1</p>
                </div>

                <div class="Info">
                    <p>Owner: Username</p>
                    <p>Players: 6</p>
                </div>

            </div>
        </div>

        <div class="All-Team-Names">
            <div class="Team-Name">
                <h3>TEAM NAME</h3>
                <p>Goals: 3</p>
                <p>Wins: 2</p>
                <p>Loses: 1</p>
                <p>Owner: Username</p>
                <p>Players: 6</p>
            </div>
        </div>

    </div>

		<?php
			foreach ($teams as $team) {
				echo "<a href=\"team-detail.php?id={$team['id']}\">{$team['name']}</a>";
			}
		?>

        <?php
        if (isset($_SESSION['id']))
        {
            foreach ($teams as $team)
            {
                if (isset($_SESSION['id']))
                {
                    echo "<a href=\"team-detail.php?id={$team['id']}\">{$team['name']}</a>";
                    echo "<div class=\"team-creator\">
	                            <form action=\"includes/controller.php\" method=\"post\">
		                        <input type=\"hidden\" name=\"type\" value=\"createteam\">
		                        <input type=\"text\" name=\"teamname\" required>
		                        <input type=\"submit\" name=\"submit\" value=\"team aanmaken\">
	                            </form>";
                    }
                    else
                    {
                        echo "<p>om jou teams te kunnen zien moet je <a href='login.php'>Inloggen</a>, of om een team aan te maken</p>";
                    }
                    ?>
                </div>
                <div class="all-teams">
                    <h2>All Teams</h2>
                    <?php
                    foreach ($teams as $team) {
                        echo "<a href=\"team-detail.php?id={$team['id']}\">{$team['name']}</a>";
                    }
                    ?>            .
                </div>
            </div>
    </main>

<?php

require 'footer.php';