<?php
/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 16-4-2019
 * Time: 12:53
 */

require 'config.php';
require 'Validator.php';
require 'Calculator.php';

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

    //checks of the team name lenght not longer is than 30 characters
    if(strlen($teamname) > 30)
    {
        $msg = "De naam van de team is te lang (een team naam mag maar 30 karakters hebben!";
        header("location: ../dashboard/dashboard_page_owned_teams.php?err=$msg");
        exit;
    }

    //create the team 
    $sql = "INSERT INTO teams (`owner`, `name`, `created-at`, `edit-at`) VALUES (:owner, :name, :created_at, :edit)";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        'owner' => $owner,
        'name' => $teamname,
        'created_at' => $createdAt,
        'edit' => "0000-00-00 00:00:00"
    ]);

    //send to team page
    $msg = "team succesfull created!";
    header("location: ../dashboard/dashboard_page_owned_teams.php?succ=$msg");
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
        header("location: ../dashboard/dashboard_page_team_details.php?id=$teamId&err=$msg");
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
        header("location: ../dashboard/dashboard_page_team_details.php?id=$teamId&err=$msg");
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
    header("location: ../dashboard/dashboard_page_teams.php?succ=$msg"); //TODO naar alleteams sturen
    exit;

}

if($_POST['type'] === "editteam")
{
    $teamID  = htmlentities(trim($_POST['teamid']));
    $newName = htmlentities(trim($_POST['new-team-name']));
    $editAt =  date("Y-m-d H:i:s");
    
    if(strlen($newName) > 30)
    {
        //send back
        header("location: ../dashboard/dashboard_page_team_details.php?id=$teamID&err=de naam van de team kan niet groter zijn dan 30 karakters");
        exit;
    }

    if (!empty($_POST['competitionSwitch'])) 
    {
        $competitionSwitch = htmlentities(trim($_POST['competitionSwitch']));
        $playerCount = Validator::PlayerRowCounter($teamID, $db);
        
        if ($competitionSwitch == "on") 
        {
            $competitionSwitch = 1;
        }

        if ($playerCount < 2)
        {
            header("location: ../dashboard/dashboard_page_team_details.php?id=$teamID&err=Als je mee wilt doen aan een competitie moet je minimaal 2 spelers in uw team hebben");
            exit;
        }
        
        if(!empty($newName))
        {
            $sql = "UPDATE `teams` 
                    SET `name` =    :name,
                        `entered` = :entered,
                        `edit-at`= :edit
                    WHERE `id` = :id";
            $prepare = $db->prepare($sql);
            $prepare->execute([
                'name' => $newName,
                'entered' => $competitionSwitch,
                'edit' => $editAt,
                'id' => $teamID
            ]);

            //send back
            header("location: ../dashboard/dashboard_page_team_details.php?id=$teamID&succ=Aanpassingen opgeslagen");
            exit;
        }
        else
        {
            $sql = "UPDATE `teams` 
                    SET `entered` = :entered,
                        `edit-at`= :edit
                    WHERE `id` = :id";
            $prepare = $db->prepare($sql);
            $prepare->execute([
                'entered' => $competitionSwitch,
                'edit' => $editAt,
                'id' => $teamID
            ]);

            //send back
            header("location: ../dashboard/dashboard_page_team_details.php?id=$teamID&succ=Aanpassingen opgeslagen");
            exit;
        }

        //send back
        header("location: ../dashboard/dashboard_page_team_details.php?id=$teamID");
        exit;
    }
    else if (empty($_POST['competitionSwitch']))
    {
        if(!empty($newName))
        {
            $sql = "UPDATE `teams` 
                    SET `name` =    :name,
                        `entered` = :entered,
                        `edit-at`= :edit
                    WHERE `id` = :id";
            $prepare = $db->prepare($sql);
            $prepare->execute([
                'name' => $newName,
                'entered' => null,
                'edit' => $editAt,
                'id' => $teamID
            ]);

            //send back
            header("location: ../dashboard/dashboard_page_team_details.php?id=$teamID&succ=Aanpassingen opgeslagen");
            exit;
        }
        else
        {
            $sql = "UPDATE `teams` 
                    SET `entered` = :entered,
                        `edit-at`= :edit
                    WHERE `id` = :id";
            $prepare = $db->prepare($sql);
            $prepare->execute([
                'entered' => null,
                'edit' => $editAt,
                'id' => $teamID
            ]);

            //send back
            header("location: ../dashboard/dashboard_page_team_details.php?id=$teamID&succ=Aanpassingen opgeslagen");
            exit;
        }

        //send back
        header("location: ../dashboard/dashboard_page_team_details.php?id=$teamID&err=Er is iets fout gegaan");
        exit;

    }
    else
    {
        //send back
        header("location: ../dashboard/dashboard_page_team_details.php?id=$teamID&err=Er is iets fout gegaan");
        exit;
    }

    //send back
    header("location: ../dashboard/dashboard_page_team_details.php?id=$teamID&err=Er is iets fout gegaan");
    exit;
}

