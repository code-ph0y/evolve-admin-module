<?php $view->extend('AdminModule:base:admin.html.php'); ?>

<?php $view['slots']->start('include_js_body'); ?>
    <script src="<?php echo $view['assets']->getUrl('modules/admin/js/form.js'); ?>"></script>
<?php $view['slots']->stop(); ?>

<h1>Change Password</h1>
<p>Enter new password.</p>
<hr />
<form method="post" action="<?php echo $view['router']->generate('AdminModule_Users_Change_Password_Save'); ?>">
    <div class="form-group">
        <label for="userPassword">Password</label>
        <input type="text" name="userPassword" class="form-control" id="userPassword" placeholder="Password" value="<?php echo $rand_password; ?>">
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="fa fa-floppy-o"></i> Change Password
    </button>

    <button class="btn btn-default btn-cancel">
        <i class="fa fa-arrow-left"></i> Cancel
    </button>

    <input name="userId" type="hidden" value="<?php echo $user->getId(); ?>" />
</form>
