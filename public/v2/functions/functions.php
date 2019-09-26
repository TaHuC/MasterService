<?php

function my_head($title) { ?>
    <!DOCTYPE html>
    <html lang = "en">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <title><?php echo $title; ?></title>

            <link rel="stylesheet" href="css/bootstrap.min.css" >
            <link rel="stylesheet" href="css/style.css" >
            <!--            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">-->
            <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
            <link href="css/animate.min.css" rel="stylesheet">
            <link href="css/floatexamples.css" rel="stylesheet" type="text/css"/>
            <link href="css/custom.css" rel="stylesheet">

            <!--            google MDL-->
            <!--<link rel="stylesheet" href="https://storage.googleapis.com/code.getmdl.io/1.0.6/material.indigo-pink.min.css">-->
            <!--<script src="https://storage.googleapis.com/code.getmdl.io/1.0.6/material.min.js"></script>-->
            <!--end google MDL-->
    <!--            <script src ="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
            <script src="js/jquery.min.js" type="text/javascript"></script>
    <!--            <script src="//code.jquery.com/jquery-1.10.2.js"></script>
            <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
            <script src="js/bootstrap.min.js"></script>
            <script src="js/nprogress.js"></script>
	    
            <script>
                NProgress.start();
            </script>



            <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

            <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
            <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
              <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->

        </head>
        <body class="nav-md">

            <div class="container body">


                <div class="main_container">

                    <?php
                }

                function my_footer() {
                    ?>
                    <footer>
                        <div class="">
                            <p class="pull-right">Service Master v2 by <a href="index.php">TaHuC and SisCom 2011 Ltd</a>. |
                                <span class="lead"> <i class="fa fa-bug"></i> SisCom2011!</span>
                            </p>
                        </div>
                        <div class="clearfix"></div>
                    </footer>
                    <!-- /footer content -->

                </div>
            </div>
            <!-- /page content -->
        </div>

    </div>
    </div>
    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>


    <!-- gauge js -->
    <script type="text/javascript" src="js/gauge/gauge.min.js"></script>
    <script type="text/javascript" src="js/gauge/gauge_demo.js"></script>
    <!-- chart js -->
    <script src="js/chartjs/chart.min.js"></script>
    <!-- bootstrap progress js -->
    <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
    <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
    <!-- icheck -->
    <script src="js/icheck/icheck.min.js"></script>
    <!-- daterangepicker -->
    <script type="text/javascript" src="js/moment.min.js"></script>
    <script type="text/javascript" src="js/datepicker/daterangepicker.js"></script>

    <script src="js/custom.js"></script>
    <?php
$user = new User();

    if ($user->isLoggedIn()) {
?>
        <script src="js/addMess.js" type="text/javascript"></script>
	<script src="js/siscom.js" type="text/javascript"></script>
<?php
    }
?>
    

    <!-- flot js -->
    <!--[if lte IE 8]><script type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
    <!--    <script type="text/javascript" src="js/flot/jquery.flot.js"></script>
    <script type="text/javascript" src="js/flot/jquery.flot.pie.js"></script>
    <script type="text/javascript" src="js/flot/jquery.flot.orderBars.js"></script>
    <script type="text/javascript" src="js/flot/jquery.flot.time.min.js"></script>
    <script type="text/javascript" src="js/flot/date.js"></script>
    <script type="text/javascript" src="js/flot/jquery.flot.spline.js"></script>
    <script type="text/javascript" src="js/flot/jquery.flot.stack.js"></script>
    <script type="text/javascript" src="js/flot/curvedLines.js"></script>
    <script type="text/javascript" src="js/flot/jquery.flot.resize.js"></script>
    <script type="text/javascript" src="js/autocomplete/brand.js"></script>-->

    <script>
                NProgress.done();
    </script>
    <!-- /datepicker -->
    <!-- /footer content -->

    </body>
    </html>
    <?php
}

