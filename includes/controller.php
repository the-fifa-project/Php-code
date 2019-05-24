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

//TODO: REGISTER

if ($_POST['type'] === 'register') {

    //set the data form the post methode to an variable
    $firstName = htmlentities(trim($_POST['firstname']));
    $middleName = htmlentities(trim($_POST['middlename']));
    $lastName = htmlentities(trim($_POST['lastname']));
    $email = htmlentities(trim($_POST['email']));
    $password = htmlentities(trim($_POST['password']));
    $passwordConfirm = htmlentities(trim($_POST['passwordconfirm']));
    $registers_date = date("Y-m-d H:i:s");

    //TODO: checken of an field is empty
    //checks of an field is empty!
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($passwordConfirm)) {
        header("location: ../login.php?action=register&registermsg=1 of meer velden zijn leeg");
        exit;
    }

    //TODO: email validade
    //checks of the email is an real email
    if (!Validator::EmailValidate($email)) {
        header('location: ../login.php?action=register&registermsg=email is not valid');
        exit;
    }

    //TODO: password checken of gelijk is aan pwd confirm
    //checks of the variables $password and $passwordConfirm equels is to each other
    if (!Validator::PasswordConfirm($password, $passwordConfirm)) {
        //TODO: send back to register page wit h error code (password not match.
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

    //TODO: inserten in database.
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
    header("location: ../login.php");//?msg=$msg");
    exit;
}

//TODO: LOGIN

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
    $_SESSION['username'] = $user['firstname'];

    //checks of he has admin rights, if has admin rights then set the session admin
    if ($user['administrator'] !== null || $user['dev_admin'] !== null)
    {
        $_SESSION['admin'] = $user['id'];
    }

    //send to the homepage
    $msg = "Logged in";
    header("location: ../index.php?msg=$msg");
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
        $msg = "voer het naam in die u wilt verwijderen!";
        header("location: ../team_detail.php?id=$teamId&delmsg=$msg");
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
        header("location: ../team_detail.php?id=$teamId&delmsg=$msg");
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
    $newName = htmlentities(trim($_POST['new-team-name']));
//    TODO team naam aanpassen !! UPDATE!!
//    use editmsg for to let see a error on the screen
    if(empty($newName))
    {
        //code...
    }
    //more code...


    exit;
}

if($_POST['type'] === "generate")
{
    // set post methode into variables
    $startTime = 

    //select every team
    $sql = "SELECT * FROM `teams` WHERE `entered` = 1";
    $query = $db->query($sql);
    $teams = $query->fetchAll(2);

    //select the settings
    $sql = "SELECT * FROM `settings`";
    $query = $db->query($sql);
    $settings = $query->fetchAll(2);

    //create 1 empty array for putting evrey team in it 
    $teamsArray = array();
    // $compititionArry = array();

    //set every team in the teamArray
    foreach ($teams as $team) {
        array_push($teamsArray, $team['name']);
    }

    //set the counter for the forloop
    $arrLength = count($teamsArray);
    $count = 1;
    $fieldCounter = 1;
    var_dump($settings);
    if ($settings['fields'] == 0)
    {
        //sendback to dashboard
        echo "no field sleceted";
    }

    //set the settings into variables
    $fields = $settings['fields'];
    $timeStart = '9:00';
    $timeMatch = $settings['match_time'];
    $timeHalf = $settings['half_time'];
    $timeBreak = $settings['break_time'];
    $timeTotal = $timeM + $timeP + $timeR;
    $endTime = strtotime($timeS);



    exit;
}
