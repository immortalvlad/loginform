<?php /* @var $usermodel Model  */ ?>
<?php /* @var $userdata   */ ?>
<div class="form-wrapper profile">
    <h1 class="h1h"> <?php echo Translate::t('User profile');?>:</h1>
    <table>
        <tr>
            <td> <?php echo $usermodel->getField('username'); ?></td>
            <td>  <?php echo $userdata['username']; ?></td>
        </tr>
        <tr>
            <td> <?php echo $usermodel->getField('email'); ?> </td>
            <td> <?php echo $userdata['email'] ?></td>
        </tr>
        <tr>
            <td> <?php echo $usermodel->getField('telephone'); ?> </td>
            <td>  <?php echo $userdata['telephone'] ?></td>
        </tr>
        <tr>
            <td><?php echo $usermodel->getField('date_added'); ?></td>
            <td> <?php echo $userdata['date_added'] ?></td>
        </tr>
        <tr>
            <td> <?php echo $usermodel->getField('status'); ?></td>
            <td><?php echo $userdata['status'] ?> </td>
        </tr>
        <tr>
            <td> <?php echo $usermodel->getField('first_name'); ?></td>
            <td>  <?php echo $userdata['first_name'] ?></td>
        </tr>
        <tr>
            <td><?php echo $usermodel->getField('last_name'); ?></td>
            <td> <?php echo $userdata['last_name'] ?> </td>
        </tr>
   
        <tr>
            <td></td>
            <td></td>
        </tr>
    </table>
    <a class="back" href="<?php echo $backpage ?>"><?php echo Translate::t('Back');?></a>
</div>