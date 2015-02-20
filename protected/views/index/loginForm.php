<?php ?>

<form method="post" action="">
    <fieldset>
        <label for="name">Username:</label><input name="name" id="name" type="text" /><br/>
        <label for="password">Password:</label><input name="password" id="password" type="password" />
    </fieldset>
    <fieldset>
        <p class="error"></p>
        <input type="hidden" name="nonce" value="" /><input value="Login" type="submit" /><input value="Reset" type="reset" />
        <p>Need an account? <a href="">Sign Up</a>.<br /><a href="">Change Password</a>.</p>
    </fieldset>
</form>