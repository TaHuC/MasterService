<template lang="">
    <div class="p-1 col-md-4 overflow-auto">
        <h4 v-show="loading" class="text-center">Зареждане...</h4>
        <div v-show="!loading">
            <h4 class="d-md-none">Бележки</h4>
            <div class="input-group input-group-sm mb-3">
                <input type="text" v-model="note" @keyup.enter="addNote()" class="form-control" placeholder="Бележка" aria-label="Recipient's username" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button :disabled="isDisabled" @click="addNote()" class="btn btn-outline-light"><i class="fa fa-plus"></i></button>
                </div>
            </div> 
            <ul class="list-group" v-show="notes[0]">
                <li class="list-group-item bg-secondary mb-1" v-for="item in notes" :key="item.id">
                    <p class="mb-1">{{ item.note }}</p>
                    <footer class="d-flex justify-content-between text-warning">
                        <p class=""><small>{{ item.user.name }}</small></p>
                        <p><small>{{ item.created_at }}</small></p>
                    </footer>
                </li>
            </ul>
            <h3 v-show="!notes[0]" class="text-center">Няма бележки</h3>
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
            notes: [],
            note: '',
            loading: true
        }
    },
    computed: {
        isDisabled() {
            if (this.note.length > 4) {
                return false
            } else {
                return true
            }
        }
    },
    methods: {
        addNote() {
            if (this.note.length > 4 && this.statusId != 4) {
                Axios.post('/notes', {
                    note: this.note,
                    orderId: this.orderId
                })
                .then((res) => {
                    // console.log(res.data)
                    if (res.data.id) {
                        this.getNotes()
                    }
                })
                .catch(err => console.log(err))
                this.note = ''
            } else {
                this.note = ''
            }
        },
        getNotes() {
            this.loading = true
            Axios.get(`/notes/${this.orderId}/order`) 
            .then((res) => {
                // console.log(res.data)
                this.notes = res.data.reverse()
                setTimeout(() => {
                    this.loading = false
                }, 200)
            })
            .catch(err => console.log(err))
        }
    },
    created() {
        this.getNotes()
    },
    watch: {
        orderId: function () {
            this.getNotes()
        }
    },
}
</script>
