<template>
    <div>
        <div class="card bg-dark text-white mb-3" style="width: 25rem">
            <div v-if="loading"><h3>Зараждане</h3></div>
            <div v-if="!loading" class="card-body">
                <h5 class="card-title">Настройки</h5>
                <div class="form-group">
                    <label for="company">Име на фирмата</label>
                    <input id="compnay" type="text" class="form-control"  v-model="settings.companyName">
                </div>
                <hr class="bg-light">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" v-model="settings.noReg" id="no_reg">
                    <label class="form-check-label" for="no_reg">Без регистация</label>
                </div>
                <hr class="bg-light">
                <div class="form-group text-right">
                    <input type="hidden" name="_method" value="put">
                    <button type="button" @click="saveSettings()" class="btn btn-outline-light">
                        <i class="material-icons">save</i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Axios from 'axios'

export default {
    data() {
        return {
            loading: true,
           settings: {
               companyName: '',
               noReg: 0
           } 
        }
    },
    methods: {
        getSetings() {
            this.loading = true
            Axios.get('/settings')
            .then((res) => {
                // console.log(res.data)
                this.settings.noReg = res.data[0].no_reg
                this.settings.companyName = res.data[0].company_name
                this.loading = false
            })
            .catch(err => console.log(err))
        },
        saveSettings() {
            this.loading = true
            Axios.put('/settings', {
                no_reg: this.settings.noReg,
                company_name: this.settings.companyName
            })
            .then(() => {
                this.loading = false
            })
            .catch(err => console.log(err))

            
        }
    },
    mounted() {
        this.getSetings()
    },
}
</script>
