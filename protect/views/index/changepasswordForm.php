<div class="form-wrapper">
    <h1 class="h1h"><?php echo Translate::t('Change password');?></h1>
    <?php echo HTML::getFormErrors($form); ?>
    <form method="post" action="<?php echo $addactionPath ?>" id="form">

        <div class="form-item">
            <?php HTML::label($form, $userModel, 'password', true); ?>
            <?php HTML::inputText($form, $userModel, 'password'); ?>
            <?php HTML::error($form, $userModel, 'password'); ?>
        </div>
        <div class="form-item">
            <?php HTML::label($form, $userModel, 'new_password', true); ?>
            <?php HTML::inputText($form, $userModel, 'new_password'); ?>
            <?php HTML::error($form, $userModel, 'new_password'); ?>
        </div>  
        <div class="form-item">
            <?php HTML::label($form, $userModel, 'new_password_again', true); ?>
            <?php HTML::inputText($form, $userModel, 'new_password_again'); ?>
            <?php HTML::error($form, $userModel, 'new_password_again'); ?>
        </div>  

       <div class="button-panel">
           <input value="<?php echo Translate::t('Submit');?>" type="submit" class="button" /> 
            <input type="hidden" name="<?php echo $form->tokenName; ?>" value="<?php echo $form->generateToken(); ?>">
       </div>  
    </form>
    <br>
    <a href="<?php echo $backpage ?>" class="back"><?php echo Translate::t('Back');?></a>
 
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