
Change password
<?php echo HTML::getFormErrors($form); ?>
<form method="post" action="<?php echo $addactionPath ?>">
    <fieldset>
        <div class="field">
            <?php HTML::label($form, $userModel, 'email', true); ?>
            <?php HTML::inputText($form, $userModel, 'email'); ?>
            <?php HTML::error($form, $userModel, 'email'); ?>
        </div> 
    </fieldset>
    <fieldset>
        <input value="Send" type="submit" /> 
        <input type="hidden" name="<?php echo $form->tokenName; ?>" value="<?php echo $form->generateToken(); ?>">
    </fieldset>
</form>
<?php echo Widget::langSwitcer(); ?>