<template>
    <div class="card bg-dark text-white border border-danger float-right mb-2 w-100">
        <div class="card-body">
            <div class="d-flex">
                <h6 class="card-title text-left mr-1" 
                :class="active ? '' : 'text-muted'" 
                style="cursor: pointer;"
                @click="active = true"
                >
                Задачи
                </h6>
                <h6 class="card-title text-left " 
                :class="active ? 'text-muted' : ''" 
                style="cursor: pointer;" 
                @click="active = false" 
                >
                Решения {{instantaneousOut.length}}
                </h6>
            </div>
            <div class="container" v-if="active">
                <router-link 
                v-for="instantly in instantaneous" 
                :key="instantly.id" 
                :style="{ backgroundColor: color.filter(col => col.user_id == instantly.user_id)[0].user_color }" 
                class="badge mr-1 badge-dark text-white" 
                :to="{name: 'viewProduct', params:{product: instantly.order.productId}}" 
                >
                {{instantly.order_id}}
                </router-link>
            </div>
            <div class="container" v-if="!active">
                <router-link v-for="(instantly, index) in instantaneousOut" :key="index" class="badge mr-1 text-white" :to="{name: 'viewProduct', params:{product: instantly.order.productId}}" >{{instantly.order_id}}</router-link>
            </div>
  
        </div> 
    </div>
</template>

<script>
    import axios from 'axios'
    
    export default {
        name: 'instantly',
        data() {
            return {
                instantlyId: 0,
                instantaneous: [],
                instantaneousOut: [],
                oldCount: 0,
                color: [],
                active: true
            }
        },
        created() {
            this.getUsersColors()
            this.getInstantaneos()
            this.getInstantlyOut()
            //this.getUserColor()
        },
        methods: {
            getUsersColors() {
                axios.get('/api/usersettings')
                .then(res => {this.color = res.data})
                .catch(err => console.log(err))
            },
            getInstantlyOut()
            {
                let count = 0;

            axios.get('/api/instantly/out')
                .then(res => {
                    this.instantaneousOut = res.data
                    for(let i = 0; i < res.data.length; i++) {
                        this.$awn.info(`${res.data[i].answer_user.name} е дал решение на твоята задача с N: ${res.data[i].order_id}`)
                    }

                })
                .catch(err => console.log(err.response))

                setInterval(() => {
                    axios.get('/api/instantly/out')
                    .then(res => {
                        if(this.instantaneousOut.length != res.data.length) {
                            this.instantaneousOut = res.data
                        }
                    })
                    .catch(err => console.log(err.response))
                }, 1000)

            },
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
                        this.getUsersColors()
                        axios.get('/api/instantly').then(res => {
                            if(this.oldCount != res.data.length) {
                                if(this.oldCount < res.data.length) {
                                    this.$awn.info("<strong>Има нова задача за решение</strong>")
                                } else {
                                    this.$awn.alert("Нови решения")
                                }

                                this.oldCount = res.data.length
                                this.instantaneous = res.data
                                
                                
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
