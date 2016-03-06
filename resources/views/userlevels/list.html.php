<?php $view->extend('AdminModule:base:admin.html.php'); ?>

<?php $view['slots']->start('include_css') ?>
    <link rel="stylesheet" href="<?php echo $view['assets']->getUrl('modules/admin/css/users.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo $view['assets']->getUrl('modules/admin/css/dataTables.bootstrap.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo $view['assets']->getUrl('modules/admin/css/list.css'); ?>"/>
<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('include_js_body') ?>
    <script src="<?php echo $view['assets']->getUrl('modules/admin/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('modules/admin/js/dataTables.bootstrap.min.js'); ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('modules/admin/js/dataTables.init.js'); ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('modules/admin/js/dialog.bootstrap.js'); ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('modules/admin/js/admin.init.js'); ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('modules/admin/js/list.js'); ?>"></script>
<?php $view['slots']->stop(); ?>

<h1>Users</h1>
<div class="row gap">
    <div class="col-md-12">
        <a class="btn btn-success pull-left" href="<?php echo $view['router']->generate('AdminModule_User_Levels_Create'); ?>" role="button"><i class="fa fa-plus"></i> Create New</a>
        <div class="btn-divider"></div>
        <form id="delete-form" method="post" action="<?php echo $view['router']->generate('AdminModule_User_Levels_Delete'); ?>">
            <button disabled="disabled" id="btn-delete-selected" type="submit" class="btn btn-danger pull-left" style="margin-left: 20px;">
                <i class="fa fa-minus"></i> Delete Selected
            </button>
            <input type="hidden" id="delete-items" name="deleteItems" />
        </form>
    </div>
</div>
<hr/>
<table class="table table-striped table-bordered" id="data-table" width="100%" cellspacing="0">
    <thead>
        <tr>
            <td><input type="checkbox" id="check-all" /></td>
            <td>Title</td>
            <td>Actions</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($user_levels as $user_level) : ?>
            <tr>
                <td>
                    <input
                        class="check-boxes"
                        type="checkbox"
                        name="selected[]"
                        value="<?php echo $user_level->getId(); ?>"
                     />
                </td>
                <td><?php echo $user_level->getTitle(); ?></td>
                <td>
                    <a class="btn btn-primary"
                       href="<?php echo $view['router']->generate('AdminModule_User_Levels_Edit', array('user_level_id'=>$user_level->getId())); ?>"
                       role="button">
                        <i class="fa fa-edit"></i> Edit User Level
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
