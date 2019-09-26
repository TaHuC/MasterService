<?php
require_once 'core/init.php';

if (Input::get('addBrand')) {
    $value = new Clients();
    $value->find(Input::get('addBrand'), 'brand', 'brand');
    
    if (!$value->numres()) {
        echo '<p class="text-success">Добавяте нова марка :) !!!</p>';
    }else {
        foreach ($value->search() as $addBrand) {
            if ($addBrand->type === Input::get('getId')) {
                echo '<a class="btn btn-default btn-xs" id="' . $addBrand->id . '">' . $addBrand->brand . '</a>';
                ?>
                <script>
                    $('a#<?php echo $addBrand->id; ?>').click('input', function () {
                        var getDiv = $('a#<?php echo $addBrand->id; ?>').text();
                        var getId = <?php echo $addBrand->id ?>;
                        $('input#addBrand<?php echo Input::get('getId') ?>').val(getDiv);
                        $('input#addIdBrand<?php echo Input::get('getId'); ?>').val(getId);
                    });
                </script>
                <?php
            }
        }
    }
}

if (Input::get('getModel')) {
    $value2 = new Clients();
    $value2->find(Input::get('getModel'), 'model', 'model');

    if (!$value2->numres()) {
        echo '<p class="text-success">Добавяте нов модел :) !!!</p>';
    } else {
        if (isset($value2)) {
            foreach ($value2->search() as $model) {
                if ($model->brand === Input::get('getIdBrand')) {
                    echo '<a class="btn btn-default btn-xs" id="' . $model->id . '">' . $model->model . '</a>';
                    ?>
                <script>
                $('a#<?php echo $model->id; ?>').click('input', function (){
                    var modelDiv = $('a#<?php echo $model->id; ?>').text();
                   
                    $('input#addModel<?php echo Input::get('idBrand');?>').val(modelDiv);
                });
                </script>
                <?php
                }
            }
        }
    }
}
