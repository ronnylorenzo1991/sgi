<template>
    <div>
        <modal title="Añadir Sitio Web"
               :show="showModal"
               @accept="save"
               @cancel="closeModal">
            <div class="container">
                <div class="form-group mb-3">
                    <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                        </div>
                        <input v-model="newItem.name" class="form-control" placeholder="Inserte Nombre"
                               type="text">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                        </div>
                        <textarea v-model="newItem.description" class="form-control" placeholder="Inserte Descripción"/>
                    </div>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
import Modal from '../../../components/utils/modal'
import dialog from '../../../libs/custom/dialog'

export default {
    name: 'modalContributes',
    components: {Modal},

    props: {
        item: {
            default: {},
        },
        lists: {}
    },
    data() {
        return {
            newItem: {},
            showModal: false,
            editUrl: 'contributes.edit',
            createUrl: 'contributes.create',
        }
    },

    watch: {
        showModal(value) {
            if (value) {
                this.newItem = this.item
            }
        }
    },

    methods: {
        save() {
            this.$emit('isLoading', true)
            let url = this.newItem.id ? route(this.editUrl, this.newItem.id) : route(this.createUrl)
            axios.post(url, this.newItem)
                .then(response => {
                    if (response.status === 200) {
                        dialog.success(response.data.message)
                        this.closeModal()
                        this.$emit('isLoading', false)
                        this.$emit('savedComplete')
                    } else {
                        dialog.error()
                    }
                }).catch(error => {
                this.$emit('isLoading', false)
                if (!error.response) {
                    // network error
                    this.errorStatus = 'Error: Problemas de Conexión'
                    dialog.error(this.errorStatus)
                } else {
                    this.errorStatus = error.response.data.message
                    dialog.error(this.errorStatus, error.response.data.errors)
                }
            })
        },
        closeModal() {
            this.showModal = false
            this.$emit('savedComplete')
        },
    },
}
</script>

<style scoped>

</style>
