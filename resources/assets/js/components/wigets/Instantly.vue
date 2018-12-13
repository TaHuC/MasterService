<template>
    <div class="card bg-dark text-white border border-danger float-right mb-2 w-100">
        <div class="card-body">
            <h6 class="card-title">За решения</h6>
        
            <router-link v-for="instantly in instantaneous" :key="instantly.id" class="badge mr-1 text-white" :style="{'background-color': color}" :to="{name: 'viewProduct', params:{product: instantly.order.productId}}" >{{instantly.order_id}}</router-link>
        </div> 
    </div>
</template>

<script>
    //import axios from 'axios'
    
    export default {
        name: 'instantly',
        data() {
            return {
                instantaneous: [],
                oldCount: 0,
                color: '#cccccc'
            }
        },
        created() {
            this.getInstantaneos()
            this.getUserColor()
        },
        methods: {
            getUserColor() 
            {
                setInterval(() => {
                    axios.get('/users')
                    .then(res => {
                        this.color = res.data[1].user_color
                        })
                    .catch(err => console.log(err.response))
                }, 1000)
                
            },
            getInstantaneos() {
                axios({
                    method: 'GET',
                    url: '/api/instantly'
                })
                .then(res => {
                    this.oldCount = res.data.length
                    this.instantaneous = res.data
                    setInterval(() => {
                        axios.get('/api/instantly').then(res => {
                            if(this.oldCount != res.data.length) {
                                this.oldCount = res.data.length
                                this.instantaneous = res.data
                                if(this.oldCount < res.data.length) {
                                    this.$awn.info("Излезнало решение")
                                } else {
                                    this.$awn.alert("Нови решения")
                                }
                                //console.log(this.instantaneous)
                            }
                        })
                    }, 3000)
                })
                .catch(err => console.log(err.response))
            }
        }
    }
</script>

<style scoped>

</style>
