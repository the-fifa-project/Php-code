<?php
/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 16-4-2019
 * Time: 12:53
 */

require 'config.php';
require 'Validator.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' )
{
    header("location: ../index.php");
    exit;
}

//TODO: REGISTER

if ($_POST['type'] === 'register') {
    var_dump($_POST);

    $firstName = htmlentities(trim($_POST['firstname']));
    $middleName = htmlentities(trim($_POST['middlename']));
    $lastName = htmlentities(trim($_POST['lastname']));
    $email = htmlentities(trim($_POST['email']));
    $password = htmlentities(trim($_POST['password']));
    $passwordConfirm = htmlentities(trim($_POST['passwordconfirm']));
    $registers_date = date_add("Y-m-d H:i:s");

    //TODO: checken of an field is empty
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($passwordConfirm)) {
        header("location: ../login.php?action=register&registermsg=1 of meer velden zijn leeg");
        exit;
    }

    //TODO: email validade
    if (!Validator::EmailValidate($email)) {
        header('location: ../login.php?action=register&registermsg=email is not valid');
        exit;
    }

    //TODO: password checken of gelijk is aan pwd confirm
    if (!Validator::PasswordConfirm($password, $passwordConfirm)) {
        //TODO: send back to register page wit h error code (password not match.
        header('location: ../login.php?action=register&registermsg=passwords don\'t match');
        exit;
    }

    if (Validator::PasswordLength($password)) {
        $msg = "Password needs to be 7 chars long";
        header("location: ../login.php?action=register&registermsg=$msg");
        exit;
    }

    if (!Validator::PasswordIncludesUpper($password)) {
        $msg = "Password must have 1 uppercase character";
        header("location: ../login.php?action=register&registermsg=$msg");
        exit;
    }
    if (!Validator::PasswordIncludesLower($password)) {
        $msg = "Password must have a lowercase character";
        header("location: ../login.php?action=register&registermsg=$msg");
        exit;
    }
    if (!Validator::PasswordIncludesNumber($password)) {
        $msg = "Password must have a number";
        header("location: ../login.php?action=register&registermsg$msg");
        exit;
    }

    $passwordHash = Validator::PasswordHash($password);

    if (Validator::DatabaseQueryEmail($email, "users", $db)) {
        $msg = "Email already used";
        header("location: ../login.php?action=register&registermsg=$msg");
        exit;
    }

    //TODO: inserten in database.
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
    $email = htmlentities(trim($_POST['email']));
    $password = htmlentities(trim($_POST['password']));

    if (Validator::DatabaseQueryEmail($email, "users", $db) === false)
    {
        $msg = "Account don't exist";
        header("location: ../login.php?loginmsg=$msg");
        exit;
    }

    $sql = "SELECT * FROM users WHERE email = :email";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':email' => $email
    ]);
    $user = $prepare->fetch(2);

    if (Validator::PasswordVerify($password, $user['password']) === false)
    {
        $msg = "Password or Email not match";
        header("location: ../login.php?loginmsg=$msg");
        exit;
    };

    $_SESSION['id'] = $user['id'];
    $_SESSION['username'] = $user['firstname'];
    if ($user['administrator'] !== null || $user['dev_admin'] !== null)
    {
        $_SESSION['admin'] = $user['id'];
    }
    // Check if I have a record with both this email and password combination.
    // if so, then log in.
    $msg = "Logged in";
    header("location: ../index.php?msg=$msg");
    exit;
}

if ($_POST['type'] === 'logout')
{
    session_destroy();

    $msg = "Logged Out";
    header("location: ../index.php?msg=$msg");
    exit;
}


if ($_POST['type'] === 'createteam')
{
    $owner =    $_SESSION['id'];
    $teamname = htmlentities(trim($_POST['team-name']));
    $createdAt = date("Y-m-d H:i:s");

    if(strlen($teamname) > 30)
    {
        $msg = "name is to long!";
        header("location: ../index.php?errmsg=$msg");
        exit;
    }

    $sql = "INSERT INTO teams (`owner`, `name`, `created-at`) VALUES (:owner, :name, :created_at)";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':owner' => $owner,
        ':name' => $teamname,
        ':created_at' => $createdAt
    ]);

    $msg = "team succesfull created!";
    header("location: ../teams.php?msg=$msg");
    exit;
}

if ($_POST['type'] === 'deleteteam' && isset($_SESSION['admin']))
{
    $teamId = htmlentities($_POST['teamid']);
    $confirm = htmlentities(trim(strtolower($_POST['team-name-confirm'])));

    $sql = "SELECT * FROM `teams` WHERE `id` = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        'id' => $teamId
    ]);
    $teamToDelete = $prepare->fetch(2);

    var_dump($teamToDelete);
    echo $confirm;
    if(strtolower($teamToDelete['name']) !== strtolower($confirm))
    {
        $msg = "Team namen kommen niet overeen";
        header("location: ../team_detail.php?id=$teamId&delmsg=$msg");
        exit;
    }

    $sql = "DELETE FROM `teams` WHERE `teams`.`id` = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':id' => $teamId
    ]);

    $msg = "Team succesvol verwijderd";
    header("location: ../index.php?msg=$msg");
    exit;

}

if($_POST['type'] === "editteam")
{
    $newName = htmlentities(trim($_POST['new-team-name']));
//    TODO team naam aanpassen !! UPDATE!!
//    use editmsg for to let see a error on the screen
}

if($_POST['type'] === "invietmember")
{
    $speler = htmlentities(trim($_POST['speler']));
    $team = htmlentities(trim($_POST['team']));
    
    $sql = "INSERT INTO `user_team` ( `user`, `team`) VALUES ( :user, :team)";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        'user' => $speler,
        'team' => $team


   ]);

    header("location:../team_detail.php?id=$team");
    
    exit;
}