if($_POST['type'] === "competitionGenerate")
{
    $startTime = htmlentities(trim($_POST['startTime']));

    if (empty($startTime) || $startTime === "--:--" || $startTime === null)
    {
        header("location: ../dashboard/dashboard_admin_settings.php?err=Er zijn niet genoeg teams om een competitie te starten!");
        exit;
    }

    //select every team
    $sql = "SELECT * FROM `teams` WHERE `entered` = 1";
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
        header("location: ../dashboard/dashboard_admin_settings.php?err=Er zijn niet genoeg teams om een competitie te starten!");
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
    $timeStart = $startTime;
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
        header("location: ../dashboard/dashboard_admin_settings.php?err=Er zijn geen velden om tegen te spelen!");
        exit;
    }

    // delete the latest competition and reset the table
    $resetMatchesSql = "TRUNCATE TABLE `matches`";
    $query = $db->query($resetMatchesSql);

    $resetPointsSql = "UPDATE `teams` SET points = 0";
    $query = $db->query($resetPointsSql);

    // make the new competition
    for ($i = 0; $i < $arrLength; $i++) 
    {
        for ($j = 0; $j < count($teamsArray); $j++) 
        {
            if ($teamsArray[0] !== $teamsArray[$j]) 
            {
                $sql = "INSERT INTO `matches`(`team1`, `team2`, `time`, `field`, `points_team1`, `points_team2`) 
                        VALUES (:team1, :team2, :time, :field, :points1, :points2)";
                $prepare = $db->prepare($sql);
                $prepare->execute([
                    'team1' => $teamsArray[0],
                    'team2' => $teamsArray[$j],
                    'time' => date('H:i:s', $splitTime),
                    'field' => $fieldCounter,
                    'points1' => 0,
                    'points2' => 0
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
        header("location: ../dashboard/dashboard_admin_settings.php?succ=Competitie Gegenereerd!");
        exit;
}

if ($_POST['type'] === "timeSettings")
{
    // in menutes
    $match_time = htmlentities(trim($_POST['match_time']));
    $half_time = htmlentities(trim($_POST['half_time']));
    $break_time = htmlentities(trim($_POST['break_time']));

    if (!is_numeric($match_time) || !is_numeric($half_time) || !is_numeric($break_time))
    {
        header("location: ../dashboard/dashboard_admin_settings.php?err=Er is text ingevoert inplaats van een nummer!");
        exit;
    }

    if($match_time < 0 
        || $match_time > 180 
        || $half_time < 0 
        || $half_time > 180)
    {
        header("location: ../dashboard/dashboard_admin_settings.php?err=een wedstrijd/rust kan niet kleiner zijn dan 0 minuten of groter zijn dan 3 uur (180 min)!");
        exit;
    }

    if ($break_time < 0)
    {
        header("location: ../dashboard/dashboard_admin_settings.php?err=Tijd tussen wedstrijden kunnen niet kleiner zijn dan 0 minuten!");
        exit;
    }

    $sql = "UPDATE `settings` 
            SET `match_time`= :match_time, 
                `half_time` = :half_time,
                `break_time` = :break_time
            WHERE 1";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        'match_time' => $match_time,
        'half_time' => $half_time,
        'break_time' => $break_time
    ]);

    header("location: ../dashboard/dashboard_admin_settings.php?succ=Tijden succesvol ingesteld!");
    exit;
}

if ($_POST['type'] === "fieldSettings")
{
    $fields = htmlentities(trim($_POST['fields']));
    
        
    //controles of the number is not smaller than 0
    if($fields < 0)
    {
        header("location: ../dashboard/dashboard_admin_settings.php?err=Je kan niet minder dan 0 velden hebben!");
        exit;
    }

    if(!is_numeric($fields))
    {
        header("location: ../dashboard/dashboard_admin_settings.php?err=De veldenmoet in Cijfers aangegeven worden, en geen text!");
        exit;
    }
    
    $sql = "UPDATE `settings` 
            SET `fields`= :fields
            WHERE 1";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        'fields' => $fields
    ]);

    header("location: ../dashboard/dashboard_admin_settings.php?succ=Succesvol velden ingesteld");
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

    header("location: ../dashboard/dashboard_page_team_details.php?id=$team");
    exit;
}

