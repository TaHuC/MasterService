<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h5>Потребителски настройки</h5>
                <small>Изберете си цвят с който ще се разпознавате от другите потребители</small>
            </div>
            <div class="card-body">
                <div class="col-4 border p-3">
                    <div class="form__field">
                        <div class="form__label">
                            <strong>Избери цвят:</strong>
                        </div>
                        <div class="form__input">
                            <swatches v-model="color" colors="text-advanced" popover-to="left"></swatches>
                        </div>
                    </div>
                    <div class="w-100 text-right">
                        <button class="btn btn-sm btn-outline-success" @click="saveSettings(user.user_settings.id)"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import Swatches from 'vue-swatches'

    export default {
        name: 'user_settings',
        components: { Swatches },
        data() {
            return {
                color: '#000000',
                user: null
            }
        },
        created() {
            //console.log(this.user)
            this.getUserInfo()
        },
        methods: {
            getUserInfo() 
            {
                axios.get('/users')
                .then(res => {
                    this.user = res.data[0]
                    this.color = res.data[1].user_color
                    })
                .catch(err => console.log(err.response))
            },
            saveSettings(id) 
            {
                axios({
                    method: 'PUT',
                    url: `/api/usersettings/${id}`,
                    data: {
                        user_color: this.color
                    }
                })
                .then(res => this.color = res.data)
                .catch(err => console.log(err.response))
            }
        }
    }
</script>

<style scoped lang="">
    
</style>
