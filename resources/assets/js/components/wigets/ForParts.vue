<template>
    <div class="card bg-dark text-white border border-danger float-right mb-2 w-100">
        <div class="card-body">
            <h6 class="card-title">За части <span class="badge badge-light">{{ forParts.length }}</span></h6>
            
        </div>
        <div class="card-body">
            <router-link :to="{name: 'viewProduct', params:{product: device.productId}}" v-for="device in forParts" :key="device.id" class="badge badge-warning mr-1" :class="device.newProduct ? 'badge-danger' : 'badge-warning'">{{ device.id }}</router-link>
        </div>
    </div>
</template>

<script>
import Axios from 'axios'
import { setInterval } from 'timers';

export default {
    name: 'forParts',
    data() {
        return {
            forParts: [],
            newProduct: false
        }
    },
    watch: {
        newProduct(newVal, oldVal) {
            if(newVal == true) {
                setTimeout(function() {
                    this.getPartsOrder()
                    this.newProduct = false
                    console.log(this.newProduct)
                }, 10000)
            }
        }
    },
    created() {
        this.getPartsOrder()
    },
    methods: {
        getPartsOrder() {
            let oldCount = 0;
            Axios.get(`/order/params/statusId&5`).then(res => {
                oldCount = res.data.length
                this.forParts = res.data
                //console.log(res.data)

            })
            .catch(err => console.log(err.response))

            setInterval(() => {
               Axios.get(`/order/params/statusId&5`)
                .then(res => {
                    if(Number(oldCount) != res.data.length) {
                        if(Number(oldCount) > res.data.length) {
                            this.$awn.success("По-малко устройства за части")
                        } else {
                            this.$awn.warning("Има ново устройство за части")
                            res.data[0].newProduct = true
                            this.newProduct = true
                        }
                        oldCount = res.data.length
                        this.forParts = res.data
                    }
                })
                .catch(err => console.log(err.response))
            }, 3000)
        }
    }
}
</script>
    
<style lang="" scooped>
    
</style>
