<p> Hello <a href="<?php echo $userpfrofilepage; ?>"><?php echo $user['username']; ?></a></p>
<?php echo HTML::flash('update'); ?>
<ul>
    <li><a href="<?php echo $logoutpage; ?>">log out</a></li>
    <li><a href="<?php echo $updatepage ?>">Update details</a></li>
    <li><a href="<?php echo $changepasswordpage; ?>">Change password</a></li>
</ul>
<?php echo Widget::langSwitcer(); ?>
