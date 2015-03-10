
<div class="form-wrapper  registerForm">
    <h1 class="h1h"><?php echo Translate::t('Regster Form'); ?></h1>
    <?php echo HTML::getFormErrors($form); ?>
    <form method="post" action="<?php echo $addactionPath ?>" id="form" name="register" enctype="multipart/form-data">
        <div class="form-item">
            <?php HTML::label($form, $userModel, 'username'); ?>
            <?php HTML::inputText($form, $userModel, 'username'); ?>
            <?php HTML::error($form, $userModel, 'username'); ?>
        </div>
        <div class="form-item">
            <?php HTML::label($form, $userModel, 'email'); ?>
            <?php HTML::inputText($form, $userModel, 'email'); ?>
            <?php HTML::error($form, $userModel, 'email'); ?>
        </div>
        <div class="form-item">
            <?php HTML::label($form, $userModel, 'password'); ?>
            <?php HTML::inputText($form, $userModel, 'password', 'password'); ?>
            <?php HTML::error($form, $userModel, 'password'); ?>
        </div>
        <div class="form-item">
            <?php HTML::label($form, $userModel, 'password_again'); ?>
            <?php HTML::inputText($form, $userModel, 'password_again', 'password'); ?>
            <?php HTML::error($form, $userModel, 'password_again'); ?>
        </div>
        <div class="form-item">
            <?php HTML::label($form, $userModel, 'telephone'); ?>
            <?php HTML::inputText($form, $userModel, 'telephone'); ?>
            <?php HTML::error($form, $userModel, 'telephone'); ?>
        </div>
        <div class="form-item">
            <?php HTML::label($form, $userModel, 'first_name'); ?>
            <?php HTML::inputText($form, $userModel, 'first_name'); ?>
            <?php HTML::error($form, $userModel, 'first_name'); ?>
        </div>
        <div class="form-item">
            <?php HTML::label($form, $userModel, 'last_name'); ?>
            <?php HTML::inputText($form, $userModel, 'last_name'); ?>
            <?php HTML::error($form, $userModel, 'last_name'); ?>
        </div>


        <div class="form-item">
            <label for="country"><?php echo Translate::t('country'); ?>:<br>
                <select name="country" id="country">
                    <option value="">--</option>                  
                    <?php foreach ($countries as $country): ?>
                        <option value="<?php echo $country['Code'] ?>"             
                                ><?php echo $country['Name'] ?></option>
                            <?php endforeach; ?>
                </select>
            </label>
        </div>

        <div class="form-item">
            <label for="city"><?php echo Translate::t('city'); ?>:<br>
                <select name="city" id="city">
                    <option value="">--</option>
                </select>
            </label>
        </div>
        <div class="form-item file">
            <?php HTML::fileUpload($form, $UserpictureModel, 'image'); ?>
            <?php HTML::error($form, $UserpictureModel, 'image'); ?>
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
            <input value="<?php echo Translate::t('Register'); ?>" type="submit" class="button"/>
            <input type="hidden" name="<?php echo $form->tokenName; ?>" value="<?php echo $form->generateToken(); ?>">

        </div>
    </form>
</div>

<?php
$j = $form->ToJson();
$translate = Translate::ToJson();
?>
<script src="/protect/theme/js/validator.js"></script>
<script>
    var j = <?php echo $j; ?>;
    var LangText = <?php echo $translate; ?>;
    Validator.init();
</script>
