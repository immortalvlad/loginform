<div class="form-wrapper">
    <div class="welcome">
        <p> <?php echo Translate::t('Hello');?> <a href="<?php echo $userpfrofilepage; ?>"><?php echo $user['username']; ?></a></p>
    </div>
    <?php echo HTML::flash('update'); ?>
   
    <ul class="list">
        <li ><a class="l1" href="<?php echo $logoutpage; ?>"><?php echo Translate::t('log out');?></a></li>
        <li ><a class="l2" href="<?php echo $userpfrofilepage ?>"><?php echo Translate::t('View profile');?></a></li>
        <li ><a class="l3" href="<?php echo $updatepage ?>"><?php echo Translate::t('Update details');?></a></li>
        <li ><a class="l3" href="<?php echo $changepasswordpage; ?>"><?php echo Translate::t('Change password');?></a></li>
    </ul>
</div>
