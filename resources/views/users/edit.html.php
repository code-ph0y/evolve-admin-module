<?php $view->extend('AdminModule:base:admin.html.php'); ?>

<?php $view['slots']->start('include_js_body'); ?>
    <script src="<?php echo $view['assets']->getUrl('modules/adminmodule/js/form.js'); ?>"></script>
<?php $view['slots']->stop(); ?>

<h1><?php echo ($user->getId() === null) ? 'Create':'Edit'; ?></h1>
<hr />
<form method="post" action="<?php echo $view['router']->generate('AdminModule_Users_Save'); ?>">
    <div class="form-group">
        <label for="userInputFirstName">First Name</label>
        <input type="text" class="form-control" id="userInputFirstName" placeholder="First Name">
    </div>
    <div class="form-group">
        <label for="userInputLastName">Last Name</label>
        <input type="text" class="form-control" id="userInputLastName" placeholder="Last Name">
    </div>
    <div class="form-group">
        <label for="userInputEmail">Email Address</label>
        <input type="text" class="form-control" id="userInputEmail" placeholder="Email">
    </div>
    <div class="form-group">
        <label for="userInputEmail">User Level</label>
        <select name="user_level_id" class="form-control" id="userInputUserLevelId">
            <option value="0">Select User Level</option>
            <?php foreach ($user_levels as $user_level) : ?>
                <option <?php echo ($user->getUserLevelId()==$user_level->getId()) ? 'selected="selected"':''; ?> value="<?php echo $user_level->getId(); ?>"><?php echo $user_level->getTitle(); ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- todo: User Level Select Box -->

    <button type="submit" class="btn btn-primary">
        <i class="fa fa-floppy-o"></i> Save
    </button>
    <button class="btn btn-default btn-cancel">
        <i class="fa fa-arrow-left"></i> Cancel
    </button>
</form>
