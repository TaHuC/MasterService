<template>
<div class="card bg-dark text-white border border-danger float-right mb-2" style="width: 100%;">
    <div class="card-header">
        Задачи
        <div class="text-right w-100">
            <button class="btn btn-sm btn-outline-warning" @click="showActive = false, showPerosnal = true, showAdd = true, showHistory = false, showPerosnal = false" :disabled="showAdd ? true : false"><i class="fas fa-plus"></i></button>
            <button class="btn btn-sm btn-outline-info" @click="showActive = true, showAdd = false, showHistory = false, showPerosnal = false" :disabled="showActive ? true : false"><i class="fas fa-check"></i> <span class="badge badge-light">{{ countTask }}</span></button>
            <button class="btn btn-sm btn-outline-info" @click="showActive = false, showAdd = false, showHistory = false, showPerosnal = true" :disabled="showPerosnal ? true : false"><i class="fas fa-user"></i> <span class="badge badge-light">{{ countPersonalTask }}</span></button>
            <button class="btn btn-sm btn-outline-danger" @click="getCompletedTask" :disabled="showHistory ? true : false"><i class="fas fa-history"></i></button>
        </div>
    </div>
    <div class="card-body" style="max-height: 500px; overflow-y: auto">

        <div class="row">
            <div class="w-100" v-if="showAdd">
                <div class="form-group">
                    <label for="title">Задача</label>
                    <input type="text" id="title" class="form-control" v-model="task.title">
                </div>
                <div class="form-group">
                    <label for="description">Доп. информация</label>
                    <textarea name="" id="description" class="form-control" v-model="task.description" ></textarea>
                </div>
                <div class="custom-control custom-switch ml-3">
                    <input type="checkbox" v-model="task.personal" class="custom-control-input" id="personal">
                    <label class="custom-control-label" for="personal">Лична</label>
                </div>
                <div class="form-group text-right">
                    <button @click="addNewTask" class="btn btn-sm btn-outline-success"><i class="fas fa-save"></i></button>
                </div>
            </div>

            <table class="table table-hover table-dark" v-if="showActive">
                <tbody id="tolltipsEnable">
                    <tr v-for="(task, index) in tasks" :key="task.id">
                        <td v-if="!task.personal">
                            <h5>{{ task.title }}</h5>
                            <p>{{ task.description }}</p>
                            <small>{{ task.user.name }}</small>
                        </td>
                        <td v-if="!task.personal" class="text-right" style="max-width: 45px;">
                            <button @click="complatedTask(task.id, index)" class="btn btn-sm btn-outline-light">
                            <i class="fas fa-check"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-hover table-dark" v-if="showPerosnal">
                <tbody id="tolltipsEnable">
                    <tr v-for="(task, index) in tasks" :key="task.id">
                        <td v-if="task.personal && task.userId == user.id">
                            <h5>{{ task.title }}</h5>
                            <p>{{ task.description }}</p>
                            <small>{{ task.user.name }}</small>
                        </td>
                        <td v-if="task.personal && task.userId == user.id" class="text-right" style="max-width: 45px;">
                            <button @click="complatedTask(task.id, index)" class="btn btn-sm btn-outline-light">
                            <i class="fas fa-check"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-hover table-dark" v-if="showHistory">
                <tbody id="tolltipsEnable">
                    <tr v-for="task in compTask" :key="task.id">
                        <td v-if="!task.personal || task.userId == user.id">
                            <h5>{{ task.title }}</h5>
                            <p>{{ task.description }}</p>
                            <small>{{ task.user.name }}</small>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>
</template>

<script>
    import axios from 'axios';
    import { setInterval } from 'timers';
    import userSettings from './UserSettings'

    export default {
        name: "tasks",
        data() {
            return {
                tasks: '',
                user: '',
                countTask: 0,
                countPersonalTask: 0,
                showAdd: false,
                showTasksLs: false,
                showHistory: false,
                showPerosnal: false,
                task: {
                    title: '',
                    description: '',
                    personal: 0
                },
                compTask: '',
                showActive: true,
            }
        },
        created() {
            this.getAllTasks() 
        },
        methods: {
            getAllTasks() {
                this.showActive = true;
                axios.get('/users')
                .then(res => {
                    this.user = res.data[0]
                    axios.get('/api/tasks')
                    .then(results => {
                        this.tasks = results.data;
                        this.countTask = results.data.filter(data => data.personal != true).length;
                        this.countPersonalTask = results.data.filter(data => data.personal == true).filter(data => data.userId == this.user.id).length;
                    })
                    .catch(err => console.log(err));
                    })
                .catch(err => console.log(err.response))

                setInterval(() => {
                        axios.get('/api/tasks')
                        .then(res => {
                            let count = res.data.filter(task => task.personal == false).length
                            if((this.countTask + this.countPersonalTask) != (count + this.countPersonalTask)) {
                                this.tasks = res.data;
                                this.tasksCount = res.data.length
                                this.countTask = res.data.filter(data => data.personal != true).length;
                                this.countPersonalTask = res.data.filter(data => data.personal == true).filter(data => data.userId == this.user.id).length;
                                
                            }
                        })
                    }, 3000)

            },
            addNewTask() {
                axios({
                    method: 'POST',
                    url: '/api/tasks', 
                    json: true,
                    data: this.task
                })
                .then(result => {
                    //console.log(result.data);
                    this.getAllTasks();
                    this.task.title = '';
                    this.task.description = '';
                    this.task.personal = 0;
                    this.showAdd = false;
                    this.showPersonal = false;
                    this.showActive = true

                })
                .catch(err => console.log(err))
            },
            complatedTask(id, index) {
                let removeTask = this.tasks.filter(task => task.id == id)
                axios.put(`/api/tasks/${id}`)
                .then(result => {})
                .catch(err => console.log(err));
                if(removeTask[0].personal) {
                    this.countPersonalTask--
                } else {
                    this.countTask--
                }
                this.countComplTask++
                this.tasks.splice(index, 1)
            },
            getCompletedTask() {
                this.showActive = false;
                this.showHistory = true
                this.showAdd = false

                axios.get('/api/tasks/filter/completed')
                    .then(results => {
                        this.compTask = results.data
                    })
                    .catch(err => console.log(err))
            },
        }
    }
</script>

<style>
</style>