<template>
    <div>
        <vue-topprogress ref="topProgress"></vue-topprogress>
        <div v-if="showProduct" class="card border text-white border-secondary" style="background-color: #212529;">
            <div class="card-header d-flex" style="background-color: #394c57;">
                <div class="flex-fill text-left">
                    <h5>{{ product.brand.title }} {{ product.model_brand.title }}</h5>
                    <small>{{ product.serial }}</small>
                </div>
                <div v-if="showOrder" class="flex-fill text-center">
                    <span class="badge p-2" :class="statusClass">{{ activeOrder.status.status }}</span>
                    <br>
                    <h6 class="text-warning"><strong><i class="fas fa-exclamation"></i> {{ activeOrder.problem }}</strong></h6>
                </div>
                <div class="flex-fill text-right">
                    <h5>{{ product.client.name }}</h5>
                    <small><strong>{{ product.client.phone }}</strong></small><br>
                    <router-link :to="{name: 'client', params: {client: product.client.id}}" class="btn btn-sm btn-outline-success"><i class="fas fa-eye"></i></router-link>
                </div>
            </div>
            <div class="card-body">
                <div class="card border border-success text-white bg-dark">
                    <div class="card-header">
                        <button v-if="showAddBtn" @click="showOrder = false" class="btn btn-sm btn-outline-light mr-1"><i class="fas fa-plus"></i></button>
                        <button v-for="order in reverceOrder" :key="order.id" class="btn btn-sm mr-1" @click="chageOrder(order.id)" :class="order.id == activeOrder.id ? 'btn-warning' : 'btn-outline-secondary'">#{{ order.id }}</button>
                    </div>
                    <div class="card-body">
                        <div v-if="!showOrder" class="card border border-success bg-dark">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6 form-group">
                                        <label for="problem">Проблем</label>
                                        <input type="text" class="form-control" autocomplete="off" v-model="newOrder.problem" name="problem" id="problem" placeholder="Проблем..." required>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="Now">Състояние</label>
                                        <input type="text" class="form-control" autocomplete="off" v-model="newOrder.now" name="now" id="now" placeholder="Състояние..." required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 form-group">
                                        <label for="password">Парола</label>
                                        <input type="text" name="password" class="form-control" v-model="newOrder.password" autocomplete="off" id="password" placeholder="password...">
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="description">Информация</label>
                                        <textarea class="form-control" id="description" v-model="newOrder.description" autocomplete="off" name="description"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 input-group">
                                        <label for="price">Цена</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control text-right" autocomplete="off" v-model.number="newOrder.price" name="price" id="price" placeholder="20..." value="0">
                                            <div class="input-group-addon">
                                                <span class="input-group-text">лв.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 input-group">
                                        <label for="deposit">Депосит</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control text-right" id="deposit" v-model.number="newOrder.deposit" autocomplete="off" name="deposit" placeholder="10..." value="0">
                                            <div class="input-group-addon">
                                                <span class="input-group-text">лв.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group w-100">
                                        <button class="btn btn-success mt-3 mr-3 float-right" @click="saveNewOrder()"><i class="fas fa-save"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card border border-muted bg-dark" v-if="showOrder">
                            <div class="card-header">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td><i class="fas fa-braille text-warning"></i></td>
                                            <td>{{ activeOrder.now }}</td>
                                        </tr>
                                        <tr v-show="activeOrder.description">
                                            <td><i class="fas fa-info text-info"></i></td>
                                            <td>{{ activeOrder.description }}</td>
                                        </tr>
                                        <tr v-show="activeOrder.password">
                                            <td><i class="fas fa-key text-danger"></i></td>
                                            <td>{{ activeOrder.password }}</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-user text-primary"></i></td>
                                            <td><strong>{{ activeOrder.user.name }} |</strong> {{ activeOrder.created_at }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <h5 class="text-right">
                                    Деп <span class="badge badge-secondary"><strong>{{ activeOrder.deposit }}</strong></span> |
                                    Цена <span class="badge badge-secondary"><strong>{{ activeOrder.price }}</strong></span> |
                                    Тотал <span class="badge badge-secondary"><strong>{{ activeOrder.price - activeOrder.deposit }}</strong></span>
                                </h5>
                                <p class="text-right" id="btnMenu">
                                    <button v-show="activeOrder.status.id != 4" @click="showAddNote = true, showAddRepair = false, showNotes = false, showRepairsList = false" class="btn btn-sm btn-outline-secondary" data-toggle="tooltip" data-placement="top" title="Добави бележка"><i class="fas fa-plus"></i></button>
                                    <button :disabled="disabledNoteView" :class="disabledNoteView ? 'btn-outline-secondary' : 'btn-danger'" class="btn btn-sm" @click="showAddNote = false, showAddRepair = false, showNotes = true, showRepairsList = false">{{ notes.length }} Бележки</button>
                                    <strong v-show="activeOrder.status.id != 4"> | </strong>
                                    <button v-show="activeOrder.status.id != 4" @click="setStatus(activeOrder.id, 5)" class="btn btn-sm btn-outline-warning"><i class="fas fa-puzzle-piece" data-toggle="tooltip" data-placement="top" title="За части"></i></button>
                                    <button v-show="activeOrder.status.id != 4" @click="showRepairsList = false, showAddNote = false, showNotes = false, showAddRepair=true, newRepair.price = activeOrder.price" class="btn btn-sm btn-outline-success" data-toggle="tooltip" data-placement="top" title="Добави ремонт"><i class="fas fa-wrench"></i></button>
                                    <button v-show="activeOrder.status.id != 4" @click="setStatus(activeOrder.id, 3), addNewTask()" class="btn btn-sm btn-success"><i class="fas fa-thumbs-up" data-toggle="tooltip" data-placement="top" title="Приклучи поръчката"></i></button>
                                    <button v-show="activeOrder.status.id != 4" @click="setStatus(activeOrder.id, 4)" class="btn btn-sm btn-outline-info"><i class="fas fa-people-carry" data-toggle="tooltip" data-placement="top" title="Върни на клиемта"></i></button>
                                </p>
                            </div>
                            <div class="card-body">

                                <div class="col-12" v-if="showAddNote">
                                    <div class="col-12 mb-4">
                                        <button type="button" @click="showAddNote = false, showAddRepair = false, showNotes = false, showRepairsList = true" class="close" aria-label="Close">
                                            <span class="text-white" aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <h5 class="title">Добавяне на бележка</h5>
                                    <div class="form-group">
                                        <label for="note">Бележка</label>
                                        <textarea name="note" v-model="note" class="form-control" id="note" rows="5" required></textarea>
                                    </div>
                                    <div class="form-group text-right">
                                        <button class="btn btn-success" @click="saveNote()"><i class="fas fa-save"></i></button>
                                    </div>
                                </div>

                                <table class="w-100" v-if="showNotes">
                                    <div class="col-12 mb-4">
                                        <button type="button" @click="showAddNote = false, showAddRepair = false, showNotes = false, showRepairsList = true" class="close" aria-label="Close">
                                            <span class="text-white" aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <h5 class="title">Бележки</h5>
                                    <tbody>
                                        <tr v-for="note in this.notes" :key="note.id">
                                            <td class="border border-secondary p-3">
                                                <p>{{ note.note }}</p>
                                                <small class="float-right">{{ note.user.name }} | {{ note.created_at }}</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div v-if="showAddRepair">
                                    <div class="col-12 mb-4">
                                        <button type="button" @click="showAddNote = false, showAddRepair = false, showNotes = false, showRepairsList = true" class="close" aria-label="Close">
                                            <span class="text-white" aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <h5 class="title">Добавяне на ремонт</h5>
                                    <div class="col-12 form-group">
                                        <label for="repair">Ремонт</label>
                                        <input type="text" v-model="newRepair.repair" class="form-control" autocomplete="off" name="repair" id="repair" placeholder="Ремонт..." required>
                                    </div>
                                    <div class="col-12 form-group">
                                        <label for="description">Информация</label>
                                        <textarea class="form-control" v-model="newRepair.description" autocomplete="off" name="description" id="description"></textarea>
                                    </div>
                                    <div class="col-12 form-group">
                                        <label for="price">Цена</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control text-right" v-model="newRepair.price" autocomplete="off" name="price" id="price" placeholder="20...">
                                            <div class="input-group-text">лв.</div>
                                        </div>
                                    </div>
                                    <div class="col-12 form-group">
                                        <button class="btn btn-success float-right" @click="saveRepair(activeOrder.id)"><i class="fas fa-save"></i></button>
                                    </div>
                                </div>

                                <table class="w-100" v-if="showRepairsList">
                                    <h5 class="title">Ремонти</h5>
                                    <tbody>
                                        <tr v-for="repair in reverseRepair" :key="repair.id">
                                            <td class="border border-secondary p-3">
                                                <p>{{ repair.repair }}</p>
                                                <p>{{ repair.description }}</p>
                                                <small class="float-right">{{ repair.user.name }} | {{ repair.created_at }}</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
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
                statusClass: null,
                newOrder: [],
                activeOrder: [],
                repairs: [],
                newRepair: [],
                notes: [{
                    length: 0
                }],
                note: '',
                showProduct: false,
                showAddBtn: false,
                showOrder: false,
                showRepairsList: false,
                showAddRepair: false,
                showAddNote: false,
                showNotes: false,
                disabledNoteView: true,
            }
        },
        mounted() {
            this.getProduct()
        },
        watch: {
            '$route.params.product': function() {
                this.getProduct()
            }
        },
        computed: {
            reverceOrder: function() {
                return _.orderBy(this.product.orders, ['id'], ['desc'])
            },
            reverseRepair: function() {
                return _.orderBy(this.repairs, ['id'], ['desc'])
            }
        },
        methods: {
            addNewTask() {
                axios({
                    method: 'POST',
                    url: '/api/tasks',
                    data: {
                        title: this.activeOrder.id + ' Готов',
                        description: 'Готов'
                    }
                })
                .then(result => {
                    this.getProduct()
                })
                .catch(err => console.log(err))
            },
            getNotes() {
                Axios.get(`/notes/${this.activeOrder.id}/order`)
                .then(res => {
                    //console.log(res.data)
                    if(res.data.length) {
                        this.notes = res.data
                        this.disabledNoteView = false
                    } else {
                       this.notes.length = 0
                       this.disabledNoteView = true
                    }
                    //console.log(this.notes.length)
                })
                .catch(err => console.log(err))
            },
            saveNote() {
                Axios({
                    method: 'post',
                    url: '/notes',
                    data: {
                        note: this.note,
                        orderId: this.activeOrder.id
                    }
                })
                .then(res => {
                    this.getProduct()
                    this.showRepairsList = true
                    this.showAddNote = false
                })
            },
            saveRepair(id) {
               // this.newRepair.orderId = id
                Axios({
                    method: 'post',
                    url: '/repair',
                    data: {
                        repair: this.newRepair.repair,
                        orderId: id,
                        description: this.newRepair.description,
                        price: this.newRepair.price ? this.newRepair.price : 0
                    }
                })
                .then(res => {
                    this.newRepair = [];
                    this.showAddRepair = false;
                    this.getProduct();
                })
            },
            setStatus(id, status){
                Axios({
                    method: 'post',
                    url: '/order/status',
                    data: {
                        orderId: id,
                        productId: this.product.id,
                        status: status
                    }
                })
                .then(res => {
                    this.getProduct()
                })
            },
            lastStatusFnc() {
                if(this.product.orders[this.product.orders.length - 1].status.id == 4) {
                    this.showAddBtn = true
                } else {
                    this.showAddBtn = false
                }
            },
            saveNewOrder() {
                //console.log(this.newOrder)
                this.newOrder.productId = this.product.id
               //console.log(JSON.parse(JSON.stringify(this.newOrder)))
                Axios({
                    method: 'post',
                    url: '/order',
                    data: {
                        productId: this.newOrder.productId,
                        problem: this.newOrder.problem,
                        now: this.newOrder.now,
                        password: this.newOrder.password,
                        description: this.newOrder.description,
                        deposit: this.newOrder.deposit ? this.newOrder.deposit : 0,
                        price: this.newOrder.price ? this.newOrder.price : 0,
                    }
                })
                .then(res => {
                    //console.log(res.data)
                    this.activeOrder = res.data
                    //this.product.orders.push(res.data)
                    this.newOrder = []
                    this.getProduct()
                })
            },
            chageOrder(id) {
                this.product.orders.forEach(order => {
                    if(order.id == id) {
                        this.showOrder = true;
                        this.activeOrder = order
                        this.getRepirs(this.activeOrder.id);
                        this.setStatusClass(this.activeOrder.statusId)
                        this.getNotes()
                        this.showNotes = false
                    }
                });
            },
            setStatusClass(id) {
                switch(id) {
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
            },
            getProduct() {
                let productId = this.$route.params.product
                this.$refs.topProgress.start()

                Axios.get(`/product/show/${productId}`)
                .then((res) => {
                    if(res.data) {
                        this.product = res.data;
                        this.showProduct = true;

                        if(this.product.orders.length) {
                            this.lastStatusFnc();
                            this.setStatusClass(this.product.orders[this.product.orders.length - 1].statusId);
                            this.activeOrder = this.product.orders[this.product.orders.length - 1];
                            this.showOrder = true;
                            this.getRepirs(this.activeOrder.id);
                            this.getNotes();
                        }
                    } else {
                        this.showProduct = false;
                        console.log('nqma product');
                    }
                   // $('[data-toggle="tooltip"]').tooltip()
                    this.$refs.topProgress.done();
                })
            },
            getRepirs(orderId) {
                Axios.get(`/repair/${orderId}`)
                .then((res) => {
                    if(res.data.length) {
                        this.repairs = res.data;
                        this.showRepairsList = true
                    } else {
                        this.repairs = []
                        this.showRepairsList = false
                    }
                })
            }
        }
    }
</script>

<style>

</style>
