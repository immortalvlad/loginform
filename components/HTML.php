<?php

/**
 * Description of HTML
 *
 * @author immortalvlad
 */
class HTML {

    public static function label(Form $form, Model $model, $name, $removeReq = FALSE)
    {
        $errorClass = '';
        if ($form->getFieldError($model->getTableName(), $name))
        {
            $errorClass = 'class="error"';
        }
        ?>
        <label <?php echo $errorClass; ?> for="<?php echo $name . ucfirst($model->getTableName()) ?>" ><?php echo $form->getName($model, $name) ?>
            <?php echo $form->isRequired($model, $name) && !$removeReq ? '*' : ''; ?>
        </label> 
        <?
    }

    public static function inputText(Form $form, Model $model, $name, $type = 'text')
    {
      
        $errorClass = "";
        if ($form->getFieldError($model->getTableName(), $name))
        {
            $errorClass = 'class="error"';
        }
        ?>
        <input type="<?php echo $type=='captcha'? 'text' : $type ?>" 
               placeholder="<?php //echo $form->getName($model, $name) ?>"
        <?php echo $errorClass; ?>
               name="<?php echo $model->getTableName() . "[" . $name . "]" ?>" 
               id="<?php echo $name . ucfirst($model->getTableName()) ?>" 
               value="<?php echo ($type !== 'password' &&  $type !== 'captcha') ? InputRequest::getFormPost($model->getTableName(), $name) : '' ?>">

        <?php
    }

    public static function error(Form $form, Model $model, $name)
    {
        if ($form->getFieldError($model->getTableName(), $name))
        {
            ?>
            <div class="errorMessage"><?php echo $form->getFieldError($model->getTableName(), $name); ?></div>
            <?php
        }
    }

    public static function getFormErrors(Form $form)
    {
//        Helper::PR($form->getErrors());
        $errors = $form->getErrors();
        if (!$form->success() || !empty($errors))
        {
            if (!empty($errors))
            {
                ?>
                <div class="errorSummary">
                    <p><?php echo  Translate::t('Please fix the following input errors:');?></p>
                    <ul>
                        <?php
                        foreach ($errors as $error)
                        {
                            ?>
                            <li><?php echo $error; ?></li>


                        <?php } ?>
                </ul>
                </div>
                <?php
            }
        }
    }

    public static function flash($name = '')
    {
        if (Session::init()->isExists($name))
        {
            return '<div class="flashMessage">
                <p>' . Message::show($name) . '</p>
                </div>';
        }
        return '';
    }

    public static function Captcha()
    {
        ?>       
        <iframe src="/captcha/" id="iframe" frameborder="0"  height="50px" width="130px" style="border: 0px;" scrolling="no" marginheight="5px" marginwidth="0px"></iframe>
        <a class="" href="javascript:void(0)" id="reloadCaptcha" onclick="captcha.reload()"><?php echo Translate::t('Get a new code'); ?></a>
        <?php
    }

    public static function fileUpload(Form $form, Model $model, $name)
    {
        $HtmlName = $model->getTableName() . "[" . $name . "]"; 
        ?>
                
        <script src="/protect/theme/js/fileUpload.js"></script>
        <input type="file" id="<?php echo $name;?>" name="<?php echo $HtmlName?>" />
        <a id="zone"><span class="uploadImg"></span></a>      
        <script>
            // Check for the various File API support.
            if (window.File && window.FileReader && window.FileList && window.Blob) {

                fileUploader({
                    'dropZoneId': 'zone',
                    'InputfilesId': '<?php echo $name;?>' 
                });
                fileUploader.upload();
            } else {
                d = document.getElementById('zone');
                d.id ='';
            }
        </script>
        <?php
    }

}
