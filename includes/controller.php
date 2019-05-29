<?php
/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 16-4-2019
 * Time: 12:53
 */

require 'config.php';
require 'Validator.php';

//controles of there is a post methode sended if not then send back!
if ($_SERVER['REQUEST_METHOD'] !== 'POST' )
{
    header("location: ../index.php");
    exit;
}

if ($_POST['type'] === 'register') {

    //set the data form the post methode to an variable
    $firstName = htmlentities(trim($_POST['firstname']));
    $middleName = htmlentities(trim($_POST['middlename']));
    $lastName = htmlentities(trim($_POST['lastname']));
    $email = htmlentities(trim($_POST['email']));
    $password = htmlentities(trim($_POST['password']));
    $passwordConfirm = htmlentities(trim($_POST['passwordconfirm']));
    $registers_date = date("Y-m-d H:i:s");

    //checks of an field is empty!
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($passwordConfirm)) {
        header("location: ../login.php?action=register&registermsg=1 of meer velden zijn leeg");
        exit;
    }

    //checks of the email is an real email
    if (!Validator::EmailValidate($email)) {
        header('location: ../login.php?action=register&registermsg=email is not valid');
        exit;
    }

    //checks of the variables $password and $passwordConfirm equels is to each other
    if (!Validator::PasswordConfirm($password, $passwordConfirm)) {
        //send back to register page wit h error code (password not match.
        header('location: ../login.php?action=register&registermsg=passwords don\'t match');
        exit;
    }

    //controles of the password lenght is not smaller than 7
    if (Validator::PasswordLength($password)) {
        $msg = "Password needs to be 7 chars long";
        header("location: ../login.php?action=register&registermsg=$msg");
        exit;
    }

    //checks of the password includes a uppercase character 
    if (!Validator::PasswordIncludesUpper($password)) {
        $msg = "Password must have 1 uppercase character";
        header("location: ../login.php?action=register&registermsg=$msg");
        exit;
    }
    //checks of the password includes a lowercase character 
    if (!Validator::PasswordIncludesLower($password)) {
        $msg = "Password must have a lowercase character";
        header("location: ../login.php?action=register&registermsg=$msg");
        exit;
    }

    //checks of there is a number in the password
    if (!Validator::PasswordIncludesNumber($password)) {
        $msg = "Password must have a number";
        header("location: ../login.php?action=register&registermsg$msg");
        exit;
    }

    //hash the password
    $passwordHash = Validator::PasswordHash($password);

    //checks of the email is already used in the database
    if (Validator::DatabaseQueryEmail($email, "users", $db)) {
        $msg = "Email already used";
        header("location: ../login.php?action=register&registermsg=$msg");
        exit;
    }

    //create the account thats registering
    $sql = "INSERT INTO users (`firstname`, `middlename`, `lastname`, `email`, `password`, `registers_date`)
                  VALUES (:firstname, :middlename, :lastname, :email, :password, :registers_date)";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':firstname' => $firstName,
        ':middlename' => $middleName,
        ':lastname' => $lastName,
        ':email' => $email,
        ':password' => $passwordHash,
        ':registers_date' => $registers_date
    ]);

    $msg = "account succesfull created";
    header("location: ../login.php");
    exit;
}

if ($_POST['type'] === 'login')
{
    // set the post in a var
    $email = htmlentities(trim($_POST['email']));
    $password = htmlentities(trim($_POST['password']));

    // query the database to control of the account do/don't exist
    if (Validator::DatabaseQueryEmail($email, "users", $db) === false)
    {
        $msg = "Account don't exist";
        header("location: ../login.php?loginmsg=$msg");
        exit;
    }

    // select everything form the user where the email the same is as in the databse
    $sql = "SELECT * FROM users WHERE email = :email";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':email' => $email
    ]);
    $user = $prepare->fetch(2);

    //controles of the password is the same as the hassed password in the database
    if (Validator::PasswordVerify($password, $user['password']) === false)
    {
        $msg = "Password or Email not match";
        header("location: ../login.php?loginmsg=$msg");
        exit;
    };

    //set the session id, username. (this is needed to login)
    $_SESSION['id'] = $user['id'];
    $_SESSION['username'] = "{$user['firstname']} {$user['middlename']} {$user['lastname']}";
    
    //checks of he has admin rights, if has admin rights then set the session admin
    if ($user['administrator'] !== null || $user['dev_admin'] !== null)
    {
        $_SESSION['admin'] = $user['id'];
    }

    //send to the homepage
    $msg = "Logged in";
    header("location: ../dashboard/dashboard_interconnector.php?navderection=2sH65u7^lj");
    exit;
}

