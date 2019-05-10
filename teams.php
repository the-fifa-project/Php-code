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


    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/normalize.css">
    <main>
        <h2>All Teams</h2>
		<?php
			foreach ($teams as $team) {
				echo "<a href=\"teams-detail.php?id={$team['id']}\">{$team['name']}</a>";
			}

		?>

        <h2>Your Team(s)</h2>
        <?php
            foreach ($teams as $team)
            {
                if ($team['owner'] === $_SESSION['id'])
                {
                    echo "<a href=\"team-detail.php?id={$team['id']}\">{$team['name']}</a>";
                }
            }
        ?>

    </main>
<div class="team-creator">
	<form action="includes/controller.php" method="post">
		<input type="hidden" name="type" value="createteam">
		<input type="text" name="teamname" required>
		<input type="submit" name="submit" value="team aanmaken">
	</form>
</div>





<?php

require 'footer.php';