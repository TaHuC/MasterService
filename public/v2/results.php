<?php
require_once 'core/init.php';

my_head('Търсене');

my_menu();

if (Input::exists()) {

    $value = new Clients();

    if (is_numeric(Input::get('search'))) {
        $value->find(Input::get('search'), 'id', 'orders');
        if ($value->data() !== NULL) {
            ?>
            <script type="text/javascript" >
                $(function () {
                    $(location).attr('href', 'device.php?order=<?php echo $value->data()->id; ?>');
                });
            </script>
            <?php
        }

        $value->find(Input::get('search'), 'serial', 'device');
        $value->find($value->data()->id, 'serialId', 'orders');
        if ($value->data() !== NULL) {
            ?>
            <script type="text/javascript" >
                $(function () {
                    $(location).attr('href', 'device.php?order=<?php echo $value->data()->id; ?>');
                });
            </script>
            <?php
        }

        $value->find(Input::get('search'), 'phone', 'clients');
    } else {

        $value->find(Input::get('search'), 'serial', 'device');
        $value->find($value->data()->id, 'serialId', 'orders');
        if ($value->data() !== NULL) {
            ?>
            <script type="text/javascript" >
                $(function () {
                    $(location).attr('href', 'device.php?order=<?php echo $value->data()->id; ?>');
                });
            </script>
            <?php
        }

        $value->find(Input::get('search'), 'email', 'clients');
    }


    if ($value->search() !== NULL) {
        if (Input::get('search') && Input::get('hidden')) {
            foreach ($value->search() as $res) {
                ?>
            <div class="row tile_count">
                <div class="col-md-5 col-sm-7 col-xs-13 animated fadeInDownBig">
                    <div class="well profile_view">
                        <div class="col-sm-14">
                            <div class="left col-xs-7">
                                <h3><?php echo $res->name . ' ' . $res->last_name; ?></h3>
                                <ul class="list-unstyled">
                                    <li><i class="fa fa-phone"></i>: <?php echo $res->phone; ?></li>
                                    <li><i class="fa fa-envelope-o"></i>: <?php echo $res->email; ?></li>
                                </ul>
                            </div>
                            <div class="right col-xs-5 text-center">
                                <img src="images/user.png" alt="" class="img-rounded img-responsive">
                            </div>
                        </div>
                        <div class="left col-xs-12 bottom text-center">
                            <div class="col-xs-12 col-sm-8 emphasis">

                            </div>
                            <div class="col-xs-12 col-sm-4 emphasis">
                                <form method="post" action="clients.php" >
                                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                                    <input type="hidden" name="cl" value="<?php echo $res->id; ?>">
                                    <button type="submit" class="btn btn-primary btn-sm"> <i class="fa fa-user">
                                        </i> Отвори </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <?php
            }
        }
    }
}

my_footer();
