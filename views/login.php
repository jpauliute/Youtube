<?php
require_once './login.php';

userCheck('isUser');

list($err, $success) = LoginAction::init();

echo '<h4 class="my-4">Login</h4>';
echo validatePostResult($err, $success);
?>

<form method="POST" action="?pg=login">
    <div class="form-group my-2">
        <label for="nick">Nickname:</label>
        <input type="text" id="nick" name="nick" class="form-control" placeholder="Nickname">
    </div>

    <div class="form-group my-2">
        <label for="pass">Password:</label>
        <input type="password" id="pass" name="pass" class="form-control" placeholder="Password">
    </div>
    <button class="btn btn-primary">Continue</button>
</form>