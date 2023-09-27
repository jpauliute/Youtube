<?php
require_once './registration.php';

userCheck('isUser');

list($err, $success) = RegistrationAction::init();

echo '<h4 class="my-4">Registration</h4>';
echo validatePostResult($err, $success);
?>

<form method="POST" action="?pg=registration">
    <div class="form-group my-2">
        <label for="nick">Nickname:</label>
        <input type="text" id="nick" name="nick" class="form-control" placeholder="Nickname">
    </div>

    <div class="form-group my-2">
        <label for="pass">Password:</label>
        <input type="password" id="pass" name="pass" class="form-control" placeholder="Password">
    </div>

    <div class="form-group my-2">
        <label for="pass2">Repeat password:</label>
        <input type="password" id="pass2" name="pass2" class="form-control" placeholder="Repeat password">
    </div>
    <button class="btn btn-primary">Continue</button>
</form>