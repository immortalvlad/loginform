<?php /* @var $usermodel Model  */ ?>
<?php /* @var $userdata   */ ?>
User profile: <br>
<?php echo $usermodel->getField('username'); ?> <?php echo $userdata['username']; ?><br>
<?php echo $usermodel->getField('email'); ?>  <?php echo $userdata['email'] ?><br>
<?php echo $usermodel->getField('telephone'); ?> <?php echo $userdata['telephone'] ?> <br>
<?php echo $usermodel->getField('date_added'); ?>  <?php echo $userdata['date_added'] ?><br>
<?php echo $usermodel->getField('status'); ?> <?php echo $userdata['status'] ?> <br>
<?php echo $usermodel->getField('first_name'); ?>  <?php echo $userdata['first_name'] ?><br>
<?php echo $usermodel->getField('last_name'); ?> <?php echo $userdata['last_name'] ?> <br>
<?php echo $usermodel->getField('loged_in'); ?>  <?php echo $userdata['loged_in'] ?><br>
<a href="<?php echo $backpage ?>">Назад</a>
<?php echo Widget::langSwitcer(); ?>
