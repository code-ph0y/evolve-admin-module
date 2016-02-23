<!DOCTYPE html>
<html>
    <head>
        <title><?php $view['slots']->output('title', 'Evolve Admin') ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">

        <!-- CSS Stuff -->
        <link href="<?php echo $view['assets']->getUrl('components/bootstrap/dist/css/bootstrap.min.css');?>" rel="stylesheet">
        <link href="<?php echo $view['assets']->getUrl('components/fontawesome/css/font-awesome.css');?>" rel="stylesheet">

        <link href="<?php echo $view['assets']->getUrl('modules/adminmodule/css/admin.css');?>" rel="stylesheet">
        <link href="<?php echo $view['assets']->getUrl('modules/adminmodule/css/main.css');?>" rel="stylesheet">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600" rel="stylesheet" type="text/css">
        <?php $view['slots']->output('include_css'); ?>
        <!-- /CSS Stuff -->

        <!-- JS Head Stuff -->
        <script src="<?php echo $view['assets']->getUrl('components/modernizr/modernizr.js');?>"></script>
        <script type="text/javascript">
            var ppi = {
                baseUrl: '<?php echo $view['router']->generate('Homepage');?>'
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
                    <div id="flashes"></div>
                    <!-- Begin Flash Message Injection -->
                    <?php
                        $flashNames = array('info' => 'info', 'success' => 'success', 'error' => 'error', 'warning' => 'block', 'notice' => 'block');
                        $flashHeadings = array('info' => 'Heads Up!', 'error' => 'Oops!', 'success' => 'Well done!', 'block' => 'Warning!');

                        if($view['session']->hasFlashes()):
                    ?>
                    <div class="flashes">
                    <?php
                        foreach($view['session']->getFlashes() as $flashName => $flashes):
                            $alertClass = isset($flashNames[$flashName]) ? $flashNames[$flashName] : 'info';
                            foreach($flashes as $flash):
                    ?>
                            <div class="alert alert-<?php echo $alertClass?>">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <i class="icon-info-sign"></i>
                                <strong class="alert-heading"><?php echo $flashHeadings[$alertClass];?></strong>
                                <span><?php echo $flash;?></span>
                            </div>
                    <?php
                                endforeach;
                        endforeach;
                    ?>
                    </div>
                    <!-- End of Flash Message Injection -->
                    <?php
                    endif;
                    ?>

                    <?php $view['slots']->output('_content'); ?>
                </div>
            </div>
        </div>

        <script src="<?php echo $view['assets']->getUrl('components/jquery/dist/jquery.min.js');?>"></script>
        <script src="<?php echo $view['assets']->getUrl('components/jquery-ui/jquery-ui.js');?>"></script>
        <script src="<?php echo $view['assets']->getUrl('components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
        <?php $view['slots']->output('include_js_body'); ?>
    </body>
</html>
