<?php ?>
<?php 
Helper::PR($attributes);
?>
<form method="post" action="<?php echo $adctionPath?>">
    <fieldset>
        <label for="name"><?php echo $attributes["user_entity"]["email"]; ?>:</label><input name="name" id="name" type="text" /><br/>
        <label for="password"><?php echo $attributes["user_entity"]["password"]; ?>:</label><input name="password" id="password" type="password" />
        <label for="password"><?php echo $attributes["user_entity"]["password"]; ?>:</label><input name="password" id="password" type="password" />
    </fieldset>
    <fieldset>
        <p class="error"></p>
        <input type="hidden" name="nonce" value="" /><input value="Login" type="submit" /><input value="Reset" type="reset" />
        <p>Need an account? <a href="">Sign Up</a>.<br /><a href="">Change Password</a>.</p>
    </fieldset>
</form>