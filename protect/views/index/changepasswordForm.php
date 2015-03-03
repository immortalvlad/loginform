Change password
<?php echo HTML::getFormErrors($form); ?>
<form method="post" action="<?php echo $addactionPath ?>">
    <fieldset>
        <div class="field">
            <?php HTML::label($form, $userModel, 'password', true); ?>
            <?php HTML::inputText($form, $userModel, 'password'); ?>
            <?php HTML::error($form, $userModel, 'password'); ?>
        </div>
        <div class="field">
            <?php HTML::label($form, $userModel, 'new_password', true); ?>
            <?php HTML::inputText($form, $userModel, 'new_password'); ?>
            <?php HTML::error($form, $userModel, 'new_password'); ?>
        </div>  
        <div class="field">
            <?php HTML::label($form, $userModel, 'new_password_again', true); ?>
            <?php HTML::inputText($form, $userModel, 'new_password_again'); ?>
            <?php HTML::error($form, $userModel, 'new_password_again'); ?>
        </div>  
    </fieldset>
    <fieldset>
        <input value="Login" type="submit" /> 
        <input type="hidden" name="<?php echo $form->tokenName; ?>" value="<?php echo $form->generateToken(); ?>">
    </fieldset>
</form>
<?php echo Widget::langSwitcer(); ?>