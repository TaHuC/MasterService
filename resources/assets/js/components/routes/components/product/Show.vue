<template lang="">
    <div id="show">
        <div class="d-flex justify-content-between mb-2">
            <span class="bg-secondary p-2 mr-1"><i class="fa fa-check text-warning"></i> {{ order.now ? order.now : 'Няма информация' }}</span>
            <span class="bg-secondary p-2 mr-1"><i class="fa fa-info text-warning"></i> {{ order.description ? order.description : 'Няма информация' }}</span>
            <span class="bg-secondary p-2 mr-1"><i class="fa fa-key text-warning"></i> {{ order.password ? order.password : 'Няма' }}</span>
            <span class="bg-secondary p-2"><i class="fa fa-user text-warning"></i> {{ order.user.name }} | {{ order.created_at }}</span>
        </div>
        <div class="col-12 d-flex justify-content-end">
            <button 
            class="btn btn-outline-danger mr-2" 
            v-show="order.statusId == 1" 
            @click="setStatusInProgres()"
            ><i class="fa fa-wrench"></i></button>

            <button 
            class="btn btn-outline-warning mr-2" 
            v-show="order.statusId != 4 && order.statusId != 5" 
            @click="setStatus(5)"
            ><i class="fa fa-puzzle-piece"></i></button>

            <button 
            class="btn btn-outline-success mr-2" 
            v-show="order.statusId != 4 && order.statusId != 3"
            @click="setStatus(3)"
            ><i class="fa fa-thumbs-up"></i></button>

            <button class="btn btn-outline-info" 
            v-show="order.statusId != 4"
            @click="setStatus(4)"
            ><i class="fa fa-share-square"></i></button>
        </div>

        <div class="col-12 d-sm-none d-md-flex">
            <div class="col-4"><h3>Ремонти</h3></div>
            <div class="col-4"><h4>Бележки</h4></div>
            <div class="col-4"><h3>Задачи</h3></div>
        </div>

        <div class="row p-2 overflow-auto" style="height: 400px;">
        <!-- remont -->
            <repairs :orderId="order.id" :statusId="order.statusId" />
        <!-- belejki -->
            <notes :orderId="order.id" :statusId="order.statusId" />
        <!-- zadachi -->
            <tasks :orderId="order.id" :statusId="order.statusId" />
            
        </div>

        <hr class="bg-light">
        <div class="d-flex col-12 justify-content-end" style="height: 20px;">
            <div v-if="!showPrice && order.statusId != 4" class="input-group input-group-sm col-3 mb-3">
                <input type="text" v-model="newPrice" class="form-control form-control-sm text-right" aria-label="Цена..." aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button @click="addNewChange('price')" class="btn btn-outline-light"><i class="fa fa-plus"></i></button>
                </div>
            </div> 
            <h6 id="price" v-else @click="editPrice()" class="mr-4 h4 text-success">ЦЕНА: {{ order.price }}лв.</h6>
            
            <div v-if="!showDepozit && order.statusId != 4" class="input-group input-group-sm col-3 mb-3">
                <input type="text" v-model="newDepozit" class="form-control form-control-sm text-right" aria-label="Цена..." aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button @click="addNewChange('depozit')" class="btn btn-outline-light"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <h6 class="mr-4 h4 text-success" @click="editDepozit()" v-else>ДЕПОЗИТ: {{ order.deposit }}лв.</h6>
            
            <h6 class="h4 text-warning">ОСТАВАТ: {{ order.price - order.deposit }}лв.</h6>
        </div>
    </div>
</template>

<script>
import Axios from 'axios'
import { bus } from '../../../../app'

import Repairs from './witgets/repairs'
import Notes from './witgets/notes'
import Tasks from './witgets/tasks'

export default {
    props: {
        order: Object,
    },
    data() {
        return {
            showPrice: true,
            showDepozit: true,
            newPrice: this.order.price,
            newDepozit: this.order.deposit
        }
    },
    components: {
        Repairs,
        Notes,
        Tasks
    },
    methods: {
        editPrice() {
            if (this.order.statusId != 4) {
                this.showPrice = false
            }
        },
        editDepozit() {
            if (this.order.statusId != 4) {
                this.showDepozit = false
            }
        },
        setStatusInProgres() {
            this.$children[0].testFunc('Приет за ремонт')
            bus.$emit('changeStatus', 2)
        },
        setStatus(status) {
            bus.$emit('changeStatus', status)
            
        },
        addNewChange(key) {
            switch (key) {
                case 'price':
                        Axios.put(`/order/${this.order.id}`, {price: this.newPrice})
                        .then((res) => {
                            bus.$emit('updateOrder', this.order.id)
                            this.showPrice = true
                        })
                        .catch(err => console.log(err))
                    break;
                case 'depozit':
                        Axios.put(`/order/${this.order.id}`, {deposit: this.newDepozit})
                        .then((res) => {
                            bus.$emit('updateOrder', this.order.id)
                            this.showDepozit = true
                        })
                        .catch(err => console.log(err))
                    break;
            }
           
        }
    }
};
</script>

<style lang="" scoped>
h6 {
    cursor: pointer;
}
</style>
