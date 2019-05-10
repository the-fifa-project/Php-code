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