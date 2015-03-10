<div class="form-wrapper">
    <h1 class="h1h"><?php echo Translate::t('Change password');?></h1>
    <?php echo HTML::getFormErrors($form); ?>
    <form method="post" action="<?php echo $addactionPath ?>" id="form">

        <div class="form-item">
            <?php HTML::label($form, $userModel, 'email', true); ?>
            <?php HTML::inputText($form, $userModel, 'email'); ?>
            <?php HTML::error($form, $userModel, 'email'); ?>
        </div> 
        <div class="form-item captcha">
            <?php HTML::Captcha(); ?>

        </div>
        <div class="form-item">
            <?php HTML::label($form, $userModel, 'captcha'); ?>
            <?php HTML::inputText($form, $userModel, 'captcha', 'captcha'); ?>
            <?php HTML::error($form, $userModel, 'captcha'); ?>
        </div>
        <div class="button-panel">
            <input value="<?php echo Translate::t('Send');?>" type="submit"  class="button"/> 
            <input type="hidden" name="<?php echo $form->tokenName; ?>" value="<?php echo $form->generateToken(); ?>">
        </div>

    </form>
</div>
<script src="/protect/theme/js/validator.js"></script>


<?php
$j = $form->ToJson();
$translate = Translate::ToJson();
?>
<script>
    var j = <?php echo $j; ?>;
    var LangText = <?php echo $translate; ?>;
    Validator.init();
</script>
