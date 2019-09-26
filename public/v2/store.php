<?php
require_once 'core/init.php';
$add = new ADD();
$group = new Clients();
$stoks = new Clients();
$image = new Clients();

my_head('Склад');

my_menu();



if (Token::check(Input::get('add_stock_token'))) {
    if (Input::get('stock') !== NULL) {
        try {
            $add->create(array(
                'typeStoreId' => Input::get('typeStore'),
                'barcode' => Input::get('barcode'),
                'name' => Input::get('stock'),
                'groupId' => Input::get('storeGroup'),
                'dateTime' => date('Y-m-d H:i:s'),
                'measureId' => Input::get('measure'),
                'price' => Input::get('price')
                    ), 'store');

            if (!empty($_FILES['img']['name'][0])) {
                $add->findOne(Input::get('stock'), 'name', 'store');

                $storeId = $add->data()->id;
                if (is_numeric($storeId) === TRUE) {
                    foreach ($_FILES['img']['name'] as $i => $name) {
                        $name = $_FILES['img']['name'][$i];
                        $size = $_FILES['img']['size'][$i];
                        $tmp_name = $_FILES['img']['tmp_name'][$i];
                        $type = $_FILES['img']['type'][$i];
                        $explode = explode('.', $name);
                        $ext = end($explode);
                        $folder = 'images/store/';
                        $path = $folder . basename($storeId . '_' . time() . '.' . $ext);

                        $img = new Imagick($tmp_name); // optimizaciq na snimkata
                        $img->cropthumbnailimage(400, 300);
                        $img->writeimage($tmp_name);

                        $errors = '';

                        $allowed = array('jpg', 'jpeg', 'png', 'gif');

                        if (in_array($ext, $allowed) === FALSE) {
                            $errors = 'Този (' . $name . ') файл, не се подържа!';
                        }

                        if (file_exists('images/store') === FALSE) {
                            mkdir('images/store', 0755);
                        }

                        if ($errors === '') {
                            if (move_uploaded_file($tmp_name, $path) === true) {
                                echo '<p class="text-succes">Снимката беше качена успешно</p>';
                                $add->create(array(
                                    'url' => $path,
                                    'storeId' => $storeId
                                        ), 'photos');
                            } else {
                                echo '<p class="text-danger">Нещо яко се прецака</p>';
                            }
                        } else {
                            echo '<p class="text-danger">' . $errors . "</p>";
                        }
                    }
                } else {
                    echo '<p class="text-danger">Моля обърнете се към подръжката. Има проблем с взимането на правилната стойност!!!</p>';
                    exit();
                }
            }
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }
    ?>
    <div id="redirectTest" class="alert-success tile_info text-center"><h4 class="title">Всички промени са запазени!!!</h4></div>
    <script type="text/javascript">
        $(function () {
            setTimeout($(location).attr('href', 'store.php'), 8000);
        });
    </script>
    <?php
}

if (Token::check(Input::get('apEditToken'))) {
    if (Input::get('name') !== '') {
        try {
            if (!empty($_FILES['img']['name'][0])) {
                if (Input::get('imgId')[0] !== NULL) {
                    foreach (Input::get('imgId') as $i => $imgId) {
                        $imgId = Input::get('imgId')[$i];
                        $add->dell('photos', 'id = ' . $imgId);
                    }
                }
                foreach ($_FILES['img']['name'] as $i => $name) {
                    $name = $_FILES['img']['name'][$i];
                    $size = $_FILES['img']['size'][$i];
                    $tmp_name = $_FILES['img']['tmp_name'][$i];
                    $type = $_FILES['img']['type'][$i];
                    $explode = explode('.', $name);
                    $ext = end($explode);
                    $folder = 'images/store/';
                    $path = $folder . basename(Input::get('storeId') . '_' . time() . '.' . $ext);

                    $img = new Imagick($tmp_name); // optimizaciq na snimkata
                    $img->cropthumbnailimage(400, 300);
                    $img->writeimage($tmp_name);

                    $errors = '';

                    $allowed = array('jpg', 'jpeg', 'png', 'gif');

                    if (in_array($ext, $allowed) === FALSE) {
                        $errors = 'Този (' . $name . ') файл, не се подържа!';
                    }

                    if (file_exists('images/store') === FALSE) {
                        mkdir('images/store', 0777);
                    }

                    if ($errors === '') {
                        if (move_uploaded_file($tmp_name, $path) === true) {
                            echo '<div class="panel panel-success">Снимката беше качена успешно</div>';
                            $add->create(array(
                                'url' => $path,
                                'storeId' => Input::get('storeId')
                                    ), 'photos');
                        } else {
                            echo '<p class="text-danger">Нещо яко се прецака</p>';
                        }
                    } else {
                        echo '<p class="text-danger">' . $errors . "</p>";
                    }
                }
            }

            $add->update(array(
                'typeStoreId' => Input::get('typeStore'),
                'barcode' => Input::get('barcode'),
                'name' => Input::get('name'),
                'groupId' => Input::get('storeGroup'),
                'dateTime' => date('Y-m-d H:i:s'),
                'measureId' => Input::get('measure'),
                'price' => Input::get('price')
                    ), Input::get('storeId'), 'store');
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
        ?>
        <div id="redirectTest" class="alert-success tile_info text-center"><h4 class="title">Всички промени са запазени!!!</h4></div>
        <script type="text/javascript">
            $(function () {
                setTimeout($(location).attr('href', 'store.php'), 8000);
            });
        </script>
        <?php
    } else {
        ?>
        <div class="alert-danger text-center"><h3>Стоката няма описание!</h3></div>
        <?php
    }
}

if (Input::get('storeGroup_compl') === 'compl') {
    $add->findAll('storeGroup');
    foreach ($add->data() as $check) {
        if ($check->storeGroup === Input::get('storeGroup') && $check->underGroup === Input::get('underGroup')) {
            ?>
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title">Тази група вече е добавена!</h3>
                </div>
            </div>
            <script type="text/javascript">
                $(function () {
                    setTimeout($(location).attr('href', 'store.php'), 3000);
                });
            </script>
            <?php
            exit();
        }
    }
    $add->create(array(
        'storeGroup' => Input::get('storeGroup')
            ), 'storeGroup');
    if (Input::get('underGroupCheck') !== NULL && Input::get('underGroupCheck') !== '') {
        $group->find(Input::get('storeGroup'), 'storeGroup', 'storeGroup');
        $add->update(array(
            'underGroup' => Input::get('underGroup')
                ), $group->data()->id, 'storeGroup');
    }
}

if (Token::check(Input::get('edit_token'))) {
    $group->findOne(Input::get('code'), 'id', 'store');
    $store = $group->data();
    $token = Token::generate();
    ?>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h3>Редактиране</h3>
                </div>
                <div class="x_content">
                    <form class="form-horizontal" enctype="multipart/form-data" action="" method="post">
                        <div class="form-group col-md-4">
                            <label>Вид</label>
                            <select class="form-control" name="typeStore">
                                <?php
                                $group->findAll('typeStore');
                                foreach ($group->data() as $typeStore) {
                                    ?>
                                    <option <?php
                            if ($store->typeStoreId === $typeStore->id) {
                                echo 'selected';
                            }
                                    ?> value="<?php echo $typeStore->id; ?>"><?php echo $typeStore->type; ?></option>
                                        <?php
                                    }
                                    ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label id="imgLabel">Снимки (добавете най-много 3)</label>
                            <input name="img[]" id="imgStore" accept=".png, .jpg, .jpeg, .gif" type="file" multiple="">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Група</label>
                            <select class="form-control" name="storeGroup">
                                <option>Няма група</option>
                                <?php
                                $group->findAll('storeGroup');
                                foreach ($group->data() as $storeGroup) {
                                    ?>
                                    <option <?php
                            if ($storeGroup->id === $store->groupId) {
                                echo 'selected';
                            }
                                    ?> value="<?php echo $storeGroup->id; ?>">
                                        <?php
                                            echo $storeGroup->storeGroup;
                                            if ($storeGroup->underGroup !== '0') {
                                                $group->findOne($storeGroup->underGroup, 'id', 'storeGroup');
                                                echo ' ( ' . $group->data()->storeGroup . ' )';
                                            } else {
                                                
                                            }
                                            ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Баркод</label>
                            <input class="form-control" name="barcode" value="<?php echo $store->barcode; ?>" >
                        </div>
                        <div class="form-group col-md-4">
                            <label>Стока(Описание)</label>
                            <input class="form-control" name="name" value="<?php echo $store->name; ?>" >
                        </div>
                        <div class="form-group col-md-4">
                            <label>Пр. Цена</label>
                            <input class="form-control" name="price" value="<?php echo $store->price; ?>" >
                        </div>
                        <div class="form-group col-md-4">
                            <label>Мярка</label>
                            <select class="form-control" name="measure">
                                <?php
                                $group->findAll('measure');
                                foreach ($group->data() as $measure) {
                                    ?>
                                    <option <?php
                            if ($measure->id === $store->measureId) {
                                echo 'selected';
                            }
                                    ?> value="<?php echo $measure->id; ?>"><?php echo $measure->measure; ?></option>
                                        <?php
                                    }
                                    ?>
                            </select>
                        </div>
                        <div class="form-group" id="imgEdit">
                            <label></label>
                            <?php
                            $image->findAll('photos');
                            foreach ($image->data() as $img) {
                                if ($img->storeId === $store->id) {
                                    ?>
                                    <img id="<?php echo $img->id; ?>" style="width: 64px; height: 56px;" class="img-rounded" src="<?php echo $img->url; ?>" >
                                    <input type="hidden" name="imgId[]" value="<?php echo $img->id; ?>" >
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="form-group text-right">
                            <label></label>
                            <input type="hidden" name="storeId" value="<?php echo $store->id; ?>">
                            <input type="hidden" name="apEditToken" value="<?php echo $token; ?>">
                            <button class="btn btn-primary"><i class="fa fa-edit"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}

if (!isset($token)) {
    $token = Token::generate();
}
?>

<div class="">
    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">

            <!--- navichnosti sklad --->
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Склад <small style="color: red;">Продукти</small></h2>
                        <div class="clearfix"></div>
                        <div class="pull-right">
                            <button class="btn btn-primary" type="button" data-toggle="modal" data-target=".group_modal_add"><i class="fa fa-plus"></i> Група</button>
                            <button class="btn btn-primary" type="button" data-toggle="modal" data-target=".stok_add"><i class="fa fa-plus"></i> Стока</button>

                            <!--  dobavq grupa ili model -->
                            <div class="modal fade group_modal_add" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Нова група</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" action="" method="post">
                                                <div class="form-group">
                                                    <label>Група</label>
                                                    <input class="form-control" autocomplete="off" type="text" name="storeGroup" >
                                                </div>
                                                <?php
                                                $group->findAll('storeGroup');
                                                if ($group->data() !== NULL) {
                                                    ?>
                                                    <div class="form-group">
                                                        <label><input type="checkbox" id="underGroup" class="checkbox-inline" name="underGroupCheck" > Под група</label>
                                                    </div>
                                                    <div class="form-group" id="underGroupDiv">
                                                        <label></label>
                                                        <select class="form-control" name="underGroup">
                                                            <?php
                                                            foreach ($group->data() as $grSelect) {
                                                                echo '<option value="' . $grSelect->id . '">' . $grSelect->storeGroup;
                                                                echo '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                <?php } ?>
                                                <div class="form-group">
                                                    <label>Добавени групи:</label>
                                                    <?php
                                                    $group->findAll('storeGroup');
                                                    if ($group->data() !== NULL) {
                                                        foreach ($group->data() as $allgroup) {
                                                            echo '<span style="color: #fff;" class="label label-primary">' . $allgroup->storeGroup . '</span> ';
                                                        }
                                                    } else {
                                                        echo '<span style="color: #fff;" class="label label-primary">Няма групи</span>';
                                                    }
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <input type="hidden" name="storeGroup_compl" value="compl" >
                                                    <button class="btn btn-primary pull-right"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- start add stock -->
                            <?php
                            $stoks->findAll('store');
                            $nomber = $stoks->numres() + 1;
                            ?>
                            <div class="modal fade stok_add" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Нова стока <small class="pull-right">код - <?php echo $nomber; ?></small></h4>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" enctype="multipart/form-data" action="" method="post">
                                                <div class="form-group">
                                                    <label>Вид</label>
                                                    <select name="typeStore" class="form-control">
                                                        <?php
                                                        $group->findAll('typeStore');
                                                        if ($group->data() !== NULL) {
                                                            foreach ($group->data() as $typeStore) {
                                                                echo '<option value="' . $typeStore->id . '">' . $typeStore->type . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label id="imgLabel2">Снимки (добавете най-много 3)</label>
                                                    <input name="img[]" type="file" id="imgStore2" accept=".png, .jpg, .jpeg, .gif" multiple="">
                                                </div>
                                                <div class="form-group">
                                                    <label>Група</label>
                                                    <select name="storeGroup" class="form-control">
                                                        <option value="0">Няма група</option>
                                                        <?php
                                                        $group->findAll('storeGroup');
                                                        if ($group->data() !== NULL) {
                                                            foreach ($group->data() as $allgroup) {
                                                                echo '<option value="' . $allgroup->id . '">' . $allgroup->storeGroup;
                                                                if ($allgroup->underGroup !== '0') {
                                                                    $group->findOne($allgroup->underGroup, 'id', 'storeGroup');
                                                                    echo ' (' . $group->data()->storeGroup . ')';
                                                                }
                                                                echo '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Баркод</label>
                                                    <input type="text" name="barcode" autocomplete="off" value="<?php echo Input::get('barcode'); ?>" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Стока(Описание)</label>
                                                    <input type="text" name="stock" id="stock" autocomplete="off" value="<?php echo Input::get('stock'); ?>" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Продажна цена</label>
                                                    <div class="input-group">
                                                        <input type="text" name="price" autocomplete="off" value="<?php echo Input::get('price'); ?>" class="form-control">
                                                        <label class="input-group-addon">.лв</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Мярка</label>
                                                    <select class="form-control" name="measure">
                                                        <?php
                                                        $group->findAll('measure');
                                                        if ($group->data() !== NULL) {
                                                            foreach ($group->data() as $measure) {
                                                                echo '<option value="' . $measure->id . '">' . $measure->measure . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="form-group">
                                                <input type="hidden" name="add_stock_token" value="<?php echo $token; ?>">
                                                <button id="add_stock" class="btn btn-primary btn-lg"><i class="fa fa-plus"></i></button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--- end stock add --->
                        <br>
                        <br>
                    </div>
                    <?php // tablicata sys stokata          ?>
                    <div class="x_content" style="overflow-y: auto;">
                        <table id="example" class="table table-striped responsive-utilities jambo_table">
                            <thead>
                                <tr class="headings">
                                    <th>Код </th>
                                    <th>Снимка</th>
                                    <th>Име на пеодукта </th>
                                    <th>Баркод </th>
                                    <th>Група </th>
                                    <th>Кол. </th>
                                    <th>Пр. Цена </th>
                                    <th>Ср. дост. цена </th>
                                    <th class=" no-link last"><span class="nobr">Опций</span>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $stoks->findAll('store');
                                if ($stoks->data() !== NULL) {
                                    foreach ($stoks->data() as $stoksShow) {
                                        $image->findOne($stoksShow->id, 'storeId', 'photos');
                                        ?>
                                        <tr class="even pointer">
                                            <td class=" "><?php echo $stoksShow->id; ?></td>
                                            <td><img class="img-thumbnail" style="width: 64px; height: 56px;"
                                                <?php
                                                if (empty($image->data()->url)) {
                                                    echo 'src="images/no_image.png"';
                                                    echo '>';
                                                } else {
                                                    echo 'src="' . $image->data()->url . '"';
                                                    echo 'data-toggle="modal" data-target=".photo_' . $stoksShow->id . '"';
                                                    echo '>';
                                                    $image->findAll('photos');
                                                    ?>
                                                         <div class="modal fade photo_<?php echo $stoksShow->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                                                        <div class="modal-dialog modal-lg" style="max-width: 400px; max-height: 300px;">
                                                            <div class="modal-content">
                                                                <div id="photo_slide_<?php echo $stoksShow->id; ?>" class="carousel slide" data-ride="carousel">
                                                                    <!-- Wrapper for slides -->
                                                                    <div class="carousel-inner" role="listbox">
                                                                        <?php
                                                                        $active = 'active';
                                                                        $ImgN = 0;
                                                                        foreach ($image->data() as $stockImg) {
                                                                            if ($stockImg->storeId === $stoksShow->id) {
                                                                                ?>
                                                                                <div class="item 
                                                                                <?php
                                                                                echo $active;
                                                                                $active = '';
                                                                                ?>
                                                                                     ">
                                                                                    <img src="<?php echo $stockImg->url; ?>">
                                                                                    <div class="carousel-caption">
                                                                                        <?php echo $stoksShow->name; ?>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </div>

                                                                    <!-- Controls -->
                                                                    <a class="left carousel-control" href="#photo_slide_<?php echo $stoksShow->id; ?>" role="button" data-slide="prev">
                                                                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                                                        <span class="sr-only">Previous</span>
                                                                    </a>
                                                                    <a class="right carousel-control" href="#photo_slide_<?php echo $stoksShow->id; ?>" role="button" data-slide="next">
                                                                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                                                        <span class="sr-only">Next</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td class=" "><?php echo $stoksShow->name; ?></td>
                                            <td class=" "><?php echo $stoksShow->barcode; ?> </td>
                                            <td class=" "><?php
                                        $group->find($stoksShow->groupId, 'id', 'storeGroup');
                                        if ($group->data()->storeGroup === NULL) {
                                            echo 'Няма група';
                                        } else {
                                            echo $group->data()->storeGroup;
                                        }
                                                ?> </td>
                                            <td class=" text-right"><?php echo $stoksShow->qty_store; ?> </td>
                                            <td class=" text-right"><?php echo $stoksShow->price; ?>лв.</td>
                                            <td class=" text-right"><?php echo $stoksShow->average_price; ?>лв.</td>
                                            <td class=" last">
                                                <form action="" method="post">
                                                    <input type="hidden" name="code" value="<?php echo $stoksShow->id; ?>">
                                                    <input type="hidden" name="edit_token" value="<?php echo $token ?>">
                                                    <button class="btn btn-primary"><i class="fa fa-edit"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo '<tr class="even pointer">';
                                    echo '<td>Няма продукти</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <br />

        </div>
    </div>


    <?php
    my_footer();
    