<template>
    <div>
        <form class="needs-validation" novalidate>
            <div class="form-row">
                <div class="col-6">
                    <label for="validationProblem">Проблем</label>
                    <input type="text" class="form-control" v-model="order.problem">
                    <div class="invalid-feedback">
                        Полето е задължително
                    </div>
                </div>
                <div class="col-6">
                    <label for="validationNow">Състояние</label>
                    <input type="text" class="form-control" v-model="order.now">
                    <div class="invalid-feedback">
                        Полето е задължително
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-6">
                    <label for="pass">Парола</label>
                    <input type="text" class="form-control pass" v-model="order.password">
                </div>
                <div class="col-6">
                    <label for="desc">Информация</label>
                    <input type="text" class="form-control desc" v-model="order.description">
                </div>
            </div>
            <div class="form-row">
                <div class="col-6">
                    <label for="price">Цена</label>
                    <input type="text" placeholder="0" class="form-control price text-right" v-model="order.price">
                </div>
                <div class="col-6">
                    <label for="depozit">Депозит</label>
                    <input type="text" placeholder="0" class="form-control depozit text-right" v-model="order.depozit">
                </div>
            </div>
            <div class="form-row d-flex p-2 justify-content-end">
                <button :disabled="isDisabled" @click.prevent="addNewOrder()" type="submit" class="btn btn-outline-success right"><i class="fa fa-plus"></i></button>
            </div>
        </form>
    </div>
</template>

<script>
import Axios from 'axios'

export default {
    props: {
        productId: Number,
        getProduct: Function
    },
    data() {
        return {
            order: []
        }
    },
    computed: {
        isDisabled() {
            if (this.order.problem && this.order.now) {
                return false
            } else {
                return true
            }
        }
    },
    methods: {
        addNewOrder() {
            if (this.order.problem && this.order.now && this.productId) {
                Axios.post('/order', {
                    productId: this.productId,
                    problem: this.order.problem,
                    now: this.order.now,
                    description: this.order.description,
                    deposit: this.order.depozit ? this.order.depozit : 0,
                    price: this.order.price ? this.order.price : 0,
                    password: this.order.password,
                })
                .then((res) => {
                    if (res.data.id) {
                        this.order = []
                        this.getProduct()
                    }
                })
                .catch(err => console.log(err))
            }
        }
    },
}
</script>

<style lang="">
    
</style>