if ($_POST['type'] === 'logout')
{
    //destroy the session (its means that he delete al data in the $_SESSION variables)
    session_destroy();

    //send back tot homepage
    $msg = "Logged Out";
    header("location: ../index.php?msg=$msg");
    exit;
}


if ($_POST['type'] === 'createteam')
{
    //set post methode to variables 
    $owner =    $_SESSION['id'];
    $teamname = htmlentities(trim($_POST['team-name']));
    $createdAt = date("Y-m-d H:i:s");

    //checks of the team name leght not longer is than 30 characters
    if(strlen($teamname) > 30)
    {
        $msg = "name is to long!";
        header("location: ../index.php?errmsg=$msg");
        exit;
    }

    //create the team 
    $sql = "INSERT INTO teams (`owner`, `name`, `created-at`) VALUES (:owner, :name, :created_at)";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':owner' => $owner,
        ':name' => $teamname,
        ':created_at' => $createdAt
    ]);

    //send to team page
    $msg = "team succesfull created!";
    header("location: ../teams.php?msg=$msg");
    exit;
}

if ($_POST['type'] === 'deleteteam' && isset($_SESSION['admin']))
{
    $teamId = htmlentities($_POST['teamid']);
    $confirm = htmlentities(trim(strtolower($_POST['team-name-confirm'])));
    
    //checks of the $confirm is not empty, if its empty than send back!
    if(empty($confirm))
    {
        $msg = "voer het naam in van de team die u wilt verwijderen!";
        header("location: ../team_detail.php?id=$teamId&errmsg=$msg");
        exit;
    }

    //select the team data form the database
    $sql = "SELECT * FROM `teams` WHERE `id` = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        'id' => $teamId
    ]);
    $teamToDelete = $prepare->fetch(2);

    //checks of the name in the database is equels to the given name, if its not equel than send back
    if(strtolower($teamToDelete['name']) !== strtolower($confirm))
    {
        $msg = "Team namen kommen niet overeen";
        header("location: ../team_detail.php?id=$teamId&errmsg=$msg");
        exit;
    }

    //delete row out of the database
    $sql = "DELETE FROM `teams` WHERE `teams`.`id` = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':id' => $teamId
    ]);

    //send back to index.php
    $msg = "Team succesvol verwijderd";
    header("location: ../index.php?msg=$msg");
    exit;

}

