<?php $view->extend('AdminModule:base:admin.html.php'); ?>

<?php $view['slots']->start('include_js_body'); ?>
    <script src="<?php echo $view['assets']->getUrl('modules/admin/js/form.js'); ?>"></script>
<?php $view['slots']->stop(); ?>

<h1><?php echo ($user_level->getId() == 0) ? 'Create':'Edit'; ?></h1>
<hr />
<form method="post" action="<?php echo $view['router']->generate('AdminModule_User_Levels_Save'); ?>">
    <div class="form-group">
        <label for="userlevelTitle">Title</label>
        <input type="text" name="userlevelTitle" class="form-control" id="userlevelTitle" placeholder="Title" value="<?php echo $user_level->getTitle(); ?>">
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="fa fa-floppy-o"></i> Save
    </button>
    <button class="btn btn-default btn-cancel">
        <i class="fa fa-arrow-left"></i> Cancel
    </button>

    <input name="userlevelId" type="hidden" value="<?php echo $user_level->getId(); ?>" />
</form>
