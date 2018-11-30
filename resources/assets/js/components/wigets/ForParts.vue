<template>
    <div class="card bg-dark text-white border border-danger float-right mb-2">
        <div class="card-body">
            <h6 class="card-title text-center">За части</h6>
            <router-link :to="{name: 'viewProduct', params:{product: device.id}}" v-for="device in forParts" :key="device.id" class="badge badge-warning mr-1">{{ device.id }}</router-link>
        </div>
    </div>
</template>

<script>
import Axios from 'axios'

export default {
    name: 'forParts',
    data() {
        return {
            forParts: []
        }
    },
    created() {
        this.getPartsOrder()
    },
    methods: {
        getPartsOrder() {
            Axios.get(`/order/params/statusId&5`)
            .then(res => {
                console.log(res.data)
                this.forParts = res.data
            })
            .catch(err => console.log(err.response))
        }
    }
}
</script>
    
<style lang="" scooped>
    
</style>