if($_POST['type'] === "editteam")
{
    $teamID  = htmlentities(trim($_POST['teamid']));
    $newName = htmlentities(trim($_POST['new-team-name']));
    
    if(strlen($newName) > 30)
    {
        //send back
        header("location: ../team_detail.php?id=$teamID&errmsg=de naam van de team kan niet groter zijn dan 30 karakters");
        exit;
    }

    if (!empty($_POST['competitionSwitch'])) 
    {
        $competitionSwitch = htmlentities(trim($_POST['competitionSwitch']));
        
        if(!empty($newName))
        {
            $sql = "UPDATE `teams` 
                    SET `name` =    :name,
                        `entered` = :entered
                    WHERE `id` = :id";
            $prepare = $db->prepare($sql);
            $prepare->execute([
                'name' => $newName,
                'entered' => $competitionSwitch,
                'id' => $teamID
            ]);

            //send back
            header("location: ../team_detail.php?id=$teamID&sucmsg=Aanpassingen opgeslagen");
            exit;
        }
        else
        {
            $sql = "UPDATE `teams` 
                    SET `entered` = :entered
                    WHERE `id` = :id";
            $prepare = $db->prepare($sql);
            $prepare->execute([
                'entered' => $competitionSwitch,
                'id' => $teamID
            ]);

            //send back
            header("location: ../team_detail.php?id=$teamID&sucmsg=jou team zit nu in de selectie van de competitie!");
            exit;
        }

        //send back
        header("location: ../team_detail.php?id=$teamID");
        exit;
    }
    else if (empty($_POST['competitionSwitch']))
    {
        if(!empty($newName))
        {
            $sql = "UPDATE `teams` 
                    SET `name` =    :name,
                        `entered` = :entered
                    WHERE `id` = :id";
            $prepare = $db->prepare($sql);
            $prepare->execute([
                'name' => $newName,
                'entered' => null,
                'id' => $teamID
            ]);

            //send back
            header("location: ../team_detail.php?id=$teamID&sucmsg=Aanpassingen opgeslagen, Jammer dat je niet meer deel neemt aan de competitie :(");
            exit;
        }
        else
        {
            $sql = "UPDATE `teams` 
                    SET `entered` = :entered
                    WHERE `id` = :id";
            $prepare = $db->prepare($sql);
            $prepare->execute([
                'entered' => null,
                'id' => $teamID
            ]);

            //send back
            header("location: ../team_detail.php?id=$teamID&sucmsg=U deelt niet meer mee aan een competitie");
            exit;
        }

        //send back
        header("location: ../team_detail.php?id=$teamID&errmsg=Er is iets fout gegaan");
        exit;

    }
    else
    {
        //send back
        header("location: ../team_detail.php?id=$teamID&errmsg=Er is iets fout gegaan");
        exit;
    }

    //send back
    header("location: ../team_detail.php?id=$teamID&errmsg=Er is iets fout gegaan");
    exit;
}

if($_POST['type'] === "generate")
{
    // set post methode into variables

    //select every team
    $sql = "SELECT * FROM `teams` WHERE `entered` = 0";
    $query = $db->query($sql);
    $teams = $query->fetchAll(2);
    $teamCount = $query->rowCount();    

    //select the settings
    $sql = "SELECT * FROM `settings`";
    $query = $db->query($sql);
    $settings = $query->fetch(2);
    
    //checks of there is more than one team thats selected 
    if ($teamCount < 2)
    {
        header("location: ../dashboard.php?errmsg=Er zijn niet genoeg teams om een competitie te starten!");
        exit;
    }

    //create 1 empty array for putting evrey team in it 
    $teamsArray = array();

    //set every team in the teamArray
    foreach ($teams as $team) {
        array_push($teamsArray, $team['id']);
    }
    
    //set the settings into variables
    $fields = $settings['fields'];
    $timeStart = '9:00:00'; //later kunnen instellen !
    $timeMatch = $settings['match_time'];
    $timeHalf = $settings['half_time']; 
    $timeBreak = $settings['break_time'];
    $timeTotal = $timeMatch + $timeBreak + $timeHalf;
    $splitTime = strtotime($timeStart);

    //set the counter for the forloop
    $arrLength = count($teamsArray);
    $count = 1;
    $fieldCounter = 1;

    //checks of there is more than 0 field
    if ($settings['fields'] == 0)
    {
        //sendback to dashboard
        header("location: ../dashboard.php?errmsg=Er zijn geen velden om tegen te spelen!");
        exit;
    }

    // delete the latest competition and reset the table
    $resetmatches = "TRUNCATE TABLE `matches`";
    $prepare = $db->prepare($resetmatches);
    $prepare->execute();

    // make the new competition
    for ($i = 0; $i < $arrLength; $i++) {
        for ($j = 0; $j < count($teamsArray); $j++) {
            if ($teamsArray[0] !== $teamsArray[$j]) {
                $sql = "INSERT INTO `matches`(`team1`, `team2`, `time`, `field`) 
                        VALUES (:team1, :team2, :time, :field)";
                $prepare = $db->prepare($sql);
                $prepare->execute([
                    'team1' => $teamsArray[0],
                    'team2' => $teamsArray[$j],
                    'time' => date('H:i:s', $splitTime),
                    'field' => $fieldCounter,
                ]);
                if ($fieldCounter < $fields)
                {
                    $fieldCounter++;
                }
                else
                {
                    $fieldCounter = 1;
                }
                $splitTime = strtotime("+$timeTotal minutes", strtotime($timeStart));
                $timeStart = date('H:i:s', $splitTime);
            }
        }
        array_shift($teamsArray);
    }

    //send back to the dashboard
        header("location: ../dashboard.php?sucmsg=Competitie Gegenereerd!");
        exit;
}

