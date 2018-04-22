<template>
    <div id="floating-taskList" class="row">
        <div class="card border-dark mb-3" style="width: 100%; height: 100%;">
            <div class="card-header text-right">
                 Task List
                <div class="row">
                    <button class="btn btn-sm btn-link">All</button>
                    <button class="btn btn-sm btn-link">Complate</button>
                    <button class="btn btn-sm btn-link">Active</button>
                </div>
                
            </div>
            <ul class="list-group list-group-flush" style="overflow:auto;">
                <li class="list-group-item">
                    <input type="checkbox" class="" name="" id="">
                    <label for="" class="form-check-label text-danger">Cras justo odio</label>
                    <button type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        
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
</style>
