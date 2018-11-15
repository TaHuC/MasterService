<template>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Company name</a>
      
        <input class="form-control form-control-dark" type="text" v-model="text"  placeholder="Search" aria-label="Search">
        <div class="input-group-append" id="button-addon4">
            <button class="btn btn-outline-light" style="border-radius: 0%;" @click="emitSearch" type="button"><i class="fa fa-search"></i></button>
            <button class="btn btn-outline-light" style="border-radius: 0%;" type="button"><i class="fa fa-plus"></i></button>
        </div>
      <ul class="navbar-nav px-3"></ul>
      
    </nav>
</template>

<script>
    import results from './Results'

    export default {
       //props: ['order', 'clients'],
        name: 'navi',
        data() {
            return {
                text: '',
            }
        },
        methods: {
            emitSearch () {
                //console.log(results)
                results.methods.search(this.text)
            }
        }
    }
</script>

<style scoped>

</style>
