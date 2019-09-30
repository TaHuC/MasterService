<template lang="">
    <div class="p-1 col-md-4 overflow-auto">
        <h4 v-show="loading" class="text-center">Зареждане...</h4>
        <div class="" v-show="!loading">
            <h3 class="d-md-none">Задачи</h3>
            <div class="input-group input-group-sm mb-3">
                <input v-model="task" type="text" @keyup.enter="addTask()" class="form-control" placeholder="Задача" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button :disabled="isDisabledAdd" @click="addTask()" class="btn btn-outline-light"><i class="fa fa-plus"></i></button>
                </div>
            </div> 
            <ul class="list-group">
                <li class="list-group-item bg-secondary mb-1" v-show="tasks[0]" v-for="item in tasks" :key="item.id">
                    <strong class="">{{ item.quest }}</strong>
                    <footer class="d-flex justify-content-between text-warning">
                        <p class=""><small>{{ item.user.name }}</small></p>
                        <p><small>{{ item.created_at }}</small></p>
                    </footer>
                    <hr class="bg-danger">
                    <!-- form -->
                    <div v-if="!item.answer_user_id" class="input-group input-group-sm">
                        <input type="text" @keyup.enter="addAnswer(item.id)" v-model="answer" class="form-control" placeholder="Решение" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button :disabled="isDisabledAnswer" @click="addAnswer(item.id)" class="btn btn-outline-light"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>  
                    <!-- answer -->
                    <div v-else>
                        <button v-show="item.active" @click="disableTask(item.id)" class="close"><i class="fa fa-check"></i></button>
                        <p>
                            {{ item.answer }}
                        </p>
                    <footer class="d-flex justify-content-between text-warning">
                        <p class=""><small>{{ item.answer_user.name }}</small></p>
                        <p><small>{{ item.answerTime }}</small></p>
                    </footer>
                    </div>
                </li>
                <h3 v-show="!tasks[0]" class="text-center">Няма задачи</h3>
            </ul>
        </div>
    </div>
</template>

<script>
import Axios from 'axios'

export default {
    props: {
        orderId: Number,
        statusId: Number
    },
    data() {
        return {
            loading: true,
            tasks: [],
            task: '',
            answer: ''
        }
    },
    computed: {
        isDisabledAdd() {
            if (this.task.length > 2 && this.tasks[0].answer_user_id) {
                return false
            } else {
                return true
            }
        },
        isDisabledAnswer() {
            if (this.answer.length > 2) {
                return false
            } else {
                return true
            }
        }
    },
    methods: {
        disableTask(id) {
            Axios.put(`/api/instantly/${id}`)
                .then((res) => {
                    if (res.data.id) {
                        this.getTasks()
                    }
                })
                .catch(err => console.log(err))
        },
        getTasks() {
            this.loading = true
            Axios.get(`/api/instantly/${this.orderId}`)
            .then((res) => {
                this.tasks = res.data
                setTimeout(() => {
                    this.loading = false
                }, 200)
            })
            .catch(err => console.log(err))
        },
        addTask() {
            if (this.task.length > 2) {
                Axios.post('/api/instantly', {
                    quest: this.task,
                    order_id: this.orderId
                })
                .then((res) => {
                    if (res.data.id) {
                        this.getTasks()
                    }
                })
                .catch(err => console.log(err))
                this.task = ''
            }
        },
        addAnswer(id) {
            if (this.answer.length > 2) {
                Axios.put(`/api/instantly/${id}`, {
                    answer: this.answer
                })
                .then((res) => {
                    if (res.data.id) {
                        this.getTasks()
                    }
                })
                .catch(err => console.log(err))
                this.answer = ''
            }
        }
    },
    created() {
        this.getTasks()
    },
    watch: {
        orderId: function () {
            this.getTasks()
        }
    },
}
</script>
