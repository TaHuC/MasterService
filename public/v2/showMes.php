<?php
require_once 'core/init.php';
?>
<script src="js/siscom.js" type="text/javascript"></script>

<?php
$user = new User();
$message = new ADD();


// markira kato procheteno
if (Input::exists()) {
    if (Input::get('idMass')) {
        try {
            $message->update(array(
                'active' => '0'
                    ), Input::get('idMass'), 'inboxUser');
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }
}


// proverka za potrebitel
if (!$user->isLoggedIn() && $user->hasPermission('standart')) {
    ?>
    <script type="text/javascript">
        $(function () {
            $(location).attr('href', 'index.php');
        });
    </script>
    <?php
}


// pokazva messages
$message->find($user->data()->id, 'userId', 'inboxUser', 'id DESC');

if ($message->numres() !== NULL) {
    foreach ($message->search() as $showMess) {
        if ($showMess->active !== '0') {
            ?>
            <li>
                <a id="readMess" value="<?php echo $showMess->id; ?>">
                    <span class="image">
                        <img src="<?php
                        $message->find($showMess->sendUser, 'userId', 'photos');
                        if (!$message->search() === NULL) {
                            echo 'images/works/user.png';
                        } else {
                            foreach ($message->search() as $photo) {
                                if ($photo->active === '1') {
                                    echo $photo->url;
                                }
                            }
                        }
                        ?>" alt="Profile Image" />
                    </span>
                    <span>
                        <span><?php
                            $message->find($showMess->sendUser, 'id', 'users');
                            echo $message->data()->name . ' ' . $message->data()->last_name;
                            ?>
                        </span>
                        <span class="time">
                            <?php
                            echo $showMess->dateMess;
                            ?>
                        </span>
                    </span>
                    <span class="message">
                        <?php
                        echo $showMess->textMess;
                        ?>
                    </span>
                </a>
            </li>
            <?php
        }
    }
    ?>
            
            <li>
                <a href="inbox.php" class="btn">
                    Виж всички
                </a>
            </li>
            
    <?php
}