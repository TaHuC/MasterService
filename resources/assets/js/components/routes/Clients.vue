<template>
    <div>
        <vue-topprogress ref="topProgress"></vue-topprogress>
        <div class="card border text-white border-secondary" v-show="showNoClient" style="background-color: #212529;">
            <div class="card-body">
                <h5>Този клиент не е намерен!</h5>
            </div>
        </div>
        <div v-show="showClient" class="card border text-white border-danger" style="background-color: #212529;">
            <div class="card-header" style="background-color: #394c57;">
                <h5>{{ client.name }}</h5>
                <small class="mr-2" v-show="client.idNumber != 0"><i class="fas fa-id-card"></i> {{ client.idNumber }}</small>
                <small class="mr-2" v-show="client.phone"><i class="fas fa-phone"></i> {{ client.phone }}</small>
                <small class="mr-2" v-show="client.email" ><i class="fas fa-envelope"></i> {{ client.email }}</small>
            </div>
            <div  class="card-body">
                <table class="table table-dark table-sm">
                    <thead>
                        <th><i class="fas fa-boxes"></i></th>
                        <th><i class="fas fa-barcode"></i></th>
                        <th class="text-right"><i class="fas fa-qrcode"></i></th>
                    </thead>
                    <tbody>
                        <tr v-for="product in products" :key="product.id">
                            <td>{{ product.brand }} {{ product.model }}</td>
                            <td>{{ product.serial }}</td>
                            <td class="text-right"><router-link :to="'/products/'+product.id"><i class="fa fa-link"></i></router-link></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import Axios from 'axios';
//import {vueTopprogress} from 'vue-top-progress'
import { setTimeout } from 'timers';

    export default {
        name: 'Clients',
        data() {
            return {
                oldSearch: 'nqma nikoi',
                client: '',
                products: [],
                showClient: false,
                showNoClient: false
                //isLoading: true
            }
        },
        mounted() {
            this.getClient()
        },
        methods: {
            getClient() {
                //console.log(this.$route.params.client)
                let clientId = this.$route.params.client
                this.$refs.topProgress.start()

                Axios.get(`/client/show/${clientId}`)
                .then((res) => {
                    if(res.data) {
                        console.log(res.data[1])
                        this.client = res.data[0]
                        this.products = res.data[1]
                        this.showClient = true
                        //this.isLoading = false
                        this.$refs.topProgress.done()
                    } else {
                        setTimeout(() => {
                            this.$refs.topProgress.done()
                            this.showNoClient = true
                        }, 3000)
                    }
                })
                .catch(err => console.log(err))
            }
        }
    }
</script>

<style>

</style>
