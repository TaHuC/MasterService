<template lang="">
    <div class="w-auto p-3 h-100 bg-dark text-light border-warning border" v-if="!loading">
        <div class="col-12 row">
            <div class="p-2 col-md-4">
                <h3>{{ product.brand.title }} {{ product.model.title }}</h3>
                <small>{{ product.serial }}</small>
            </div>
            <div class="p-2 col-md-4 text-center" v-if="activeOrder.id">
                <span class="badge p-2 mb-2" :class="statusClass">{{ activeOrder.status.status }}</span>
                <h5>{{ activeOrder.problem }}</h5>
            </div>
            <div class="col-md-4" v-else></div>
            <div class="p-2 col-md-4 text-right">
                <h3>{{ client.name }}</h3>
                <small>{{ client.phone }}</small>
                <a :href="'/clients/'+client.id" class="btn btn-outline-success"><i class="fa fa-eye"></i></a>
            </div>
        </div>
        <hr class="bg-light">
        <div class="col-12" v-if="activeOrder.id">
            <button v-show="orders[0].status.id === 4" @click="showAddForm = true" class="btn-light btn-sm"><i class="fa fa-plus"></i></button>
            <button 
                v-for="order in orders" 
                :key="order.id" 
                class="btn btn-sm mr-1" 
                :class="[(activeOrder.id == order.id ? 'btn-warning' : 'btn-outline-light')]" 
                @click="changeActiveOrder(order)"
            >
            #{{ order.id }}
            </button>
            
        </div>
        <hr class="bg-light">
        
        <add v-if="showAddForm" :productId="product.id" :getProduct="getProduct" />
        <show v-else :order="activeOrder" @changeStatus="changeStatus" />
    </div>
</template>

<script>
import Axios from 'axios'
import { bus } from '../../app'

import Show from './components/product/Show'
import Add from './components/product/Add'

export default {
    components: {
        Show,
        Add
    },
    data() {
        return {
            loading: true,
            showAddForm: false,
            client: [],
            product: [],
            orders: [],
            activeOrder: '',
            statusId: 1,
            statusClass: 'badge-primary',
        }
    },
    methods: {
        changeStatus(status) {
            if (status === 4) {
                this.$children[0].$children[0].testFunc('Взет')
            }
            Axios.post(`/order/status`, {
                orderId: this.activeOrder.id,
                status: status
            })
            .then((res) => {
                if (res.data.id) {
                    if (status == 3) {
                        Axios.post('/api/tasks', {
                            title: `#${this.activeOrder.id} е готова`,
                            personal: 0
                        })
                        .then()
                        .catch(err => console.log(err))
                    }

                    this.updateOrder(this.activeOrder.id)
                }
            })
            .catch(err => {
                console.log(err)
            })
        },
        updateOrder(id) {
            Axios.get(`/order/${id}`)
            .then((res) => {
                // console.log(res.data)
                this.activeOrder.statusId = res.data[0].statusId
                this.statusId = res.data[0].statusId
                this.activeOrder.status = res.data[0].status
                this.activeOrder.price = res.data[0].price
                this.activeOrder.deposit = res.data[0].deposit
            })
        },
        changeActiveOrder(order) {
            this.activeOrder = ''
            this.activeOrder = order
            this.statusId = order.status.id
        },
        statusClassOrder (id) {
            switch (id) {
                case 1:
                    this.statusClass = 'badge-primary'
                    break;
                case 2:
                    this.statusClass = 'badge-light'
                    break;
                case 3:
                    this.statusClass = 'badge-success'
                    break;
                case 4:
                    this.statusClass = 'badge-info'
                    break;
                case 5:
                    this.statusClass = 'badge-warning'
                    break;
            }
        },
        getProduct() {
            this.loading = true
            // this.$refs.topProgress.start()
            Axios.get(`/product/show/${this.$route.params.product}`).then(res => {
                this.product.id = res.data.id
                this.product.brand = res.data.brand
                this.product.model = res.data.model_brand
                this.product.serial = res.data.serial
                this.product.comment = res.data.comment
                this.product.created_at = res.data.created_at
                this.product.created_user = res.data.user
                this.product.updated_at = res.data.updated_at
                this.client = res.data.client

                if (!res.data.orders.length) {
                    this.showAddForm = true
                    setTimeout(() => {
                        this.loading = false
                    }, 500)
                    return
                } else {
                    this.showAddForm = false
                }

                this.orders = res.data.orders.reverse()
                this.activeOrder = this.orders[0]
                this.statusId = this.activeOrder.status.id
                this.statusClassOrder(this.statusId)

                setTimeout(() => {
                    this.loading = false
                }, 500)
            })
            
        }
    },
    watch: {
        statusId: function (val) {
            this.statusClassOrder(val)
        },
        $route (to, from) {
            this.activeOrder = ''
            this.getProduct()
        }
    },
    created() {
        this.getProduct()
        bus.$on('updateOrder', (id) => {
            this.updateOrder(id)
        })
        bus.$on('changeStatus', (status) => {
            this.changeStatus(status)
        })
        
    }
}
</script>

<style scoped lang="">
    
</style>