if ($_POST['type'] === "MatchEnd")
{
    $matchID = htmlentities(trim($_POST['match_id']));
    (int) $scoreTeamOne = htmlentities(trim($_POST['scoreTeamOne']));
    (int) $scoreTeamTwo = htmlentities(trim($_POST['scoreTeamTwo']));
    $id_team1 = htmlentities(trim($_POST['id_team1']));
    $id_team2 = htmlentities(trim($_POST['id_team2']));
    $pointsTeam1 = 0;
    $pointsTeam2 = 0;

    
    
    if(empty($scoreTeamOne) || empty($scoreTeamTwo))
    {
        if ($scoreTeamOne == 0 || $scoreTeamTwo == 0)
        {
            return;
        }
        else
        {
            header("location: ../dashboard/dashboard_page_competition.php?err=er waren 1 of meer velden niet ingevuld. bij het invullen van de eindstand");
            exit;
        }
    }
    
    if (!is_numeric($scoreTeamOne) || !is_numeric($scoreTeamTwo))
    {
        header("location: ../dashboard/dashboard_page_competition.php?err=De ingevulde waarde is geen cijfer");
        exit;
    }

    if ($scoreTeamOne < 0 || $scoreTeamTwo < 0 || $scoreTeamOne > 99 || $scoreTeamTwo > 99 )
    {
        header("location: ../dashboard/dashboard_page_competition.php?err=De score moet tussen 0 - 99 zitten.");
        exit;
    }

    Calculator::MatchPointsCalculator($scoreTeamOne, $scoreTeamTwo, $db, $matchID, "matches");
    Calculator::TeamPointsCalculator($id_team1, $id_team2, $db);
    
    header("location: ../dashboard/dashboard_page_competition.php?succ=Eindstand Succesvol ingesteld");
    exit;
}

if ($_POST['type'] === "inviteMember")
{
    $player = htmlentities(trim($_POST['playerToInvite']));
    $teamID = htmlentities(trim($_POST['teamId']));

    if ($player === "" || empty($_POST['playerToInvite']))
    {
        header("location: ../dashboard/dashboard_page_team_details.php?id=$teamID&err=je hebt niemand geselecteerd om te inviten");
        exit;
    }

    $sql = "SELECT *
            FROM `user_team`
            WHERE team = :id AND user = :user";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        'id' => $teamID,
        'user' => $player
    ]);
    $players = $prepare->fetchAll(2);
    $playerCount = $prepare->rowCount();

    if ($playerCount > 0)
    {
        header("location: ../dashboard/dashboard_page_team_details.php?id=$teamID&err=gebruiker zit al in de team");
        exit;
    }

    $sql = "INSERT INTO `user_team` (`user`, `team`) 
            VALUES (:user, :team)";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        'user' => $player,
        'team' => $teamID
    ]);

    header("location: ../dashboard/dashboard_page_team_details.php?id=$teamID&succ=succesvol geinvited");
    exit;
}

if ($_POST['type'] === "apikey")
{
    $generatedApiKey = ApiKeyGenerator();
    $createdAt = date("Y-m-d H:i:s");

    // get every api key from the database
    $sql = "SELECT * FROM api_keys";
    $query = $db->query($sql);
    $apiKeys = $query->fetchAll(2);

    for($i = 0; $i < count($apiKeys); $i++)
    {
        if ($apiKeys[$i]['apikey'] === $generatedApiKey)
        {
            $generatedApiKey = ApiKeyGenerator();
            $i = 0;
        }
    }

    $sql = "INSERT INTO api_keys (apikey, `created-at`) VALUES (:api, :createdAt)";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        'api' => $generatedApiKey,
        'createdAt' => $createdAt
    ]);
    
    header("location: ../dashboard/dashboard_admin_settings.php?succ=De Api-key is succesvoll gegenereerd!");
    exit;
}

function ApiKeyGenerator() {
    $length = 15;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#%^*';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) 
    {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}