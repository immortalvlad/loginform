<div class="form-wrapper">
    <h1 class="h1h">Login Form</h1>
    <?php echo HTML::getFormErrors($form); ?>
    <form method="post" action="<?php echo $addactionPath ?>">

        <div class="form-item">
            <?php HTML::label($form, $userModel, 'username', true); ?>
            <?php HTML::inputText($form, $userModel, 'username'); ?>
            <?php HTML::error($form, $userModel, 'username'); ?>
        </div>
        <div class="form-item">
            <?php HTML::label($form, $userModel, 'password', true); ?>
            <?php HTML::inputText($form, $userModel, 'password','password'); ?>
            <?php HTML::error($form, $userModel, 'password'); ?>
        </div>        
        <label for="rememberme" >
            <input type="checkbox" id="rememberme" name="remember">Remember me
        </label>
        <div class="button-panel">
            <input value="Login" type="submit" class="button"/>
            <input type="hidden" name="<?php echo $form->tokenName; ?>" value="<?php echo $form->generateToken(); ?>">
            <p>Need an account?
                <a href="<?php echo $registerpage; ?>">Sign Up</a>.<br />
                <a href="<?php echo $forgotpasswordpage; ?>">Forgot Your Password?</a>.
            </p>
        </div>

    </form>
</div>