function checkUser() {
    $user = new User();

    if ($user->isLoggedIn()) {
        
    } else {
        ?>

        <div class="panel panel-log center-block">
            <div class="panel-heading panel-log-heading">

                <h3 class="panel-title text-center panel-log-title">SisCom 2011 Ltd</h3>

            </div>
            <div class="panel-body">
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label for="username"></label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-user fa"></i></div>
                            <input type="text" class="form-control" autofocus="on" name="username" id="username" value="<?php echo Input::get('error'); ?>" autocomplete="off"> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password"></label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-key"></i></div>
                            <input type="password" class="form-control" name="password" id="password" autocomplete="off">
                        </div>
                    </div>

                    <div class="checkbox-inline">
                        <label for="remember">
                            <p><input type="checkbox" name="remember" id="remember">Запомни ме</p>
                        </label>
                    </div>
            </div>
            <div class="panel-footer">
                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                <input type="submit" class="btn form-control btn-log" value="Вход">
                </form>
            </div>
        </div>
        <p class="text-center text-log" >Нямате профил! <a class="text-log-a" href="register.php"> Регистрирай се</a></p>
        <?php
    }
}

function my_menu() {
    $user = new User();

    if ($user->isLoggedIn()) {
        ?>
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">

                <div class="navbar nav_title" style="border: 0;">
                    <a href="index.php" class="site_title"><i class="fa fa-bug"></i> <span>SisCom 2011 Ltd</span></a>
                </div>
                <div class="clearfix"></div>

                <!-- menu prile quick info -->
                <div class="profile">
                    <div class="profile_pic">
                        <?php
                        $imgPr = new ADD();
                        $imgPr->find($user->data()->id, 'userId', 'photos');
                        if ($imgPr->numres() !== NULL) {
                            foreach ($imgPr->search() as $imgCH) {
                                if ($imgCH->active == 1) {
                                    ?>
                                    <img src="<?php echo $imgCH->url; ?>" alt="..." class="img-circle profile_img">
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>
                    <div class="profile_info">
                        <span>
                            <?php
                            if (date('H:i:s') >= '05:00:00' && date('H:i:s') <= '11:59:59') {
                                echo 'Добро утро,';
                            } elseif (date('H:i:s') >= '12:00:00' && date('H:i:s') <= '17:59:59') {
                                echo 'Добър ден,';
                            } else {
                                echo 'Кое време стана!!!';
                            }
                            ?>
                        </span>
                        <h2><?php echo $user->data()->name . ' ' . $user->data()->last_name; ?></h2>
                    </div>
                </div>
                <div class="clearfix"></div>
                <!-- /menu prile quick info -->

                <br />
                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                    <div class="menu_section">
                        <h3>Сервиз</h3>
                        <ul class="nav side-menu">
                            <li><a href="index.php"><i class="fa fa-home"></i>Начало</a></li>

                        </ul>
                    </div>
                    <div class="menu_section">
                        <h3>Магазин</h3>
                        <ul class="nav side-menu">
                            <li><a class="" href="store.php"><i class="fa fa-th"></i>Склад</a></li>
                            <li><a class="" href="delivery.php"><i class="fa fa-cubes"></i> Доставки</a></li>
                        </ul>
                    </div>
                    <div class="menu_section">
                        <h3>Екстри</h3>
                        <ul class="nav side-menu">
                            <li><a href="notes.php"><i class="fa fa-sticky-note"></i>Бележки</a></li>

                        </ul>
                    </div>

                </div>
                <!-- /sidebar menu -->
                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Logout">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript" class="user-profile dropdown-toggle" data-toggle="dropdown" id="dropdownUser1" aria-haspopup="true" aria-expanded="false">
                                <?php
                                if ($imgPr->numres() !== NULL) {

                                    foreach ($imgPr->search() as $imgCH) {
                                        if ($imgCH->active == 1) {
                                            ?>
                                            <img src="<?php echo $imgCH->url; ?>" alt="">
                                            <?php
                                        }
                                    }
                                }
                                echo $user->data()->name . ' ' . $user->data()->last_name;
                                ?>
                                <span class="fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu animated fadeInDown" aria-labelledby="dropdownUser1">
                                <li><a href="profile.php">Профил</a></li>
                                <li>
                                    <?php
                                    if ($user->hasPermission('admin')) {
                                        echo '<a href="admin.php">Админ панел</a>';
                                    }
                                    ?>
                                </li>
                                <li><a href="logout.php">Изход</a></li>
                            </ul>  
                        </li>

                        <li>
                            <a href="javascript::" data-toggle="modal" data-target="#newMess"><i style="color: indianred;" class="fa fa-edit"></i></a>
                            <div id="newMess" class="modal animated fadeIn" tabindex="-1" role="dialog" aria-labellebly="">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4>Съобщение</h4>
                                        </div>
                                        <div class="modal-body">

                                            <div class="form-group">
                                                <label>До</label>
                                                <select name="userMess" id="userMess" class="form-control">
                                                    <option value="9999">До всички</option>
                                                    <?php
                                                    $userMess = new ADD();

                                                    $userMess->findAll('users');
                                                    foreach ($userMess->data() as $users) {

                                                        if ($users->groups >= 2) {
                                                            if ($users->id !== $user->data()->id) {
                                                                echo '<option value="' . $users->id . '">';
                                                                echo $users->name . ' ' . $users->last_name;
                                                                echo '</option>';
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Съобщение</label>
                                                <textarea class="form-control" id="textMess" name="textMess"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="form-group">
                                                <label></label>
                                                <input type="hidden" id="smMess" name="smMess" value="ok">
                                                <button class="btn btn-primary" data-dismiss="modal" name="sendMess" id="sendMess"><i class="fa fa-send-o fa-2x"></i></button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </li>
                        <li role="presentation" class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle info-number" id="showMessB" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-envelope-o"></i>
                                <span class="badge bg-red" id="showNumMess"></span>
                            </a>
                            <ul id="menu1" class="dropdown-menu list-unstyled msg_list animated fadeInDown" role="menu">

                            </ul>
                        </li>
                        <li role="presentation" class="dropdown">
                            <a href="javascript:" class="dropdown-toggle info-number" id="saveTimeShow" data-toggle="dropdown" airia-expanded="false">
                                <i class="fa fa-clock-o"></i>
                                <span class="badge bg-orange" id="saveTimeNum"><script>NumTime();</script></span>
                            </a>
                            <ul id="saveTimeView" class="dropdown-menu list-unstyled msg_list animated fadeInDown" rule="menu">

                            </ul>
                        </li>
                        <li role="presentation" >
                            <a href="index.php" class="info-number">
                                <i class="fa fa-tasks"></i>
                                <span class="badge bg-success" id="taskNum">1</span>
                            </a>
                        </li>
                    </ul>

                </nav>
                <div class="col-md-11">
                    <form action="results.php" method="post">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <input type="text" class="form-control" autocomplete="off" id="siscom" name="search" placeholder="Намери........">
                                <input type="hidden" name="hidden" value="1">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
                                </span>
                            </div><!-- /input-group -->
                        </div>

                    </form>
                    <div id="show_search"></div>
                </div>
                <?php
                if ($user->hasPermission('admin') || $user->hasPermission('addCl')) {
                    ?>
                    <div class="col-md-1">
                        <form class="form-inline" action="clients.php" method="post">
                            <div class="form-group">
                                <label></label>
                                <input type="hidden" name="add" value="add">
                                <button class="btn btn-link"><i class="fa fa-plus fa-2x"></i></button>
                            </div>
                        </form>
                    </div>
                <?php } ?>

            </div>

        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <div id="notification"></div>
            <!-- /top tiles -->
            <?php
        } else {
            ?>

            <div class="panel panel-log center-block">
                <div class="panel-heading panel-log-heading">

                    <h3 class="panel-title text-center panel-log-title">SisCom 2011 Ltd</h3>

                </div>
                <div class="panel-body">
                    <form action="login.php" method="post">
                        <div class="form-group">
                            <label for="username"></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-user fa"></i></div>
                                <input type="text" class="form-control" autofocus="on" name="username" id="username" value="<?php echo Input::get('error'); ?>" autocomplete="off"> 
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password"></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-key"></i></div>
                                <input type="password" class="form-control" name="password" id="password" autocomplete="off">
                            </div>
                        </div>

                        <div class="checkbox-inline">
                            <label for="remember">
                                <p><input type="checkbox" name="remember" id="remember">Запомни ме</p>
                            </label>
                        </div>
                </div>
                <div class="panel-footer">
                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                    <input type="submit" class="btn form-control btn-log" value="Вход">
                    </form>
                </div>
            </div>
            <p class="text-center text-log" >Нямате профил! <a class="text-log-a" href="register.php"> Регистрирай се</a></p>
            <?php
        }
    }
    