<?php echo HTML::getFormErrors($form); ?>
<form method="post" action="<?php echo $addactionPath ?>">
    <fieldset>
        <div class="field">
            <?php HTML::label($form, $userModel, 'username', true); ?>
            <?php HTML::inputText($form, $userModel, 'username'); ?>
            <?php HTML::error($form, $userModel, 'username'); ?>
        </div>
        <div class="field">
            <?php HTML::label($form, $userModel, 'password', true); ?>
            <?php HTML::inputText($form, $userModel, 'password'); ?>
            <?php HTML::error($form, $userModel, 'password'); ?>
        </div>        
        <label for="rememberme" >
            <input type="checkbox" id="rememberme" name="remember">Remember me
        </label>
    </fieldset>
    <fieldset>
        <input value="Login" type="submit" />
        <input value="Reset" type="reset" />
        <input type="hidden" name="<?php echo $form->tokenName; ?>" value="<?php echo $form->generateToken(); ?>">
        <p>Need an account?
            <a href="<?php echo $registerpage; ?>">Sign Up</a>.<br />
            <a href="<?php echo $forgotpasswordpage; ?>">Forgot Your Password?</a>.
        </p>
    </fieldset>
</form>
<?php echo Widget::langSwitcer(); ?>