<template>
    <div>
        <vue-topprogress ref="topProgress"></vue-topprogress>
        <div v-if="showProduct" class="card border text-white border-secondary" style="background-color: #212529;">
            <div class="card-header d-flex" style="background-color: #394c57;">
                <div class="flex-fill text-left">
                    <h5>{{ product.brand.title }} {{ product.model_brand.title }}</h5>
                    <small>{{ product.serial }}</small>
                </div>
                <div class="flex-fill text-center">
                    <span class="badge p-2" :class="statusClass">{{ activeOrder.status.status }}</span><br>
                    <small class="text-warning"><strong><i class="fas fa-exclamation"></i> {{ activeOrder.problem }}</strong></small>
                </div>
                <div class="flex-fill text-right">
                    <h5>{{ product.client.name }}</h5>
                    <small>{{ product.client.phone }}</small>
                </div>
            </div>
            <div class="card-body">
                <div class="card text-white bg-dark">
                    <div class="card-header">
                        <button v-for="order in reverceOrder" :key="order.id" class="btn btn-sm mr-1" :class="order.id == activeOrder.id ? 'btn-warning' : 'btn-outline-secondary'">#{{ order.id }}</button>
                    </div>
                    <div class="card-body">
                        <h5>{{ activeOrder.problem }}</h5>
                        <small>{{ activeOrder.description }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Axios from 'axios';

    export default {
        name: 'Produc',
        data() {
            return {
                product: '',
                showProduct: false,
                statusClass: null,
                activeOrder: [],
                isActiveOrder: null
            }
        },
        mounted() {
            this.getProduct()
        },
        computed: {
            reverceOrder: function() {
                return _.orderBy(this.product.orders, ['id'], ['desc'])
            }
        },
        methods: {
            getProduct() {
                let productId = this.$route.params.product
                this.$refs.topProgress.start()

                Axios.get(`/product/show/${productId}`)
                .then((res) => {
                    if(res.data) {
                        this.product = res.data
                        this.showProduct = true

                        if(this.product.orders.length) {
                        
                            switch(this.product.orders[this.product.orders.length - 1].status.id) {
                                case 1: this.statusClass = 'badge-primary'
                                break;
                                case 2: this.statusClass = 'badge-light'
                                break;
                                case 3: this.statusClass = 'badge-success'
                                break;
                                case 4: this.statusClass = 'badge-info'
                                break;
                                case 5: this.statusClass = 'badge-warning'
                                break;
                            }

                            this.activeOrder = this.product.orders[this.product.orders.length - 1]
                        }

                        console.log(this.product.orders)
                    } else {
                        this.showProduct = false
                        console.log('nqma product')
                    }
                    this.$refs.topProgress.done()
                })
            }
        }
    }
</script>

<style>

</style>
