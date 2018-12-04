<template>
<div class="card bg-dark text-white border border-danger float-right mb-2" style="width: 100%;">
    <div class="card-header">
        Задачи
        <div class="text-right w-100">
            <button class="btn btn-sm btn-outline-warning" @click="showActive = false, showAdd = true, showHistory = false" :disabled="showAdd ? true : false"><i class="fas fa-plus"></i></button>
            <button class="btn btn-sm btn-outline-info" @click="showActive = true, showAdd = false, showHistory = false" :disabled="showActive ? true : false"><i class="fas fa-check"></i> <span class="badge badge-light">{{ countTask }}</span></button>
            <button class="btn btn-sm btn-outline-info"><i class="fas fa-user"></i> <span class="badge badge-light">5</span></button>
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
                <div class="form-group text-right">
                    <button @click="addNewTask" class="btn btn-sm btn-outline-success"><i class="fas fa-save"></i></button>
                </div>
            </div>

            <table class="table table-hover table-dark" v-if="showActive">
                <tbody id="tolltipsEnable">
                    <tr v-for="(task, index) in tasks" :key="task.id">
                        <td>
                            <h5>{{ task.title }}</h5>
                            <p>{{ task.description }}</p>
                            <small>{{ task.user.name }}</small>
                        </td>
                        <td class="text-right" style="max-width: 45px;">
                            <button @click="complatedTask(task.id, index)" class="btn btn-sm btn-outline-light">
                            <i class="fas fa-check"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-hover table-dark" v-if="showHistory">
                <tbody id="tolltipsEnable">
                    <tr v-for="(task) in compTask" :key="task.id">
                        <td>
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

    export default {
        name: "tasks",
        data() {
            return {
                tasks: '',
                countTask: 0,
                showAdd: false,
                showTasksLs: false,
                showHistory: false,
                task: {
                    title: '',
                    description: ''
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
                axios.get('/api/tasks')
                    .then(results => {
                        // console.log(results.data)
                        this.tasks = results.data;
                        this.countTask = results.data.length;
                        this.task.title = '';
                        this.task.description = '';
                    })
                    .catch(err => console.log(err));

                    setInterval(() => {
                        axios.get('/api/tasks')
                        .then(res => {
                            if(this.countTask != res.data.length) {
                                this.tasks = res.data;
                                this.countTask = res.data.length;
                                this.task.title = '';
                                this.task.description = '';
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
                    this.showAdd = false;
                    this.showActive = true

                })
                .catch(err => console.log(err))
            },
            complatedTask(id, index) {
                axios.put(`/api/tasks/${id}`)
                .then(result => {

                })
                .catch(err => console.log(err));
                this.countTask--
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