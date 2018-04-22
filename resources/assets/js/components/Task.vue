<template>
<div class="row">
    <div id="floating-taskList" v-if="showTasksLs">
        <div class="card border-dark mb-3" style="width: 100%; height: 100%;">
            <div class="card-header d-flex">
                <div class="col-6 text-left">
                    Задачи
                    <button class="btn btn-sm btn-link" @click="hideTaskList">
                        <i class="fas fa-chevron-circle-down"></i>
                    </button>
                </div>
                <div class="col-6 text-right">
                    <button v-if="showActive == true" @click="getCompletedTask" class="btn btn-link text-primary btn-sm">
                        <small>Актив.</small>
                    </button>
                    <button v-else-if="showActive == false" @click="getAllTasks" class="btn btn-link text-primary btn-sm">
                        <small>Прикл.</small>
                    </button>
                    <button v-if="!showAdd" @click="showAdd=true" class="btn btn-link text-success btn-sm">
                        <i class="fas fa-plus-square"></i>
                    </button>
                </div>

            </div>
            <div class="card-body" v-if="showAdd">
                <div class="form-group col-12">
                    <input type="text" class="form-control-sm" v-model="task.title" placeholder="Enter task">
                </div>
                <div class="form-group col-12">
                    <textarea class="form-control-sm" v-model="task.description" placeholder="description"></textarea>
                </div>
                <div class="col-12 text-right">
                    <button @click="addNewTask" class="btn btn-outline-primary btn-sm">save</button>
                    <button class="btn btn-outline-warning btn-sm" @click="showAdd=false">close</button>
                </div>
            </div>
            <ul class="list-group list-group-flush bg-dark" id="tolltipsEnable" v-else style="overflow:auto;">
                <li class="list-group-item" v-for="(task, index) in tasks" v-b-tooltip.html :title="task.completed ? `<small>`+ task.user.name + ` на: ` +  task.updated_at +  ` Информация: ` + task.description +`</small>` : `<small>`+task.user.name + ` на: ` +  task.created_at +  ` Информация: ` + task.description + `</small>` ">
                    <input type="checkbox" :disabled="task.completed ? true : false" :checked="task.completed" class="" @click="complatedTask(task.id)">
                    <label class="form-check-label" :class="task.completed ? 'completedClass' : 'text-danger'">{{task.title}}</label>
                    <button type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
    <div v-else id="floating-buttonList">
        <button class="btn btn-outline-primary" @click="showTaskList">
            <i class="fas fa-chevron-circle-up"></i>
        </button>
    </div>
</div>
</template>

<script>
    // import axios from 'axios';

    export default {
        name: "tasks",
        data() {
            return {
                tasks: '',
                showAdd: false,
                showTasksLs: true,
                task: {
                    title: '',
                    description: ''
                },
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
                    this.tasks = results.data
                    
                })
                .catch(err => console.log(err))
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
                    this.task.title = '';
                    this.task.description = '';
                })
                .catch(err => console.log(err))
            },
            complatedTask(id) {
                axios.put(`/api/tasks/${id}`)
                .then(result => {

                })
                .catch(err => console.log(err));
                this.getAllTasks();
                $('#element').tooltip('enable')
            },
            getCompletedTask() {
                this.showActive = false;
                axios.get('/api/tasks/filter/completed')
                    .then(results => {
                        this.tasks = results.data
                    })
                    .catch(err => console.log(err))
            },
            showTaskList() {
                this.showTasksLs = true;
                this.getAllTasks();
            },
            hideTaskList() {
                this.showTasksLs = false;
            }
        }
    }
</script>

<style>
    #floating-taskList {
        font-family: sans-serif;
        opacity: 0.9;
        width: 300px;
        height: 250px;
        z-index: 100;
        position: fixed;
        bottom: 30px;
        right: 5px;
    }

    #floating-buttonList {
        font-family: sans-serif;
        opacity: 0.9;
        width: 50px;
        height: 50px;
        z-index: 100;
        position: fixed;
        bottom: 15px;
        right: 2px;
    }

    .completedClass {
        text-decoration: line-through;
        color: silver;
    }
</style>