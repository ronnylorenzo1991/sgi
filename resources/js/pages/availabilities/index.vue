<template>
    <div>
        <loader :show="isLoading"/>
        <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
            <div class="container-fluid">
                <div class="header-body">
                </div>
            </div>
        </div>
        <div class="container-fluid mt--6">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="mb-0">Disponibilidad</h2>
                                </div>
                                <div class="col">
                                    <ul class="nav nav-pills justify-content-end">
                                        <li class="nav-item mr-2 mr-md-0" v-if="can('availabilities.availabilities.create')">
                                            <a @click.prevent="openCreateEditAvailabilityModal" href="#"
                                               class="nav-link py-2 px-3 active">
                                                <span class="d-none d-md-block">+ Nueva Disponibilidad</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <simple-table reference="availabilityVueTable"
                                          :key="availabilityTableKey"
                                          ref="availabilityTable"
                                          :api-url="availabilitiesUrl"
                                          :has-settings="false"
                                          :has-header="false"
                                          :fields="availabilitiesFields"
                                          :per-page="5"
                                          paginationFontSize="small"
                                          :hasCustomActions="false"
                                          :action-default-options="['edit', 'delete']"
                                          :can-edit="can('availabilities.availabilities.edit')"
                                          :can-delete="can('availabilities.availabilities.delete')"
                                          @edit="openCreateEditAvailabilityModal(...arguments)"
                                          @delete="deleteAvailability(...arguments)">
                            </simple-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal title="Añadir Disponibilidad"
               :show="showNewAvailabilityModal"
               @accept="saveAvailabilityData"
               @cancel="closeCreateAvailabilityModal">
            <div class="container">
                <div class="form-group">
                    <div class="input-group input-group-merge input-group-alternative">
                        <multi_select v-model="newAvailability.site_id" :options="lists.sites"
                                      label="name" track-by="id" placeholder="Seleccione el Sitio Web"></multi_select>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-bars"></i></span>
                        </div>
                        <input v-model="newAvailability.description" class="form-control"
                               placeholder="Inserte Descripción"
                               type="text">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-percent"></i></span>
                        </div>
                        <input v-model="newAvailability.availability" class="form-control"
                               placeholder="Inserte Disponibilidad"
                               type="text">
                    </div>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
import simpleTable from '../../components/utils/simpleTable/simpleTable'
import simpleTableSwitchField from '../../components/utils/simpleTable/simpleTableSwitchField'
import VueMoment from 'vue-moment'
import moment from 'moment-timezone'
import Vue from 'vue'
import dialog from '../../libs/custom/dialog'
import Modal from '../../components/utils/modal'

Vue.use(VueMoment, {
    moment,
})

export default {
    name: 'Availabilities',
    components: {
        Modal,
        simpleTable,
        simpleTableSwitchField,
    },

    data() {
        return {
            isLoading: false,
            availabilityTableKey: 0,
            newAvailability: {
                site_id: null,
                description: null,
                availability: null,
            },
            showNewAvailabilityModal: false,
            lists: {
                sites: [],
            },
            availabilitiesFields: [
                {
                    name: 'created_at',
                    title: 'Fecha',
                    sortField: 'created_at',
                    titleClass: 'text-left',
                    dataClass: 'text-left',
                    formatter: (value) => {
                        return Vue.moment(value).format('YYYY-MM-DDThh:mm:ss')
                    }
                },
                {
                    name: 'site_id',
                    title: 'Sitio',
                    sortField: 'availability_id',
                    titleClass: 'text-left',
                    dataClass: 'text-left',
                    formatter: (value) => {
                        return this.getListsValueById(value, 'sites')?.name
                    }
                },
                {
                    name: 'description',
                    title: 'Descripción',
                    sortField: 'description',
                    titleClass: 'text-left',
                    dataClass: 'text-left',
                },
                {
                    name: 'availability',
                    title: 'Disponibilidad',
                    sortField: 'availability',
                    titleClass: 'text-left',
                    dataClass: 'text-left',
                },
                {
                    name: "actions-slot",
                    title: 'Actions',
                    titleClass: "text-center",
                    dataClass: "text-center",
                },
            ],
        }
    },

    computed: {
        availabilitiesUrl() {
            return route('availabilities.all')
        },
    },

    watch: {},

    methods: {
        getModelName(string) {
            let parts = string.split('\\')
            return parts[parts.length - 1]
        },

        reloadTable(tableReference, vuetableReference) {
            this.$refs[tableReference].$refs[vuetableReference].reload()
        },

        getLists(list) {
            let url = route('defaults.lists')
            axios.get(url, {params: {lists: JSON.stringify(list)}})
                .then(response => {
                    if (response.status === 200) {
                        this.lists = response.data.lists
                    } else {
                        dialog.error(response.data.message)
                    }
                }).catch(error => {
                this.isLoading = false
                if (!error.response) {
                    // network error
                    this.errorStatus = 'Error: Problemas de Conexión'
                    dialog.error(this.errorStatus)
                } else {
                    this.errorStatus = error.response.data.message
                    dialog.error(this.errorStatus)
                }
            })
        },

        getListsValueById(id, element) {
            return this.lists[element]?.filter(item => item.id === id)[0]
        },

        resetAvailabilityData() {
            this.newAvailability = {
                site_id: null,
                description: null,
                availability: null,
            }
        },

        closeCreateAvailabilityModal() {
            this.showNewAvailabilityModal = false
            this.resetAvailabilityData()
        },

        openCreateEditAvailabilityModal(availabilityData) {
            if (availabilityData.id) {
                this.newAvailability.id = availabilityData.id
                this.newAvailability.site_id = availabilityData.site_id
                this.newAvailability.description = availabilityData.description
                this.newAvailability.availability = availabilityData.availability
            }
            this.showNewAvailabilityModal = true
        },

        saveAvailabilityData() {
            this.isLoading = true
            let url = this.newAvailability.id ? route('availabilities.edit', this.newAvailability.id) : route('availabilities.create')
            axios.post(url, this.newAvailability)
                .then(response => {
                    if (response.status === 200) {
                        this.isLoading = false
                        dialog.success(response.data.message)
                        this.closeCreateAvailabilityModal()
                        this.reloadTable('availabilityTable', 'availabilityVueTable')
                        this.getLists(['sites'])
                    } else {
                        console.log(response.data)
                        dialog.error()
                    }
                }).catch(error => {
                this.isLoading = false
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

        deleteAvailability(id) {
            this.$swal({
                icon: 'warning',
                title: 'Está seguro de que desea eliminar este usuario?',
                showCancelButton: true,
                confirmButtonText: `Eliminar`,
                cancelButtonText: `Cancelar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    this.isLoading = true
                    axios.delete(route('availabilities.remove', id))
                        .then(response => {
                            if (response.status === 200) {
                                this.isLoading = false
                                dialog.success(response.data.message)
                                this.reloadTable('availabilityTable', 'availabilityVueTable')
                            } else {
                                this.isLoading = false
                                dialog.error()
                            }
                        }).catch(error => {
                        this.isLoading = false
                        if (!error.response) {
                            // network error
                            this.errorStatus = 'Error: Problemas de Conexión'
                            dialog.error(this.errorStatus)
                        } else {
                            this.errorStatus = error.response.data.message
                            dialog.error(this.errorStatus)
                        }
                    })
                }
            })
        },
    },

    created() {
    },

    mounted() {
        this.getLists(['sites'])
    }
}
</script>

<style scoped>
.is_disabled {
    pointer-events: none;
    cursor: default;
    opacity: 0.3;
}
</style>
