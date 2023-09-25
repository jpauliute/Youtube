<?php
class RegistrationAction
{
    public static function init()
    {
        global $pepper;

        if (isValidPost(['nick', 'pass', 'pass2'])) {
            $nick = strtolower($_POST['nick']);
            $pass = $_POST['pass'];
            $pass2 = $_POST['pass2'];

            if (!self::isValidFieldsLength($nick, $pass)) {
                $err = "Nickname must be 3-30 characters long, and password must be 8-30 characters long.";
            } elseif (self::isValidNickFormat($nick)) {
                $err = "Nickname can't contain any special characters. Only numbers and letters.";
            } elseif (!self::isValidPassFormat($pass)) {
                $err = "For security purposes, the password field must contain at least one uppercase character, one number, and one special character.";
            } elseif (!($pass === $pass2)) {
                $err = "Passwords do not match.";
            } elseif (userExists($nick)) {
                $err = "A user with this nickname already exists. Please choose a different nickname.";
            } elseif (self::ipExists()) {
                $err = "A user with this IP address is already in our system. You can only have one user.";
            } else {
                $salt = randomString(8);
                $hashedPass = sha1($pepper . $pass . $salt);

                self::saveUser($nick, $hashedPass, $salt);

                $success = "Your registration is successfull. Now you can login.";
            }

            return [isset($err) ? $err : '', isset($success) ? $success : ''];
        }

    }

    private static function isValidFieldsLength(string $nick, string $pass): bool
    {
        $nL = strlen($nick);
        $pL = strlen($pass);

        return !($nL < 3 or $nL > 30 or $pL < 8 or $pL > 30);
    }

    private static function isValidNickFormat(string $nick): bool
    {
        return preg_match('/[^a-z0-9]/', $nick);

    }

    private static function isValidPassFormat(string $pass): bool
    {
        return (
            preg_match('#[0-9]#', $pass)
            and
            preg_match('#[A-Z]#', $pass)
            and
            preg_match('/[^a-zA-Z0-9]/', $pass)
        );
    }

    private static function ipExists(): mixed {
        return S::fetchColumn('id', 'users', 'ip=:ip', [':ip' =>  $_SERVER['REMOTE_ADDR']]);
    }

    private static function saveUser(string $nick, string $hashedPass, string $salt): void
    {
        S::insert(
            'users',
            'nick, pass, salt, ip',
            ':nick, :pass, :salt, :ip',
            [
                ':nick' => $nick,
                ':pass' => $hashedPass,
                ':salt' => $salt,
                ':ip' =>  $_SERVER['REMOTE_ADDR']
            ]
        );
    }
}

?>