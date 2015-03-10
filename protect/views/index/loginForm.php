
<div class="form-wrapper">
    <h1 class="h1h"><?php echo Translate::t('Login Form');?></h1>
    <?php echo HTML::getFormErrors($form); ?>
    <form method="post" action="<?php echo $addactionPath ?>" id="form">

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
            <input type="checkbox" id="rememberme" name="remember"><?php echo Translate::t('Remember me');?>
        </label>
        <div class="button-panel">
            <input value="<?php echo Translate::t('Login');?>" type="submit" class="button"/>
            <input type="hidden" name="<?php echo $form->tokenName; ?>" value="<?php echo $form->generateToken(); ?>">
            <p><?php echo Translate::t('Need an account?');?>
                <a href="<?php echo $registerpage; ?>"><?php echo Translate::t('Sign up');?></a>.<br />
                <a href="<?php echo $forgotpasswordpage; ?>"><?php echo Translate::t('Forgot Your Password?');?></a>.
            </p>
        </div>

    </form>
</div>
<script src="/protect/theme/js/validator.js"></script>


<?php
$j = $form->ToJson();
$translate = Translate::ToJson();
?>
<script>
    var j = <?php echo $j; ?> ;
    var LangText = <?php echo $translate; ?>;
    Validator.init();
</script>