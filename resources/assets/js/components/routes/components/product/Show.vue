<template lang="">
    <div>
        <div class="d-flex justify-content-between mb-2">
            <span class="bg-secondary p-2 mr-1"><i class="fa fa-check text-warning"></i> {{ order.now ? order.now : 'Няма информация' }}</span>
            <span class="bg-secondary p-2 mr-1"><i class="fa fa-info text-warning"></i> {{ order.description ? order.description : 'Няма информация' }}</span>
            <span class="bg-secondary p-2 mr-1"><i class="fa fa-key text-warning"></i> {{ order.password ? order.password : 'Няма' }}</span>
            <span class="bg-secondary p-2"><i class="fa fa-user text-warning"></i> {{ order.user.name }} | {{ order.created_at }}</span>
        </div>
        <div class="col-12 d-flex justify-content-end">
            <button class="btn btn-outline-danger mr-2" v-show="order.statusId == 1" @click="setStatusInProgres()"><i class="fa fa-wrench"></i></button>
            <button class="btn btn-outline-warning mr-2" v-show="order.statusId != 4 && order.statusId != 5" @click="changeStatusToPart()"><i class="fa fa-puzzle-piece"></i></button>
            <button class="btn btn-outline-success mr-2" v-show="order.statusId != 4 && order.statusId != 3" @click="changeStatusToComplate()"><i class="fa fa-thumbs-up"></i></button>
            <button class="btn btn-outline-info" v-show="order.statusId != 4" @click="changeStatusToBack()"><i class="fa fa-share-square"></i></button>
        </div>
        <div class="col-12 d-sm-none d-md-flex">
            <div class="col-4"><h3>Ремонти</h3></div>
            <div class="col-4"><h4>Бележки</h4></div>
            <div class="col-4"><h3>Задачи</h3></div>
        </div>
        <div class="row p-2 overflow-auto" style="height: 400px;">
        <!-- remont -->
            <repairs :orderId="order.id" :updateOrder="updateOrder" />
        <!-- belejki -->
            <notes :orderId="order.id" />
        <!-- zadachi -->
            <tasks :orderId="order.id" />
            
        </div>
        <hr class="bg-light">
        <div class="d-flex col-12 justify-content-end" style="height: 20px;">
            <h6 class="mr-4 h4 text-success">ЦЕНА: {{ order.price }}лв.</h6>
            <h6 class="mr-4 h4 text-success">ДЕПОЗИТ: {{ order.deposit }}лв.</h6>
            <h6 class="h4 text-warning">ОСТАВАТ: {{ order.price - order.deposit }}лв.</h6>
        </div>
    </div>
</template>

<script>
import Axios from 'axios'

import Repairs from './witgets/repairs'
import Notes from './witgets/notes'
import Tasks from './witgets/tasks'

export default {
    props: {
        order: Object,
        updateOrder: Function
    },
    components: {
        Repairs,
        Notes,
        Tasks
    },
    methods: {
        setStatusInProgres() {
            this.$children[0].testFunc()
            this.updateOrder(this.order.id)
        },
        changeStatusToPart() {
            Axios.post(`/order/status/`, {
                orderId: this.order.id,
                status: 5
            })
            .then((res) => {
                if (res.data.id) {
                    this.updateOrder(this.order.id)
                }
            })
            .catch(err => {
                console.log(err)
            })
        },
        changeStatusToComplate() {
            Axios.post(`/order/status/`, {
                orderId: this.order.id,
                status: 3
            })
            .then((res) => {
                if (res.data.id) {
                    this.updateOrder(this.order.id)
                    Axios.post('/api/tasks', {
                        title: `#${this.order.id} е готова`,
                        personal: 0
                    })
                    .then()
                    .catch(err => console.log(err))
                }
            })
            .catch(err => {
                console.log(err)
            })
        },
        changeStatusToBack() {
            Axios.post(`/order/status/`, {
                orderId: this.order.id,
                status: 4
            })
            .then((res) => {
                if (res.data.id) {
                    this.updateOrder(this.order.id)
                }
            })
            .catch(err => {
                console.log(err)
            })
        }
    },
};
</script>

<style lang="">
</style>