if ($_POST['type'] === "settingsEditor")
{
    // when you have submited the matchtime form
    if($_POST['setting'] === 'matchtime')
    {
        $matchTimeInMinutes = htmlentities(trim($_POST['matchTime']));
        
        //controles of the input is still a number
        if(!is_numeric($matchTimeInMinutes))
        {
            header("location: ../dashboard.php?errmsg=De tijd van een match moet in minuten aangegeven worden, en geen text!");
            exit;
        }
        
        //controles of the number is not smaller than 0 or bigger than 1 day in minutes
        if($matchTimeInMinutes < 0 || $matchTimeInMinutes > 1440)
        {
            header("location: ../dashboard.php?errmsg=Tijd van een wedstrijd kan niet kleiner zein dan 0 minuten en niet groter dan 1 dag (1440 minuten)!");
            exit;
        }

        $sql = "UPDATE `settings` 
                SET `match_time`= :match_time
                WHERE 1";
        $prepare = $db->prepare($sql);
        $prepare->execute([
            'match_time' => $matchTimeInMinutes
        ]);

        header("location: ../dashboard.php?sucmsg=Succesvol Wedstrijd tijd ingesteld");
        exit;
    }

    // when you have submited the breaktime form
    else if($_POST['setting'] ==='Break')
    {
        $breakTimeInMinutes = htmlentities(trim($_POST['breakTime']));
        
        if(!is_numeric($breakTimeInMinutes))
        {
            header("location: ../dashboard.php?errmsg=De tijd van een pauze moet in minuten aangegeven worden, en geen text!");
            exit;
        }
        
        //controles of the number is not smaller than 0
        if($breakTimeInMinutes < 0 || $breakTimeInMinutes > 1440)
        {
            header("location: ../dashboard.php?errmsg=Tijd van een pauze kan niet kleiner zein dan 0 minuten en niet groter dan 1 dag (1440 minuten)!");
            exit;
        }
        
        $sql = "UPDATE `settings` 
                SET `break_time`= :break_time
                WHERE 1";
        $prepare = $db->prepare($sql);
        $prepare->execute([
            'break_time' => $breakTimeInMinutes
        ]);

        header("location: ../dashboard.php?sucmsg=Succesvol pauze tijd ingesteld");
        exit;
    }
    
    // when you have submited the halftime form
    else if($_POST['setting'] === 'halftime')
    {
        $halfTimeInMinutes = htmlentities(trim($_POST['halftime']));
        
        if(!is_numeric($halfTimeInMinutes))
        {
            header("location: ../dashboard.php?errmsg=De tijd van een wedstrijd rust moet in minuten aangegeven worden, en geen text!");
            exit;
        }

        //controles of the number is not smaller than 0
        if($halfTimeInMinutes < 0 || $halfTimeInMinutes > 1440)
        {
            header("location: ../dashboard.php?errmsg=Tijd van een wedstrijd rust kan niet kleiner zein dan 0 minuten en niet groter dan 1 dag (1440 minuten)!");
            exit;
        }
        
        $sql = "UPDATE `settings` 
                SET `half_time`= :half_time
                WHERE 1";
        $prepare = $db->prepare($sql);
        $prepare->execute([
            'half_time' => $halfTimeInMinutes
        ]);

        header("location: ../dashboard.php?sucmsg=Succesvol wedstrijd rust tijd ingesteld");
        exit;
    }
    
    // when you have submited the fields form
    else if($_POST['setting'] === 'fields')
    {
        $fields = htmlentities(trim($_POST['fields']));
        
        //controles of the number is not smaller than 0
        if($fields < 0)
        {
            header("location: ../dashboard.php?errmsg=Je kan niet minder dan 0 velden hebben!");
            exit;
        }

        if(!is_numeric($fields))
        {
            header("location: ../dashboard.php?errmsg=De veldenmoet in Cijfers aangegeven worden, en geen text!");
            exit;
        }
        
        $sql = "UPDATE `settings` 
                SET `fields`= :fields
                WHERE 1";
        $prepare = $db->prepare($sql);
        $prepare->execute([
            'fields' => $fields
        ]);

        header("location: ../dashboard.php?sucmsg=Succesvol velden ingesteld");
        exit;
    }
    else
    {
        header("location: ../dashboard.php?errmsg=OEPS er ging iets fout");
        exit;
    }
    
    header("location: ../dashboard.php?errmsg=OEPS er ging iets fout");
    exit;
}

