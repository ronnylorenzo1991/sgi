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
                                    <h2 class="mb-0">Salidas Informativas</h2>
                                </div>
                                <div class="col">
                                    <ul class="nav nav-pills justify-content-end">
                                        <li class="nav-item mr-2 mr-md-0">
                                            <a @click.prevent="openCreateEditReportModal" href="#"
                                               class="nav-link py-2 px-3 active">
                                                <span class="d-none d-md-block">+ Nueva Salida</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <simple-table reference="reportVueTable"
                                          :key="reportTableKey"
                                          ref="reportTable"
                                          :api-url="reportsUrl"
                                          :has-settings="false"
                                          :has-header="false"
                                          :fields="reportsFields"
                                          :per-page="5"
                                          paginationFontSize="small"
                                          :action-default-options="['export','edit', 'delete']"
                                          @edit="openCreateEditReportModal(...arguments)"
                                          @delete="deleteReport(...arguments)"
                                          @export="exportWord(...arguments)">
                            </simple-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal title="Añadir Salida Informativa"
               :show="showNewReportModal"
               @accept="saveReportData"
               @cancel="closeCreateReportModal"
               size="extraLarge">
            <div class="container">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group mb-3">
                            <label class="label-form" for="date">Número</label>
                            <div class="input-group input-group-merge input-group-alternative">
                                <input v-model="newReport.number" class="form-control" placeholder="Inserte Número"
                                       type="text">
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mb-3">
                            <label class="label-form" for="date">Fecha</label>
                            <div class="input-group input-group-merge input-group-alternative">
                                <input v-model="newReport.date" class="form-control" placeholder="Inserte Fecha"
                                       type="datetime-local" name="date">
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row pt-3">
                    <div class="col">
                        <h3 class="pt-3"> Incidentes </h3>
                    </div>
                    <div class="col" v-show="false">
                        <button class="btn btn-info  float-right">
                            <span class="d-none d-md-block">+ Agregar Incidente</span>
                        </button>
                    </div>
                </div>
                <div class="d-flex align-items-start flex-wrap">
                    <div v-for="(item, key) in newReport.todayData.events" class="card text-white bg-info m-2"
                         style="max-width: 18rem;">
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header bg-info m-0 p-0" id="headingOne">
                                    <h5 class="mb-0">
                                        <a class="btn btn-link text-white" data-toggle="collapse"
                                           :data-target="`#eventsCollapse${item.id}`" aria-expanded="true"
                                           :aria-controls="`eventsCollapse${item.id}`">
                                            <label class="m-0"
                                                   v-text="getElementLabel(item, 'events')"></label>
                                            <span class="btn-inner--icon p-2"><i
                                                class="ni ni-world-2"></i></span>
                                        </a>
                                        <button class="btn btn-icon btn-sm btn-2 btn-danger ml-auto mr-2 p-0"
                                                type="button"
                                                @click="removeElement(key, 'events')">
                                                <span class="btn-inner--icon"><i
                                                    class="ni ni-2x ni-fat-remove"></i></span>
                                        </button>
                                    </h5>
                                </div>
                                <div :id="`eventsCollapse${item.id}`" class="collapse" aria-labelledby="headingOne"
                                     data-parent="#accordion">
                                    <div class="card-body bg-info">
                                        <div>
                                            <small class="text-muted text-white mb-0">
                                                Número: {{ item.number }}
                                            </small>
                                        </div>
                                        <div>
                                            <small class="text-muted text-white mb-0">
                                                Categoría:
                                                {{ getListsValueById(item.category_id, 'categories').name || null }}
                                            </small>
                                        </div>
                                        <div>
                                            <small class="text-muted text-white mb-0">
                                                Subcategory:
                                                {{
                                                    getListsValueById(item.subcategory_id, 'subcategories').name || null
                                                }}
                                            </small>
                                        </div>
                                        <div>
                                            <small class="text-muted text-white mb-0">
                                                Entidad:
                                                {{ getListsValueById(item.detected_by_id, 'entities').name || null }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row pt-3">
                    <div class="col">
                        <h3 class="pt-3"> Disponibilidad de Sitios Web </h3>
                    </div>
                    <div class="col" v-show="false">
                        <button class="btn btn-info  float-right">
                            <span class="d-none d-md-block">+ Agregar Evento</span>
                        </button>
                    </div>
                </div>
                <div class="d-flex align-items-start flex-wrap">
                    <div v-for="(item, key) in newReport.todayData.availabilities" class="card text-white bg-info m-2"
                         style="max-width: 18rem;">
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header bg-info m-0 p-0" id="headingOne">
                                    <h5 class="mb-0">
                                        <a class="btn btn-link text-white" data-toggle="collapse"
                                           :data-target="`#availabilityCollapse${item.id}`" aria-expanded="true"
                                           :aria-controls="`availabilityCollapse${item.id}`">
                                            <label class="m-0"
                                                   v-text="getElementLabel(item, 'availabilities')"></label>
                                            <span class="btn-inner--icon p-2"><i
                                                class="ni ni-world-2"></i></span>
                                        </a>
                                        <button class="btn btn-icon btn-sm btn-2 btn-danger ml-auto mr-2 p-0"
                                                type="button"
                                                @click="removeElement(key, 'availabilities')">
                                                <span class="btn-inner--icon"><i
                                                    class="ni ni-2x ni-fat-remove"></i></span>
                                        </button>
                                    </h5>
                                </div>
                                <div :id="`availabilityCollapse${item.id}`" class="collapse"
                                     aria-labelledby="headingOne"
                                     data-parent="#accordion">
                                    <div class="card-body bg-info">
                                        <div>
                                            <small class="text-muted text-white mb-0">
                                                Sitio Web: {{ getListsValueById(item.site_id, 'sites').name || null }}
                                            </small>
                                        </div>
                                        <div>
                                            <small class="text-muted text-white mb-0">
                                                Disponibilidad: {{ item.availability }}
                                            </small>
                                        </div>
                                        <div>
                                            <small class="text-muted text-white mb-0">
                                                Descripción: {{ item.description }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row pt-3">
                    <div class="col">
                        <h3 class="pt-3"> Fuentes Publicas Informativas </h3>
                    </div>
                    <div class="col" v-show="false">
                        <button class="btn btn-info  float-right">
                            <span class="d-none d-md-block">+ Agregar Evento</span>
                        </button>
                    </div>
                </div>
                <div class="d-flex align-items-start flex-wrap">
                    <div v-for="(item, key) in newReport.todayData.news" class="card text-white bg-info m-2"
                         style="max-width: 18rem;">
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header bg-info m-0 p-0" id="headingOne">
                                    <h5 class="mb-0">
                                        <a class="btn btn-link text-white" data-toggle="collapse"
                                           :data-target="`#newsCollapse${item.id}`" aria-expanded="true"
                                           :aria-controls="`newsCollapse${item.id}`">
                                            <label class="m-0"
                                                   v-text="getElementLabel(item, 'news')"></label>
                                            <span class="btn-inner--icon p-2"><i
                                                class="ni ni-world-2"></i></span>
                                        </a>
                                        <button class="btn btn-icon btn-sm btn-2 btn-danger ml-auto mr-2 p-0"
                                                type="button"
                                                @click="removeElement(key, 'news')">
                                                <span class="btn-inner--icon"><i
                                                    class="ni ni-2x ni-fat-remove"></i></span>
                                        </button>
                                    </h5>
                                </div>
                                <div :id="`newsCollapse${item.id}`" class="collapse" aria-labelledby="headingOne"
                                     data-parent="#accordion">
                                    <div class="card-body bg-info">
                                        <div>
                                            <small class="text-muted text-white mb-0">
                                                Title: {{ item.title }}
                                            </small>
                                        </div>
                                        <div>
                                            <small class="text-muted text-white mb-0">
                                                url: {{ item.url }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
import Modal from '../../components/utils/modal'
import simpleTable from '../../components/utils/simpleTable/simpleTable'
import simpleTableSwitchField from '../../components/utils/simpleTable/simpleTableSwitchField'
import dialog from '../../libs/custom/dialog'
import Multi_select from '../../components/utils/multiselect'
import Vue from 'vue'

export default {
    name: 'Reports',
    components: {
        Modal,
        simpleTable,
        simpleTableSwitchField,
        Multi_select,
    },

    data() {
        return {
            isLoading: false,
            reportTableKey: 0,
            newReport: {
                number: null,
                date: null,
                todayData: {
                    events: [],
                    news: [],
                    availabilities: [],
                },
            },
            lists: {
                sites: [],
                categories: []
            },
            reportsFields: [
                {
                    name: 'date',
                    title: 'Fecha',
                    sortField: 'date',
                    titleClass: 'text-left',
                    dataClass: 'text-left',
                },
                {
                    name: 'number',
                    title: 'Número',
                    sortField: 'number',
                    titleClass: 'text-left',
                    dataClass: 'text-left',
                },
                {
                    name: 'actions-slot',
                    title: 'Actions',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                },
            ],
            showNewReportModal: false,
        }
    },

    computed: {
        reportsUrl() {
            return route('reports.all')
        },
    },

    watch: {},

    methods: {
        removeElement(key, type) {
            let newArray = []
            this.newReport.todayData[type].forEach(function (item, index) {
                if (key !== index) {
                    newArray.push(item)
                }
            })

            this.newReport.todayData[type] = newArray
        },

        getElementLabel(item, type) {
            let label = ''
            switch (type) {
                case 'events':
                    label = item.number
                    break
                case 'news':
                    label = item.title > 15 ? item.title.substring(0, 15) + '...' : item.title
                    break
                case 'availabilities':
                    label = this.getListsValueById(item.site_id, 'sites')?.name
            }

            return label
        },

        reloadTable(tableReference, vuetableReference) {
            this.$refs[tableReference].$refs[vuetableReference].reload()
        },

        resetReportData() {
            this.newReport = {
                number: null,
                date: null,
                todayData: {
                    events: [],
                    news: [],
                    availabilities: [],
                },
            }
        },

        closeCreateReportModal() {
            this.showNewReportModal = false
            this.resetReportData()

        },

        openCreateEditReportModal(reportData) {
            this.showNewReportModal = true
            if (reportData.id) {
                this.newReport.id = reportData.id
                this.newReport.number = reportData.number
                this.newReport.date = Vue.moment(reportData.date).format('YYYY-MM-DDThh:mm:ss')
                this.newReport.todayData.availabilities = reportData.availabilities
                this.newReport.todayData.events = reportData.events
                this.newReport.todayData.news = reportData.news

                return
            }
            this.getTodayData(['events', 'availabilities', 'news'])
        },

        getTodayData(models) {
            this.isLoading = true
            models.forEach(item => {
                let url = route(`${item}.today_data`)
                axios.get(url)
                    .then(response => {
                        this.newReport.todayData[item] = response.data
                        this.isLoading = false
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
            })
        },

        getListsValueById(id, element) {
            return this.lists[element]?.filter(item => item.id === id)[0]
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

        saveReportData() {
            this.isLoading = true
            let url = this.newReport.id ? route('reports.edit', this.newReport.id) : route('reports.create')
            axios.post(url, this.newReport)
                .then(response => {
                    if (response.status === 200) {
                        this.isLoading = false
                        dialog.success(response.data.message)
                        this.closeCreateReportModal()
                        this.reloadTable('reportTable', 'reportVueTable')
                        this.getLists(['sites', 'categories', 'subcategories', 'entities'])
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

        deleteReport(id) {
            this.$swal({
                icon: 'warning',
                title: 'Está seguro de que desea eliminar este usuario?',
                showCancelButton: true,
                confirmButtonText: `Eliminar`,
                cancelButtonText: `Cancelar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    this.isLoading = true
                    axios.delete(route('reports.remove', id))
                        .then(response => {
                            if (response.status === 200) {
                                this.isLoading = false
                                dialog.success(response.data.message)
                                this.reloadTable('reportTable', 'reportVueTable')
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

        exportWord(report) {
            window.open(route('reports.export_word', report.id), '_blank')
        },
    },

    created() {
    },

    mounted() {
        this.getLists(['sites', 'categories', 'subcategories', 'entities'])
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
