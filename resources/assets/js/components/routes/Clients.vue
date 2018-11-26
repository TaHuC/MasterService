<template>
    <div>
        <vue-topprogress ref="topProgress"></vue-topprogress>
        <div class="card border text-white border-secondary" v-if="showNoClient" style="background-color: #212529;">
            <div class="card-body">
                <h5>Този клиент не е намерен!</h5>
            </div>
        </div>

        <div class="card border text-white border-danger" v-show="showNewClient" style="background-color: #212529">
            <div class="card-header" style="background-color: #394c57;">
                <h5>Добавяне на клиент</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="phone" class="active">Телефонен номер</label>
                    <input id="phone" type="text" autocomplete="off" class="form-control" v-model="newClient.phone" name="phone" required>
                </div>

                <div class="form-group">
                    <label for="idNumber" class="active">ЕГН</label>
                    <input id="idNumber" type="text" autocomplete="off" class="form-control" v-model="newClient.idNumber" name="idNumber">
                    
                </div>

                <div class="form-group">
                    <label for="email" class="active">Е-поща</label>
                    <input id="email" type="email" autocomplete="off" class="form-control" v-model="newClient.email" name="email">
                        
                </div>

                <div class="form-group">
                    <label for="name" class="active">Имена Клиента</label>
                    <input id="name" type="text" autocomplete="off" class="form-control" v-model="newClient.name" name="name" required autofocus>
                    
                </div>
                <div class="form-group text-right">
                    <button class="btn btn-success" @click="saveUser()"><i class="fas fa-save"></i></button>
                </div>
            </div>

            <div class="card m-3" v-if="showOldClient">
                <div class="card-header text-dark">
                    <h5 class="text-left">Този {{ oldClient.found }} е на клиент {{ oldClient.name }}</h5>
                    <router-link to="oldClient.id" class="btn btn-link" >Отвори</router-link>
                </div>
            </div>
        </div>

        <div v-if="showClient" class="card border text-white border-danger" style="background-color: #212529;">
            <div class="card-header" style="background-color: #394c57;">
                <h5>{{ client.name }}</h5>
                <small class="mr-2" v-show="client.idNumber != 0"><i class="fas fa-id-card"></i> {{ client.idNumber }}</small>
                <small class="mr-2" v-show="client.phone"><i class="fas fa-phone"></i> {{ client.phone }}</small>
                <small class="mr-2" v-show="client.email" ><i class="fas fa-envelope"></i> {{ client.email }}</small>
                <button class="btn btn-outline-danger float-right" @click="showDevices = false"><i class="fas fa-plus"></i></button>
            </div>
            <div  class="card-body">
                <div class="" v-if="showOldClientDev">
                    <h4>Това устройство е на клиент {{ oldClientDev.client.name }}</h4>
                    <router-link :to="`/clients/${oldClientDev.client.id}`" class="btn btn-link">Отвори</router-link>
                    <button class="btn btn-link" @click="moveNewClient()">Премести на този клиент</button>
                </div>
                <div v-if="!showDevices && !showOldClientDev">
                    <button @click="showDevices = true, newDevice = [], showAddDevForm = false" class="close">&times;</button>
                    <h4>Добавяне на ново утройство</h4>
                    <button class="btn mr-3" v-for="type in types" :key="type.id" @click="showAddDevForm = true, newDevice.typeId = type.id" :class="type.id == newDevice.typeId ? 'btn-warning' : 'btn-outline-light'">{{ type.title }}</button>
                    <div class="" v-show="showAddDevForm">
                        <div class="form-group">
                            <label for="serial">Сериен N</label>
                            <input type="text" id="serial" @change="checkSerial()" class="form-control" placeholder="SN6576532...(при липса не се попълва)" v-model="newDevice.serial">
                        </div>
                        <div class="form-group" v-if="showAddBrand">
                            <label for="brand">Марка</label>
                            <input type="text" id="brand" class="form-control" v-model.trim="newBrand" @keyup="getBrand" placeholder="Samsung">
                            <div class="">
                                <button v-if="showAddBrandBtn" @click="saveBrand()" class="btn btn-outline-success mr-1 mt-1">Добави нова марка</button>
                                <button class="btn btn-outline-light mr-1 mt-1" @click="setBrandId(brand.id, brand.title)" v-for="brand in brands" :key="brand.id">{{ brand.title }} | {{ brand.id }}</button>
                            </div>
                        </div>
                        <div class="form-group" v-if="!showAddBrand && !showAddModel">
                            <label for="setModel">Избрана Марка</label>
                            <input type="text" disabled class="form-control" v-model="selectBrand">
                        </div>
                        <div class="form-group" v-if="showAddModel">
                            <label for="modelBrand">Модел</label>
                            <input type="text" id="modelBrand" :autofocus="showAddModel" class="form-control" placeholder="Galaxy S7" @keyup="getModel" v-model.trim="newModel">
                            <div class="">
                                <button v-if="showAddModelBtn" @click="saveModel()" class="btn btn-outline-success mr-1 mt-1">Добави нов модел</button>
                                <button class="btn btn-outline-light mr-1 mt-1" @click="setModelId(model.id, model.title)" v-for="model in models" :key="model.id">{{ model.title }} | {{ model.id }}</button>
                            </div>
                        </div>
                        <div class="form-group" v-if="!showAddBrand && !showAddModel">
                            <label for="setModel">Избран Модел</label>
                            <input type="text" class="form-control" disabled v-model="selectModel">
                        </div>
                        <div class="form-group">
                            <label for="comment">Забележка</label>
                            <textarea v-model="newDevice.comment" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success float-right" @click="saveNewDevice()" :disabled="!selectModel && !selectBrand"><i class="fas fa-save"></i></button>
                        </div>
                    </div>
                </div>
                <table class="table table-dark table-sm" v-if="showDevices && !showOldClientDev">
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
import { isNumber } from 'util';
import { equal } from 'assert';
import Autocomplete from 'vuejs-auto-complete'

    export default {
        name: 'Clients',
        data() {
            return {
                oldSearch: 'nqma nikoi',
                client: '',
                products: [],
                newClient: [],
                oldClient: [],
                types: [],
                newDevice: [],
                brands: [],
                models: [],
                selectBrand: null,
                selectModel: null,
                newBrand: null,
                newModel: null,
                oldClientDev: [],
                showOldClientDev: false,
                showAddBrand: true,
                showAddBrandBtn: false,
                showAddModel: false,
                showAddModelBtn: false,
                showAddDevForm: false,
                showClient: false,
                showNoClient: false,
                showNewClient: false,
                showOldClient: false,
                showDevices: true
                //isLoading: true
            }
        },
        mounted() {
            //console.log(isNumber(Number(this.$route.params.client)))
            if(this.$route.params.client == 'addCl') {
                this.addNewClient()
            } else {
                this.getClient()
            }
        },
        created() {
            Mservice.$on('addNewClient', this.addNewClient)
        },
        methods: {
            moveNewClient(id) {
                Axios({
                    method: 'put',
                    url: `/product/${id}`
                })
            },
            checkSerial() {
                this.$refs.topProgress.start()
                Axios.get(`/product/serial/${this.newDevice.serial}`)
                .then(res => {
                    this.oldClientDev.product = res.data
                    if(res.data) {
                        Axios.get(`/client/${res.data.clientId}`)
                        .then(res => {
                            this.oldClientDev.client = res.data
                        })
                        this.showOldClientDev = true
                    } else {
                        this.showOldClientDev = false
                    }
                    this.$refs.topProgress.done()
                })
            },
            saveNewDevice() {
                this.$refs.topProgress.start()
                if(!this.newDevice.serial) {
                    let numRandom = Math.floor(Math.random() * 100000);
                    let date = new Date();
                    this.newDevice.serial = date.getDay()+''+date.getDate()+''+date.getFullYear()+''+numRandom
                }

                Axios({
                    method: 'post',
                    url: '/product',
                    data: {
                        serial: this.newDevice.serial,
                        clientId: this.client.id,
                        typeId: this.newDevice.typeId,
                        brandId: this.newDevice.brandId,
                        modelId: this.newDevice.modelId,
                        comment: this.newDevice.comment
                    }
                })
                .then(res => {
                    this.$refs.topProgress.done()
                    this.$router.push({name: 'viewProduct', params: {'product': res.data}})
                })
                .catch(err => console.log(err.response))
            },
            setBrandId(id, brand) {
                this.newDevice.brandId = id
                this.selectBrand = brand
                this.showAddBrand = false
                this.showAddModel = true
            },
            setModelId(id, model) {
                this.newDevice.modelId = id
                this.selectModel = model
                this.showAddModel = false
            },
            saveBrand() {
                Axios({
                    method: 'post',
                    url: '/brand',
                    data: {
                        brand: this.newBrand,
                        typeId: this.newDevice.typeId
                    }
                })
                .then(res => {
                    console.log(res.data)
                    this.newDevice.brandId = res.data.id
                    this.selectBrand = res.data.title
                    this.showAddBrand = false
                    this.showAddModel = true
                })
                .catch(err => console.log(err.response))
            },
            saveModel() {
                Axios({
                    method: 'post',
                    url: '/model',
                    data: {
                        model: this.newModel,
                        brandId: this.newDevice.brandId
                    }
                })
                .then(res => {
                    this.newDevice.modelId = res.data.id
                    this.selectModel = res.data.title
                    this.showAddModel = false
                })
                .catch(err => console.log(err.response))
            },
            getBrand() {
                if(this.newBrand) {
                    //console.log(this.newBrand)
                    Axios.get(`/brand/select/${this.newBrand}/${this.newDevice.typeId}`)
                    .then(res => {
                        //console.log(res.data)
                        res.data.forEach((result) => {
                            if(result.title.toLowerCase() != this.newBrand.toLowerCase()) {
                                this.showAddBrandBtn = true
                                
                            } else {
                                this.showAddBrandBtn = false
                            }
                        })

                        this.brands = res.data
                    })
                    .catch(err => console.log(err.response))
                } else {
                    this.brands = []
                    this.newBrand = null
                }
            },
            getModel() {
                if(this.newModel) {
                    //console.log(this.newBrand)
                    Axios.get(`/model/select/${this.newModel}/${this.newDevice.brandId}`)
                    .then(res => {
                        if(!res.data.lenght) {
                            this.showAddModelBtn = true
                        }
                        res.data.forEach((result) => {
                            if(result.title.toLowerCase() != this.newModel.toLowerCase()) {
                                this.showAddModelBtn = true
                            } else {
                                this.showAddModelBtn = false
                            }
                        })
                        
                        this.models = res.data
                    })
                    .catch(err => console.log(err))
                } else {
                    this.models = []
                    this.newModel = null
                }
            },
            saveUser() {
                Axios({
                    method: 'post',
                    url: '/client',
                    data: {
                        name: this.newClient.name,
                        idNum: this.newClient.idNum,
                        email: this.newClient.email,
                        phone: this.newClient.phone,
                    }
                })
                .then(res => {
                    //console.log(res.data)
                    if(res.data[1]) {
                        this.oldClient = res.data[0]
                        switch(res.data[1]) {
                            case 'phone':
                            this.oldClient.found = this.oldClient.phone
                            break;
                            case 'email':
                            this.oldClient.found = this.oldClient.email
                            break;
                            case 'idNumber':
                            this.oldClient.found = this.oldClient.idNumber
                            break;
                        }
                        this.showOldClient = true
                    } else {
                        
                        this.showOldClient = false
                        this.$router.push(`/clients/${res.data.id}`)
                        this.newClient = []
                        this.showNoClient = false
                        this.showNewClient = false
                        this.getClient()
                    }
                })
                .catch((err) => console.log(err.response))
            },
            addNewClient() {
                this.showNewClient = true
                this.showClient = false
            },
            getClient() {
                //console.log(this.$route.params.client)
                if(this.$route.params.client == 'addCl') {
                    return
                }

                let clientId = this.$route.params.client
                this.$refs.topProgress.start()

                Axios.get(`/client/show/${clientId}`)
                .then((res) => {
                    if(res.data) {
                        //console.log(res.data[1])
                        this.client = res.data[0]
                        this.products = res.data[1]
                        this.types = res.data[2]
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
                .catch(err => {
                    console.log(err.response)
                    if(err.response.status == 500) {
                        setTimeout(() => {
                            this.$refs.topProgress.done()
                            this.showNoClient = true
                        }, 3000)
                    }
                })
            }
        }
    }
</script>

<style>

</style>