if ($_POST['type'] === "joinTeam")
{
    $user = htmlentities(trim($_SESSION['id']));
    $team = htmlentities(trim($_POST['teamId']));

    $sql = "INSERT INTO `user_team`(`user`, `team`) 
            VALUES (:user, :team)";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        'user' => $user,
        'team' => $team
    ]);

    header("location: ../team_detail.php?id=$team");
    exit;
}

if ($_POST['type'] === "MatchEind")
{
    $matchID = htmlentities(trim($_POST['matchId']));
    $scoreTeamOne = htmlentities(trim($_POST['scoreTeamOne']));
    $scoreTeamTwo = htmlentities(trim($_POST['scoreTeamTwo']));

    if(empty($_POST['scoreTeamOne']) || empty($_POST['scoreTeamTwo']))
    {
    
        header("location: ../dashboard.php?errmsg=er waren 1 of meer velden niet ingevuld. bij het invullen van de eindstand");
        exit;
    }

    if (!is_numeric($scoreTeamOne) || !is_numeric($scoreTeamTwo))
    {
    
        header("location: ../dashboard.php?errmsg=De ingevulde waarde is geen cijfer");
        exit;
    }

    $sql = "UPDATE `matches` 
            SET `score_team1` = :score1, `score_team2` = :score2
            WHERE id = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        'score1' => $scoreTeamOne,
        'score2' => $scoreTeamTwo,
        'id' => $matchID
    ]);

    
    header("location: ../dashboard.php?sucmsg=Eindstand Succesvol ingesteld");
    exit;

}

if ($_POST['type'] === "inviteMember")
{
    $player = htmlentities(trim($_POST['playerToInvite']));
    $teamID = htmlentities(trim($_POST['teamId']));

    if ($player === "" || empty($_POST['playerToInvite']))
    {
        header("location: ../team_detail.php?id=$teamID&errmsg=je hebt niemand geselecteerd om te inviten");
        exit;
    }

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
            WHERE user_team.team = :id AND user_team.user = :user";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        'id' => $teamID,
        'user' => $player
    ]);
    $players = $prepare->fetchAll(2);
    $playerCount = $prepare->rowCount();

    if ($playerCount > 0)
    {
        header("location: ../team_detail.php?id=$teamID&errmsg=gebruiker zit al in de team");
        exit;
    }

    $sql = "INSERT INTO `user_team` (`user`, `team`) 
            VALUES (:user, :team)";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        'user' => $player,
        'team' => $teamID
    ]);

    header("location: ../team_detail.php?id=$teamID&sucmsg=succesvol geinvited");
    exit;
}






//selecteert de gebruikers die in de team zitten
