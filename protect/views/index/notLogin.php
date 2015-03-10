<?php // echo $this->getContent(); ?>
<div class="form-wrapper">
    <?php echo HTML::flash('update'); ?>
    <h1 class="h1h"><?php echo Translate::t('You are not logged in.');?></h1>
    <div class="button-panel">
        <a href="<?php echo $loginpage ?>" class="button"><?php echo Translate::t('Log in now');?></a> 
        <div class="separator"><?php echo Translate::t('or');?></div>
        <a href="<?php echo $registerpage; ?>" class="button"><?php echo Translate::t('Sign up');?></a>
        
    </div>
    <br>
</div>