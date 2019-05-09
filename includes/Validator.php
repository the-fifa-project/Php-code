<?php
/* Version: 0.0.1
 *  Author: Glenn Meering
 *  Created At: 7-5-2019 18:16
 */
class Validator
{
    //checks of the passwordConfirm equels to password.
    public static function PasswordConfirm($pwd, $pwdConfirm)
    {
        return $pwdConfirm === $pwd;
    }

    //checks of password is bigger than 7 characters long.
    public static function PasswordLength($pwd)
    {
        return strlen($pwd) < 7;
    }

    //checks of the password includes a number.
    public static function PasswordIncludesNumber($pwd)
    {
        return preg_match("#[0-9]+#", $pwd);
    }

    //checks of the password includes a lowercase character.
    public static function PasswordIncludesLower($pwd)
    {
        return preg_match("#[a-z]+#", $pwd);
    }

    //checks of the password includes a uppercase character.
    public static function PasswordIncludesUpper($pwd)
    {
        return preg_match("#[A-Z]+#", $pwd);
    }

    //checks of the password includes 1 of a special character.
    public static function PasswordIncludesSpecial($pwd)
    {
        //code
    }

    public static function PasswordHash($pwd)
    {
        return password_hash($pwd,1);
    }

    //checks of email is an valid email.
    public static function EmailValidate($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    //create an session
    public static function Login($id, $username, $admin)
    {
        $_SESSION['id'] = $id;
        $_SESSION['username'] = $username;
        if ($admin !== null)
        {
            $_SESSION['admin'] = $admin;
        }
        exit;
    }

    //checks of the passwordt is the same as the hashed password
    public static function PasswordVerify($pwd, $hash)
    {
        return password_verify($pwd, $hash);
    }

    //checks of the email already used in the database / tabel
    public static function DatabaseQueryEmail($email, $table_Name, $db)
    {
      require 'config.php';
      $sql = "SELECT * FROM $table_Name WHERE email = :email";
      $prepare = $db->prepare($sql);
      $prepare->execute([
        ':email' => $email
      ]);
      $user = $prepare->fetch(2);
      $count = $prepare->rowCount();

      return $count > 0;
    }








    // TODO: een file bestand waar je alle database selcetors maakt en inserters of andere tabel useage
}
