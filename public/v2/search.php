<?php

require_once 'core/init.php';

if (Input::exists()) {
    $value = new Clients();
    $value->find(Input::get('search'), 'email', 'clients');
    $phone = new Clients();
    $phone->find(Input::get('search'), 'phone', 'clients');
    $order = new Clients();
    $order->find(Input::get('search'), 'id', 'orders');

    if ($order->numres() !== NULL) {
        foreach ($order->search() as $res) {
            $order->find($res->modelId, 'id', 'model');
            $model = $order->data();
            $order->find($res->clientId, 'id', 'clients');
            echo '<a href="device.php?order=' . $res->id . '"><div class="show_result" align="left">';
            echo $res->id . ' ' . $model->model . ' ' . $res->status . ' - ' . $order->data()->name . ' ' . $order->data()->last_name;
            echo '</div></a>';
        }
    } else if ($phone->numres() !== NULL) {
        foreach ($phone->search() as $phoneShow) {
            echo '<a href="clients.php?cl=' . $phoneShow->id . '&token=' . Token::generate() . '"><div class="show_result" align="left">';
            echo $phoneShow->name . ' ' . $phoneShow->last_name . ': <span style="color: red;">Активни устройства -</span> ';
            echo '</div></a>';
        }
    } else {
        $order->find(Input::get('search'), 'serial', 'device');
        if ($order->numres() !== NULL) {
            foreach ($order->search() as $serial) {
                $order->find($serial->id, 'serialId', 'orders');

                $orders = $order->data();
                $order->find($orders->modelId, 'id', 'model');
                $model = $order->data();
                $order->find($orders->clientId, 'id', 'clients');



                echo '<a href="device.php?order=' . $orders->id . '"><div class="show_result" align="left">';
                echo $orders->id . ' ' . $model->model . ' ' . $orders->status . ' - ' . $order->data()->name . ' ' . $order->data()->last_name;
                echo '</div></a>';
            }
        } else {
            if (!$value->numres()) {
                echo 'Няма намерени резултати';
            } else {
                foreach ($value->search() as $res) {
                    echo '<a href="clients.php?cl=' . $res->id . '&token=' . Token::generate() . '"><div class="show_result show_result" align="left">';
                    echo $res->name . ' ' . $res->last_name . ': <span style="color: red;">Активни устройства -</span> ';
                    echo '</div></a>';
                }
            }
        }
    }
}
