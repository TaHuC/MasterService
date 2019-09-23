<template lang="">
    <div class="col-md-4 p-1 overflow-auto">
        <h4 v-show="loading" class="text-center">Зареждане...</h4>
            <div v-show="!loading">
            <h3 class="d-md-none">Ремонти</h3>
            <div class="input-group input-group-sm mb-3">
                <input type="text" v-model="repair" class="form-control" placeholder="Ремонт" aria-label="Recipient's username" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button @click="addRepair()" :disabled="isDisabled" class="btn btn-outline-light"><i class="fa fa-plus"></i></button>
                </div>
            </div> 
            <ul class="list-group">
                <li v-show="repairs[0]" class="list-group-item bg-secondary mb-1" v-for="item in repairs" :key="item.id">
                    <p class="lead">{{ item.repair }}</p>
                    <footer class="d-flex justify-content-between text-warning">
                        <p class=""><small>{{ item.user.name }}</small></p>
                        <p><small>{{ item.created_at }}</small></p>
                    </footer>
                </li>
                <h3 v-show="!repairs[0]" class="text-center">Няма ремонти</h3>
            </ul>
        </div>
    </div>
</template>

<script>
import Axios from 'axios'

export default {
    props: {
        orderId: Number,
        updateOrder: Function
    },
    data() {
        return {
            loading: true,
            repair: '',
            repairs: []
        }
    },
    computed: {
        isDisabled() {
            if (this.repair.length > 2) {
                return false
            } else {
                return true
            }
        }
    },
    methods: {
        testFunc() {
            Axios.post('/repair', {
                repair: 'Приет за ремонт',
                orderId: this.orderId
            })
            .then((res) => {
                if (res.data.id) {
                    this.getRepairs()
                }
            })
            .catch(err => console.log(err))
        },
        addRepair() {
            if (this.repair.length > 2) {
                Axios.post(`/repair`, {
                    repair: this.repair,
                    orderId: this.orderId
                }).then((res) => {
                    if (res.data.id) {
                        this.getRepairs()
                        this.updateOrder(this.orderId)
                    }
                }).catch(err => console.log(err))
            }
            this.repair = ''
        },
        getRepairs() {
            this.loading = true
            Axios.get(`/repair/${this.orderId}`)
            .then((res) => {
                // console.log(res.data)
                if (res.data.length > 0) {
                    this.repairs = res.data.reverse()
                }

                setTimeout (() => {
                    this.loading = false
                }, 500) 
            })
        }
    },
    created() {
        this.getRepairs()
    },
    watch: {
        orderId: function () {
            this.getRepairs()
        }
    },
}
</script>
