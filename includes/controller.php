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
    header("location: ..//index.php");
    exit;
}

//TODO: REGISTER

if ($_POST['type'] === 'register')
{
    var_dump($_POST);

    $firstName = htmlentities($_POST['firstname']);
    $middleName = htmlentities($_POST['middlename']);
    $lastName = htmlentities($_POST['lastname']);
    $email = htmlentities($_POST['email']);
    $password = htmlentities(trim($_POST['password']));
    $passwordConfirm = htmlentities(trim(_POST['passwordconfirm']));
    $registers_date = date("Y-m-d H:i:s");

    //TODO: checken of an field is empty
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($passwordConfirm))
    {
        header("location: ../register.php?msg=1 of meer velden zijn leeg");
        exit;
    }

    //TODO: email validade
    if (!Validator::EmailValidate($email))
    {
        header('location: ../register.php?msg=email is not valid');
        exit;
    }

  //TODO: password checken of gelijk is aan pwd confirm
  if (!Validator::PasswordConfirm($password, $passwordConfirm))
  {
    //TODO: send back to register page wit h error code (password not match.
    header('location: ../register.php?msg=passwords don\'t match');
    exit;
  }

  if (Validator::PasswordLength($password))
  {
    $msg = "Password needs to be 7 chars long";
    header("location: ../register.php?msg=$msg");
    exit;
  }

  if (!Validator::PasswordIncludesUpper($password))
  {
    $msg = "Password must have 1 uppercase character";
    header("location: ../register.php?msg=$msg");
    exit;
  }
  if (!Validator::PasswordIncludesLower($password))
  {
    $msg = "Password must have a lowercase character";
    header("location: ../register.php?msg=$msg");
    exit;
  }
  if (!Validator::PasswordIncludesNumber($password))
  {
      $msg = "Password must have a number";
      header("location: ../register.php?msg=$msg");
      exit;
  }

  $passwordHash =  Validator::PasswordHash($password);

  /*
   * TODO ---------------------------------------------------------------------------------
   * TODO TESTEN
   * TODO ---------------------------------------------------------------------------------
   */



  if (Validator::DatabaseQueryEmail($email, "users", $db))
  {
        $msg = "Email already used";
        header("location: ../login.php?msg=$msg");
        exit;
  }

//  $sql = "SELECT id, email FROM users WHERE email = :email";
//
//    //TODO: checken if email already exist in database
//    $sql = "SELECT * FROM users WHERE email = :email";
//    $prepare = $db->prepare($sql);
//    $prepare->execute([
//        ':email' => $email
//    ]);
//    $user = $prepare->fetch(2);
//    $count = $prepare->rowCount();
//
//    if ($count > 0)
//    {
//        $msg = "Email already used";
//        header("location: ../login.php?msg=$msg");
//        exit;
//    }



    //TODO: inserten in database.
    /*$sql = "INSERT INTO users (`firstname`, `middlename`, `lastname`, `email`, `password`, `registers_date`)
                  VALUES (:firstname, :middlename, :lastname, :email, :password, :registers_date)";*/
    $sql = "INSERT INTO users (`email`, `password`) 
                  VALUES (:email, :password)";
    $prepare = $db->prepare($sql);
    $prepare->execute([
//       ':firstname' => $firstName,
//       ':middlename' => $middleName,
//       ':lastname' => $lastName,
       ':email' => $email,
       ':password' => $passwordHash,
//       ':registers_date' => $registers_date
    ]);

    //TODO: create an session when register succesfull :D
    $sql = "SELECT * FROM users WHERE email = $email";
    $query = $db->query($sql);
    $user = $query->fetch(2);
    $_SESSION['id'] = $user['id'];
    $_SESSION['firstname'] = $user['firstname'];

    header("location: ../index.php?msg=Account succesful created");
    exit;

  /*
   * TODO ---------------------------------------------------------------------------------
   * TODO TESTEN END
   * TODO ---------------------------------------------------------------------------------
   */
}

//TODO: LOGIN

if ($_POST['type'] === 'login')
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = :email, password = :password";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':email' => $email,
//        ':password' => password_verify($password, $Hash)
    ]);
    // Check if I have a record with both this email and password combination.
    // if so, then log in.

}
