<?php // echo $form->getName($userModel, 'username');              ?>
<?php // echo $form->getError($userModel, 'username');              ?>
<?php // echo $form->getName($UseraddressModel);              ?>
<?php echo HTML::getFormErrors($form); ?>
<form method="post" action="<?php echo $addactionPath ?>" name="register" enctype="multipart/form-data">

    <fieldset>
        <div class="field">
            <?php HTML::label($form, $userModel, 'username'); ?>
            <?php HTML::inputText($form, $userModel, 'username'); ?>
            <?php HTML::error($form, $userModel, 'username'); ?>
        </div>
        <div class="field">
            <?php HTML::label($form, $userModel, 'email'); ?>
            <?php HTML::inputText($form, $userModel, 'email'); ?>
            <?php HTML::error($form, $userModel, 'email'); ?>
        </div>
        <div class="field">
            <?php HTML::label($form, $userModel, 'password'); ?>
            <?php HTML::inputText($form, $userModel, 'password', 'password'); ?>
            <?php HTML::error($form, $userModel, 'password'); ?>
        </div>
        <div class="field">
            <?php HTML::label($form, $userModel, 'password_again'); ?>
            <?php HTML::inputText($form, $userModel, 'password_again', 'password'); ?>
            <?php HTML::error($form, $userModel, 'password_again'); ?>
        </div>
        <div class="field">
            <?php HTML::label($form, $userModel, 'telephone'); ?>
            <?php HTML::inputText($form, $userModel, 'telephone'); ?>
            <?php HTML::error($form, $userModel, 'telephone'); ?>
        </div>
        <div class="field">
            <?php HTML::label($form, $userModel, 'first_name'); ?>
            <?php HTML::inputText($form, $userModel, 'first_name'); ?>
            <?php HTML::error($form, $userModel, 'first_name'); ?>
        </div>
        <div class="field">
            <?php HTML::label($form, $userModel, 'last_name'); ?>
            <?php HTML::inputText($form, $userModel, 'last_name'); ?>
            <?php HTML::error($form, $userModel, 'last_name'); ?>
        </div>


        <div class="field">
            <label for="country">country:
                <select name="country" id="country">
                    <option value="">--</option>                  
                    <?php foreach ($countries as $country): ?>
                        <option value="<?php echo $country['Code'] ?>"             
                                ><?php echo $country['Name'] ?></option>
                            <?php endforeach; ?>
                </select>
            </label>
        </div>

        <div class="field">
            <label for="city">city:
                <select name="city" id="city">
                    <option value="">--</option>
                </select>
            </label>
        </div>
        <div class="field">
            <?php HTML::fileUpload($form, $UserpictureModel, 'image'); ?>
            <?php HTML::error($form, $UserpictureModel, 'image'); ?>
        </div>
        <div class="field">
            <?php HTML::Captcha(); ?>

        </div>
        <div class="field">
            <?php HTML::inputText($form, $userModel, 'captcha', 'captcha'); ?>
            <?php HTML::error($form, $userModel, 'captcha'); ?>
        </div>
    </fieldset>
    <fieldset>         
        <input value="Register" type="submit" />
        <input value="Reset" type="reset" />
        <input type="hidden" name="<?php echo $form->tokenName; ?>" value="<?php echo $form->generateToken(); ?>">

    </fieldset>
</form>
<script>
//    var form = document.forms.register;
//    console.log(form.elements.country);

</script>
<?php echo Widget::langSwitcer(); ?>