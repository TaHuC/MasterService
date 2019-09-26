<?php
require_once 'core/init.php';

my_head('Бележки');

my_menu();
$notes = new ADD();
$user = new User();
$token = Token::generate();
?>
<div class="row" >
    <div class="col-md-8 col-sm-12 col-lg-4 pull-right">
        <div class="x_panel">

            <div class="x_title">Нова бележка</div>
            <div class="x_content">
                <div class="form-group">
                    <label>Бележка</label>
                    <textarea class="form-control" id="newNote"></textarea>
                </div>
                <div class="form-group text-right">
                    <label></label>
                    <button class="btn btn-primary" id="addNote"><i class="fa fa-plus"></i></button>
                    <input type="hidden" id="userNote" value="<?php echo $user->data()->id; ?>" >
                    <input type="hidden" id="getDate" value="<?php echo date('Y-m-d H:i:s') ?>">
                    <input type="hidden" name="token_note" value="<?php echo $token; ?>" >
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-12 col-sm-8 pull-left">
        <div class="x_panel">
            <div class="x_title">
                <h3 id="noteTitle">Бележки </h3>
            </div>
            <div class="x_content" id="showNote">
                <?php
                $notes->findAll('notes');
                foreach ($notes->data() as $note) {
                    if ($note->userNote !== NULL) {

                        if ($note->userNote === $user->data()->id) {
                            ?>
                            <!-- Start Panel -->
                            <div class="panel panel-info" id="<?php echo $note->id; ?>">
                                <div class="panel-heading">
                                    <button class="close" id="dellNote" getId="<?php echo $note->id; ?>">&times;</button>
                                    <h5 class="panel-title"><?php echo $note->dateTime; ?></h5>
                                </div>
                                <div class="panel-body bg-info">
                                    <?php echo $note->note; ?>
                                </div>
                            </div> <!-- End Panel -->
                            <?php
                        }
                    }
                }
                ?>



            </div>
        </div>
    </div>


</div>
<?php
my_footer();
