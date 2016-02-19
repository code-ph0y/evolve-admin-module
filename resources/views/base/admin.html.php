<!DOCTYPE html>
<html>
    <head>
        <title><?php $view['slots']->output('title', 'Evolve Admin') ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">

        <!-- CSS Stuff -->
        <link href="<?= $view['assets']->getUrl('components/bootstrap/dist/css/bootstrap.min.css');?>" rel="stylesheet">
        <link href="<?= $view['assets']->getUrl('components/fontawesome/css/font-awesome.css');?>" rel="stylesheet">

        <link href="<?= $view['assets']->getUrl('css/admin.css');?>" rel="stylesheet">
        <link href="<?= $view['assets']->getUrl('css/main.css');?>" rel="stylesheet">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600" rel="stylesheet" type="text/css">
        <?php $view['slots']->output('include_css'); ?>
        <!-- /CSS Stuff -->

        <!-- JS Head Stuff -->
        <script src="<?=$view['assets']->getUrl('components/modernizr/modernizr.js');?>"></script>
        <script type="text/javascript">
            var ppi = {
                baseUrl: '<?=$view['router']->generate('Homepage');?>'
            }
        </script>
        <?php $view['slots']->output('include_js_head'); ?>
        <!-- /JS Head Stuff -->
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="<?php echo $view['router']->generate('AdminModule_Dashboard'); ?>" class="navbar-brand">Evolve Admin</a>
                </div>
                <div class="navbar-collapse collapse" id="navbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#">Help</a></li>
                    </ul>
                    <form class="navbar-form navbar-right">
                        <input type="text" placeholder="Search..." class="form-control">
                    </form>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
                        <li><a href="<?php echo $view['router']->generate('AdminModule_Dashboard'); ?>">Dashboard <span class="sr-only">(current)</span></a></li>
                        <li><a href="<?php echo $view['router']->generate('AdminModule_Users'); ?>">Users</a></li>
                    </ul>
                </div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <?php $view['slots']->output('_content'); ?>
                </div>
            </div>
        </div>
        <script src="<?=$view['assets']->getUrl('components/jquery/dist/jquery.min.js');?>"></script>
        <script src="<?=$view['assets']->getUrl('components/jquery-ui/jquery-ui.js');?>"></script>
        <script src="<?=$view['assets']->getUrl('components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
        <?php $view['slots']->output('include_js_body'); ?>
    </body>
</html>
