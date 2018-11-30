<template>
    <div>
        <vue-topprogress ref="topProgress"></vue-topprogress>
        <div v-if="!showClients && !showOrder && !showProducts" class="card border text-white border-secondary" style="background-color: #212529;">
            <div class="card-body">
                <h5><i class="far fa-frown"></i> Няма намерени резултати</h5>
            </div>
        </div>
        <div v-if="showOrder || showClients || showProducts" class="card border text-white border-danger" style="background-color: #212529;">
            <div class="card-body">
                <h6><i class="fas fa-search"></i> Резултати</h6>
                <div class="card border-success mb-3 bg-dark text-white" v-if="showOrder" >
                    <div class="card-header" style="background-color: #394c57;">
                        <h6><i class="fas fa-tasks"></i> {{ order.id }} | <i class="fas fa-address-card"></i> {{ order.product.client.name }} | <small class=""><i class="fas fa-phone"></i> {{ order.product.client.phone }}</small></h6> 
                        <small class="text-uppercase"> {{ order.product.brand.title }} {{ order.product.model_brand.title }} ({{ order.product.serial }})</small>
                        <small v-if="order.password" class=""> | <i class="fas fa-unlock-alt"></i> {{ order.password }}</small> <small v-show="order.now" class="">| <i class="fas fa-question"></i> {{ order.now }}</small>
                    </div>
                    <div class="card-body">
                        <p class="card-text text-danger"><i class="fas fa-exclamation"></i> {{ order.problem }}</p>
                        <p v-if="order.description" class="card-text"><i class="fas fa-info"></i> {{ order.description }}</p> 
                                            
                        <router-link :to="'/products/'+order.product.id" class="card-link">Отвори</router-link>
                        <router-link :to="'/clients/'+order.product.client.id" class="card-link">Клиент</router-link>
                        
                        <div class="d-flex float-right">
                            <p v-show="orderRepairsCheck"><i class="fas fa-gavel mr-1"></i></p>
                            <p v-show="notesOrderCheck"><i class="fas fa-sticky-note mr-1"></i></p>
                            <p><i class="fas fa-clock mr-1"></i></p>
                        </div>
                        
                    </div>
                    <div class="card-footer">
                        <span class="float-left p-2 badge" :class="statusClass"><i class="fas fa-eye"></i> {{ order.status.status }}</span>
                        <div class="d-flex justify-content-end">
                            <p v-show="order.deposit" class="mr-1">Деп: <strong>{{ order.deposit }}лв.</strong></p> 
                            <p v-show="order.deposit" class="mr-1">Цена: <strong>{{ order.price }}лв.</strong></p>
                            <p class="mr-1 text-danger">Тотал: <strong>{{ order.price - order.deposit }}лв.</strong></p>
                        </div>
                    </div>
                </div>

                <div class="card border-light mb-3 text-dark" v-if="showProducts" >
                    <div class="card-header"><i class="fas fa-cubes"></i> Устройства</div>
                    <div class="card-body">
                        <router-link  v-for="product in products" :to="'/products/'+product.id" :key="product.id" class="badge badge-dark text-uppercase p-2 mr-2 mb-1">{{ product.serial }}</router-link>
                    </div>
                </div>

                <div class="card border-light mb-3 text-dark" v-if="showClients" >
                    <div class="card-header"><i class="fas fa-users"></i> Клиенти</div>
                    <div class="card-body">
                        <router-link  v-for="client in clients" :to="'/clients/'+client.id" :key="client.id" class="badge badge-dark text-uppercase p-2 mr-2 mb-1">{{ client.name }}</router-link>
                    </div>
                </div>

            </div>

        </div>
    </div>
</template>

<script>
import Axios from 'axios'
import { vueTopprogress } from 'vue-top-progress'
    export default {
        name: 'results',
        data() {
            return {
                order: null,
                showOrder: false,
                products: [],
                showProducts: false,
                clients: null,
                showClients: false,
                paginateData: null,
                statusClass: null,
                notesOrder: null,
                notesOrderCheck: false,
                orderRepairs: null,
                orderRepairsCheck: false
            }
        },
        mounted() {
            this.searchit()
            
        },
        created() {
            Mservice.$on('searchit', this.searchit) 
        },
        methods: {
            searchit() {
                let search = this.$route.params.search
                this.$refs.topProgress.start()

                Axios.get(`/order/${search}`).then((result) => {
                    // console.log(result.data.length);
                    if(result.data.length) {
                        this.showOrder = true
                        this.order = result.data[0]
                        //console.log(this.order)
                        switch(this.order.status.id) {
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

                        Axios.get(`/notes/${this.order.id}/order`).then(result => {
                            
                            if(!result.data.length) {
                                this.notesOrderCheck = false
                                this.notesOrder = null
                            } else {
                                this.notesOrder = result.data
                                this.notesOrderCheck = true
                                //console.log(result.data)
                            }
                        })

                        Axios.get(`/repair/${this.order.id}`).then(result => {
                            if(result.data.length) {
                                this.orderRepairs = result.data
                                this.orderRepairsCheck = true
                            } else {
                                this.orderRepairs = null
                                this.orderRepairsCheck = false
                            }
                        })
                       //console.log(this.order)
                    } else {
                        this.showOrder = false
                        this.order = null
                    }
                })

                Axios.get(`/product/search/${search}`)
                .then(res => {
                    //console.log(res.data)
                    if(res.data.length) {
                        this.showProducts = true
                        this.products = res.data
                    } else {
                        this.showProducts = false
                        this.products = []
                    }
                })
                .catch(err => console.log(err.response))

                Axios.get(`/clients/search?search=${search}`).then((result) => {
                    if(result.data.total != 0) {
                        this.showClients = true
                        this.clients = result.data.data
                        this.paginateData = result.data
                       // console.log(result.data)
                    }  else {
                        this.showClients = false
                        this.clients = null
                        this.paginateData = null
                    }
                    this.$refs.topProgress.done()
                }).catch(err => console.log(err))
                
            }
        },
    }
</script>

<style scoped>

</style>
