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
                                    <h2 class="mb-0">Incidentes</h2>
                                </div>
                                <div class="col">
                                    <ul class="nav nav-pills justify-content-end">
                                        <li class="nav-item mr-2 mr-md-0">
                                            <a @click.prevent="exportExcel" href="#"
                                               class="nav-link py-2 px-3">
                                                <span class="d-none d-md-block"><i class="fa fa-file-excel pr-2"></i>exportar excel</span>
                                            </a>
                                        </li>
                                        <li class="nav-item mr-2 mr-md-0" v-if="can('events.events.create')">
                                            <a @click.prevent="openCreateEditEventModal" href="#"
                                               class="nav-link py-2 px-3 active">
                                                <span class="d-none d-md-block">+ Nuevo Incidente </span>
                                            </a>
                                        </li>
                                        <li class="nav-item mr-2 mr-md-0">
                                            <button class="btn small btn-primary" type="button" data-toggle="collapse"
                                                    data-target="#filtersRow" aria-expanded="false"
                                                    aria-controls="filtersRow">
                                                <i class="fa fa-filter"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- filters -->
                            <div class="collapse" id="filtersRow">
                                <div class="row">
                                    <div class="col-12 pt-5">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group mb-3">
                                                    <label class="label-form" for="date">Fecha</label>
                                                    <date-range-picker v-model="filters.dateRange">
                                                    </date-range-picker>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label for="number">Número</label>
                                                    <div class="input-group input-group-merge input-group-alternative">
                                                        <input v-model="filters.number" class="form-control"
                                                               placeholder="Buscar Número"
                                                               type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label class="label-form" for="date">Categoría</label>
                                                    <div class="input-group input-group-merge input-group-alternative">
                                                        <multi_select v-model="filters.category_id"
                                                                      :options="lists.categories"
                                                                      label="name" track-by="id"
                                                                      placeholder="Buscar la Categoría"></multi_select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label class="label-form" for="date">Subcategoría</label>
                                                    <div class="input-group input-group-merge input-group-alternative">
                                                        <multi_select v-model="filters.subcategory_id"
                                                                      :options="filters.subcategoriesBycategory"
                                                                      label="name" track-by="id"
                                                                      placeholder="Buscar la subcategoría"></multi_select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label class="label-form" for="date">Detectado Por</label>
                                                    <div class="input-group input-group-merge input-group-alternative">
                                                        <multi_select v-model="filters.detected_by_id"
                                                                      :options="lists.sources"
                                                                      label="name" track-by="id"
                                                                      placeholder="Buscar fuente de deteccion"></multi_select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label class="label-form" for="date">Tributa</label>
                                                    <div class="input-group input-group-merge input-group-alternative">
                                                        <multi_select v-model="filters.contribute_id"
                                                                      :options="lists.contributes"
                                                                      label="name" track-by="id"
                                                                      placeholder="Buscar fuente de deteccion"></multi_select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center pt-3 pb-2">
                                        <button class="btn btn-primary" @click="applyFiltersAndFetchData">Aplicar
                                        </button>
                                        <button class="btn btn-secondary" @click="clearFilters">Limpiar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <simple-table reference="eventVueTable"
                                          :key="eventTableKey"
                                          ref="eventTable"
                                          :api-url="eventsUrl"
                                          :has-settings="false"
                                          :has-header="false"
                                          :fields="eventsFields"
                                          :per-page="5"
                                          paginationFontSize="small"
                                          :hasCustomActions="true">
                                <template slot="custom-actions" slot-scope="props">
                                    <button type="button" class="btn btn-secondary btn-icon-only rounded-circle"
                                            @click="openCreateEditEventModal(props.props.rowData)" v-if="can('events.events.edit')">
                                        <span class="btn-inner--icon"><i class="fa fa-edit"></i></span>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-icon-only rounded-circle" v-if="can('events.events.delete')"
                                            @click="deleteEvent(props.props.rowData.id)">
                                        <span class="btn-inner--icon"><i class="fa fa-trash"></i></span>
                                    </button>
                                </template>
                            </simple-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal title="Añadir Evento"
               :show="showNewEventModal"
               @accept="saveEventData"
               @cancel="closeCreateEventModal"
               size="extraLarge">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label class="label-form" for="date">Fecha</label>
                            <div class="input-group input-group-merge input-group-alternative">
                                <input v-model="newEvent.date" class="form-control" placeholder="Inserte Fecha"
                                       type="datetime-local" name="date">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="number">Número</label>
                            <div class="input-group input-group-merge input-group-alternative">
                                <input v-model="newEvent.number" class="form-control"
                                       placeholder="Inserte Número de Incidente"
                                       type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="label-form" for="date">Categoría</label>
                            <div class="input-group input-group-merge input-group-alternative">
                                <multi_select v-model="newEvent.category_id" :options="lists.categories"
                                              label="name" track-by="id"
                                              placeholder="Seleccione la Categoría"></multi_select>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="label-form" for="date">Subcategoría</label>
                            <div class="input-group input-group-merge input-group-alternative">
                                <multi_select v-model="newEvent.subcategory_id" :options="subcategoriesBycategory"
                                              label="name" track-by="id"
                                              placeholder="Seleccione la subcategoría"></multi_select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="label-form" for="date">Observaciones</label>
                            <div class="input-group input-group-merge input-group-alternative">
                                <textarea v-model="newEvent.observations" class="form-control"
                                          placeholder="Observaciones"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="label-form" for="date">Detectado Por</label>
                            <div class="input-group input-group-merge input-group-alternative">
                                <multi_select v-model="newEvent.detected_by_id" :options="lists.sources"
                                              label="name" track-by="id"
                                              placeholder="Seleccione fuente de deteccion"></multi_select>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="label-form" for="date">Tributa</label>
                            <div class="input-group input-group-merge input-group-alternative">
                                <multi_select v-model="newEvent.contribute_id" :options="lists.contributes"
                                              label="name" track-by="id"
                                              placeholder="Seleccione fuente de deteccion"></multi_select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-1">
                        <label class="custom-toggle">
                            <input type="checkbox" v-model="newEvent.national_as_source">
                            <span class="custom-toggle-slider rounded-circle"></span>
                        </label>
                    </div>
                    <div class="col-11 pl-0">
                        <p class="label-form" style="font-size: 14px; color: #525f7f !important">Las Direcciones
                            Nacionales son el origen del Incidente</p>
                    </div>
                </div>
            </div>
            <hr>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="national-tab" data-toggle="tab" href="#national" role="tab"
                       aria-controls="national" aria-selected="true">Insertar Ips Nacionales</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="foreing-tab" data-toggle="tab" href="#foreing" role="tab"
                       aria-controls="foreing" aria-selected="false">Insertar Ips Extranjeras</a>
                </li>
            </ul>
            <div class="tab-content" id="IpTabs">
                <div class="tab-pane fade show active" id="national" role="tabpanel" aria-labelledby="national-tab"
                     style="background-color: currentColor!important;">
                    <div>
                        <div class="custom-control custom-radio mb-3 pt-3">
                            <div class="row">
                                <div class="col-4">
                                    <p class="label-form" style="font-size: 14px; color: #525f7f !important">Entidad</p>
                                    <multi_select v-model="newNationalNode.entity_id" :options="lists.entities"
                                                  label="name" track-by="id"
                                                  placeholder="Seleccione"></multi_select>
                                </div>
                                <div class="col-4">
                                    <p class="label-form" style="font-size: 14px; color: #525f7f !important">
                                        Ministerio</p>
                                    <multi_select v-model="newNationalNode.ministry_id" :options="lists.ministries"
                                                  label="name" track-by="id"
                                                  placeholder="Seleccione"></multi_select>
                                </div>
                                <div class="col-4">
                                    <p class="label-form" style="font-size: 14px; color: #525f7f !important">Enlace</p>
                                    <multi_select v-model="newNationalNode.internet_link_id"
                                                  :options="lists.internet_links"
                                                  label="name" track-by="id"
                                                  placeholder="Seleccione"></multi_select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 input-group pt-4">
                                <textarea v-model="newNationalNode.ips" class="form-control"
                                          placeholder="Inserte Ip o grupo de Ips (Separadas por Coma)"/>
                                </div>
                            </div>
                        </div>
                        <div class="nav justify-content-end">
                            <button type="button" class="btn btn-sm btn-icon btn-success"
                                    data-toggle="collapse"
                                    data-target="#collapseNationals"
                                    aria-expanded="false"
                                    aria-controls="collapseNationals"
                                    @click="addNationalIps">
                                <span class="btn-inner--icon"><i class="ni ni-check-bold"></i></span>Añadir
                            </button>
                        </div>
                    </div>
                    <div class="d-flex align-items-start flex-wrap">
                        <div v-for="(item, key) in newEvent.national_nodes" class="card text-white bg-info m-2"
                             style="max-width: 18rem;">
                            <div id="accordion">
                                <div class="card">
                                    <div class="card-header bg-info m-0 p-0" id="headingOne">
                                        <h5 class="mb-0">
                                            <a class="btn btn-link text-white" data-toggle="collapse"
                                               :data-target="`#collapseOne${item.id}`" aria-expanded="true"
                                               :aria-controls="`collapseOne${item.id}`">
                                                <label class="m-0"
                                                       v-text="getAddedIpLabel(item)"></label>
                                                <span class="btn-inner--icon p-2"><i
                                                    class="ni ni-world-2"></i></span>
                                            </a>
                                            <button class="btn btn-icon btn-sm btn-2 btn-danger ml-auto mr-2 p-0"
                                                    type="button"
                                                    @click="removeNationalIps(key)">
                                                <span class="btn-inner--icon"><i
                                                    class="ni ni-2x ni-fat-remove"></i></span>
                                            </button>
                                        </h5>
                                    </div>
                                    <div :id="`collapseOne${item.id}`" class="collapse" aria-labelledby="headingOne"
                                         data-parent="#accordion">
                                        <div class="card-body bg-info">
                                            <div>
                                                <small class="text-muted text-white mb-0">
                                                    IPs: {{ getAddedIpLabel(item, true) }}
                                                </small>
                                            </div>
                                            <div>
                                                <small class="text-muted text-white mb-0">
                                                    Ministerio: {{ getAddedMinistryLabel(item) }}
                                                </small>
                                            </div>
                                            <div>
                                                <small class="text-muted text-white mb-0">
                                                    Entidad: {{ getAddedEntityLabel(item) }}
                                                </small>
                                            </div>
                                            <div>
                                                <small class="text-muted text-white mb-0">
                                                    Enlace: {{ getAddedInternetLinkLabel(item) }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="foreing" role="tabpanel" aria-labelledby="foreign-tab"
                     style="background-color: currentColor!important;">
                    <div>
                        <div class="custom-control custom-radio mb-3 pt-3">
                            <div class="row">
                                <div class="col-3">
                                    <p class="label-form" style="font-size: 14px; color: #525f7f !important">Pais</p>
                                    <multi_select v-model="newForeignNode.country_id" :options="lists.countries"
                                                  label="name" track-by="id"
                                                  placeholder="Seleccione"></multi_select>
                                </div>
                                <div class="col-3">
                                    <p class="label-form" style="font-size: 14px; color: #525f7f !important">Entidad</p>
                                    <multi_select v-model="newForeignNode.entity_id" :options="lists.entities"
                                                  label="name" track-by="id"
                                                  placeholder="Seleccione"></multi_select>
                                </div>
                                <div class="col-3">
                                    <p class="label-form" style="font-size: 14px; color: #525f7f !important">Enlace</p>
                                    <multi_select v-model="newForeignNode.internet_link_id"
                                                  :options="lists.internet_links"
                                                  label="name" track-by="id"
                                                  placeholder="Seleccione"></multi_select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 input-group pt-4">
                                <textarea v-model="newForeignNode.ips" class="form-control"
                                          placeholder="Inserte Ip o grupo de Ips (Separadas por Coma)"/>
                                </div>
                            </div>
                        </div>
                        <div class="nav justify-content-end">
                            <button type="button" class="btn btn-sm btn-icon btn-success"
                                    data-toggle="collapse"
                                    data-target="#collapseForeign"
                                    aria-expanded="false"
                                    aria-controls="collapseForeign"
                                    @click="addForeignIps">
                                <span class="btn-inner--icon"><i class="ni ni-check-bold"></i></span>Añadir
                            </button>
                        </div>
                    </div>
                    <div class="d-flex align-items-start flex-wrap">
                        <div v-for="(item, key) in newEvent.foreign_nodes" class="card text-white bg-info m-2"
                             style="max-width: 18rem;">
                            <div id="accordion">
                                <div class="card">
                                    <div class="card-header bg-info m-0 p-0" id="headingOne">
                                        <h5 class="mb-0">
                                            <a class="btn btn-link text-white" data-toggle="collapse"
                                               :data-target="`#collapseOne${item.id}`" aria-expanded="true"
                                               :aria-controls="`collapseOne${item.id}`">
                                                <label class="m-0"
                                                       v-text="getAddedIpLabel(item)"></label>
                                                <span class="btn-inner--icon p-2"><i
                                                    class="ni ni-world-2"></i></span>
                                            </a>
                                            <button class="btn btn-icon btn-sm btn-2 btn-danger ml-auto mr-2 p-0"
                                                    type="button"
                                                    @click="removeForeignIps(key)">
                                                <span class="btn-inner--icon"><i
                                                    class="ni ni-2x ni-fat-remove"></i></span>
                                            </button>
                                        </h5>
                                    </div>
                                    <div :id="`collapseOne${item.id}`" class="collapse" aria-labelledby="headingOne"
                                         data-parent="#accordion">
                                        <div class="card-body bg-info">
                                            <div>
                                                <small class="text-muted text-white mb-0">
                                                    IPs: {{ getAddedIpLabel(item, true) }}
                                                </small>
                                            </div>
                                            <div>
                                                <small class="text-muted text-white mb-0">
                                                    Pais: {{ getAddedCountryLabel(item) }}
                                                </small>
                                            </div>
                                            <div>
                                                <small class="text-muted text-white mb-0">
                                                    Entidad: {{ getAddedEntityLabel(item) }}
                                                </small>
                                            </div>
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
import VueMoment from 'vue-moment'
import moment from 'moment-timezone'
import DateRangePicker from 'vue2-daterange-picker'
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css'

Vue.use(VueMoment, {
    moment,
})

export default {
    name: 'Events',
    components: {
        Modal,
        simpleTable,
        simpleTableSwitchField,
        Multi_select,
        DateRangePicker,
    },

    data() {
        return {
            subcategoriesBycategory: [],
            filters: {
                subcategoriesBycategory: [],
                dateRange: {
                    startDate: new Date(new Date().getFullYear(), 0, 1),
                    endDate: new Date(new Date().getFullYear(), 11, 31),
                }
            },
            defaultFilters: {
                dateRange: {
                    startDate: new Date(new Date().getFullYear(), 0, 1),
                    endDate: new Date(new Date().getFullYear(), 11, 31),
                }
            },
            isLoading: false,
            eventTableKey: 0,
            newEvent: {
                date: null,
                number: null,
                category_id: null,
                observations: null,
                detected_by_id: null,
                subcategory_id: null,
                contribute_id: null,
                national_nodes: [],
                foreign_nodes: [],
                deleted_nodes: [],
                national_as_source: false,
            },
            newNationalNode: {
                internet_link_id: null,
                country_id: null,
                ministry_id: null,
                entity_id: null,
                ips: null,
            },
            newForeignNode: {
                internet_link_id: null,
                country_id: null,
                ministry_id: null,
                entity_id: null,
                ips: null,
            },
            eventsUrl: route('events.all'),
            lists: {
                entities: [],
                ministeries: [],
                categories: [],
                subcategories: [],
                contributes: [],
                internet_links: [],
                countries: [],
            },
            eventsFields: [
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
                    name: 'category_id',
                    title: 'Categoría',
                    sortField: 'category_id',
                    titleClass: 'text-left',
                    dataClass: 'text-left',
                    formatter: (value) => {
                        let span = ''
                        span += '<span class="badge badge-default badge-md ml-1 mr-1 text-white">' + this.getListsValueById(value, 'categories')?.name + '</span>'

                        return span
                    }
                },
                {
                    name: 'subcategory_id',
                    title: 'Subcategoría',
                    sortField: 'subcategory_id',
                    titleClass: 'text-left',
                    dataClass: 'text-left',
                    formatter: (value) => {
                        let span = ''
                        span += '<span class="badge badge-default badge-md ml-1 mr-1 text-white">' + this.getListsValueById(value, 'subcategories')?.name + '</span>'

                        return span
                    }
                },
                {
                    name: 'observations',
                    title: 'Observaciones',
                    sortField: 'observations',
                    titleClass: 'text-left',
                    dataClass: 'text-left',
                },
                {
                    name: 'detected_by_id',
                    title: 'Detectado Por',
                    sortField: 'detected_by_id',
                    titleClass: 'text-left',
                    dataClass: 'text-left',
                    formatter: (value) => {
                        let span = ''
                        span += '<span class="badge badge-default badge-md ml-1 mr-1 text-white">' + this.getListsValueById(value, 'sources')?.name + '</span>'

                        return span
                    }
                },
                {
                    name: 'contribute_id',
                    title: 'Tributa',
                    sortField: 'contribute_id',
                    titleClass: 'text-left',
                    dataClass: 'text-left',
                    formatter: (value) => {
                        let span = ''
                        span += '<span class="badge badge-default badge-md ml-1 mr-1 text-white">' + this.getListsValueById(value, 'contributes')?.name + '</span>'

                        return span
                    }
                },
                {
                    name: 'reports',
                    title: 'Traslados',
                    titleClass: 'text-left',
                    dataClass: 'text-left',
                    formatter: (value) => {
                        let span = ''
                        value.forEach(item => {
                            span += '<span class="badge badge-default badge-md ml-1 mr-1 text-white">No.' + item.number + '</span>'
                        })

                        return span
                    }
                },
                {
                    name: 'actions-slot',
                    title: 'Actions',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                },
            ],
            showNewEventModal: false,
        }
    },

    computed: {
        defaultEventsUrl() {
            return route('events.all')
        },
    },

    watch: {
        'newEvent.category_id'(newValue) {
            if (newValue) {
                this.getSubcategoriesByCategory()
            }
        },
        'filters.category_id'(newValue) {
            if (newValue) {
                this.getSubcategoriesByCategory(true)
            }
        }
    },

    methods: {
        getTableSortData() {
            return this.$refs['eventTable'].$refs['eventVueTable'].sortOrder[0]
        },

        getTableCurrentPage() {
            return this.$refs['eventTable'].$refs['eventVueTable'].currentPage
        },

        getTableperPage() {
            return this.$refs['eventTable'].$refs['eventVueTable'].perPage
        },

        reloadTable(tableReference, vuetableReference) {
            this.$refs[tableReference].$refs[vuetableReference].reload()
        },

        resetEventData() {
            this.newEvent = {
                date: null,
                number: null,
                category_id: null,
                observations: null,
                detected_by_id: null,
                contribute_id: null,
                subcategory_id: null,
                national_nodes: [],
                foreign_nodes: [],
                deleted_nodes: [],
                national_as_source: false,
            }
        },

        resetNationalNodeData() {
            this.newNationalNode = {
                internet_link_id: null,
                country_id: null,
                ministry_id: null,
                entity_id: null,
                ips: null,
            }
        },

        resetForeignNodeData() {
            this.newForeignNode = {
                internet_link_id: null,
                country_id: null,
                ministry_id: null,
                entity_id: null,
                ips: null,
            }
        },

        closeCreateEventModal() {
            this.showNewEventModal = false
            this.resetEventData()
        },

        exportExcel() {
            window.open(this.getRouteFilters(route('events.export')), '_blank')
        },

        openCreateEditEventModal(eventData) {
            if (eventData.id) {
                this.newEvent.id = eventData.id
                this.newEvent.number = eventData.number
                this.newEvent.date = Vue.moment(eventData.date).format('YYYY-MM-DDThh:mm:ss')
                this.newEvent.observations = eventData.observations
                this.newEvent.subcategory_id = eventData.subcategory_id
                this.newEvent.category_id = eventData.category_id
                this.newEvent.detected_by_id = eventData.detected_by_id
                this.newEvent.contribute_id = eventData.contribute_id
                this.newEvent.national_as_source = eventData.national_as_source
                this.newEvent.deleted_nodes = []
                eventData?.nodes.forEach(item => {
                    if (item.country_id === 57) { // 57 Cuba
                        this.newEvent.national_nodes.push(item)
                    } else {
                        this.newEvent.foreign_nodes.push(item)
                    }
                })
            }
            this.showNewEventModal = true
        },

        saveEventData() {
            this.isLoading = true
            let url = this.newEvent.id ? route('events.edit', this.newEvent.id) : route('events.create')
            axios.post(url, this.newEvent)
                .then(response => {
                    if (response.status === 200) {
                        this.isLoading = false
                        dialog.success(response.data.message)
                        this.closeCreateEventModal()
                        this.reloadTable('eventTable', 'eventVueTable')
                        this.getLists(['entities', 'categories', 'subcategories', 'internet_links', 'ministries', 'countries', 'sources', 'contributes'])
                    } else {
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

        deleteEvent(id) {
            this.$swal({
                icon: 'warning',
                title: 'Está seguro de que desea eliminar este elemento?',
                showCancelButton: true,
                confirmButtonText: `Eliminar`,
                cancelButtonText: `Cancelar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    this.isLoading = true
                    axios.delete(route('events.remove', id))
                        .then(response => {
                            if (response.status === 200) {
                                this.isLoading = false
                                dialog.success(response.data.message)
                                this.reloadTable('eventTable', 'eventVueTable')
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

        getSubcategoriesByCategory(forFilter = false) {
            let url = route('defaults.subcategoriesByCategory', forFilter ? this.filters.category_id : this.newEvent.category_id)
            axios.get(url)
                .then(response => {
                    if (response.status === 200) {
                        if (forFilter) {
                            this.filters.subcategoriesBycategory = response.data.subcategories

                            return
                        }
                        this.subcategoriesBycategory = response.data.subcategories
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

        addNationalIps() {
            if (!this.validateNode(this.newNationalNode)) {
                dialog.error('Direccion Ip con formato incorrecto')
                setTimeout(() => {
                    $('#collapseNationals').addClass('show')
                }, 100)
                return
            }
            this.newEvent.national_nodes.push(this.newNationalNode)
            this.resetNationalNodeData()
        },

        validateNode(node) {
            let someFail = true
            if (node.ips === null || node.ips === '') {
                return false
            }

            let ips = node.ips.split(',')
            ips.forEach(item => {
                if (!this.validateIp(item)) {
                    someFail = false
                }
            })

            return someFail
        },

        validateIp(ip) {
            return /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(ip)
        },

        removeNationalIps(key) {
            let newArray = []
            if (this.newEvent.national_nodes[key]?.ip_id) {
                this.newEvent.deleted_nodes.push(this.newEvent.national_nodes[key].id)
            }
            this.newEvent.national_nodes.forEach(function (item, index) {
                if (key != index) {
                    newArray.push(item)
                }
            })

            this.newEvent.national_nodes = newArray
        },

        removeForeignIps(key) {
            let newArray = []
            if (this.newEvent.foreign_nodes[key]?.ip_id) {
                this.newEvent.deleted_nodes.push(this.newEvent.foreign_nodes[key].id)
            }

            this.newEvent.foreign_nodes.forEach(function (item, index) {
                if (key != index) {
                    newArray.push(item)
                }
            })

            this.newEvent.foreign_nodes = newArray
        },

        getAddedIpLabel(item, showAll = false) {
            if (showAll) {
                return item.id
                    ? item.ip.address
                    : item.ips
            }
            return item.id
                ? item.ip.address
                : item.ips.length > 15
                    ? item.ips.substring(0, 15) + '...'
                    : item.ips
        },

        getAddedMinistryLabel(item) {
            return this.lists.ministries[item.ministry_id]?.name ? this.lists.ministries[item.ministry_id]?.name : ''
        },

        getAddedEntityLabel(item) {
            return this.lists.entities[item.entity_id]?.name ? this.lists.entities[item.entity_id]?.name : ''
        },

        getAddedCountryLabel(item) {
            return this.lists.countries[item.country_id]?.name ? this.lists.countries[item.country_id]?.name : ''
        },

        getAddedInternetLinkLabel(item) {
            return this.lists.internet_links[item.internet_link_id]?.name ? this.lists.internet_links[item.internet_link_id]?.name : ''
        },

        addForeignIps() {
            if (!this.validateNode(this.newForeignNode)) {
                dialog.error('Direccion Ip con formato incorrecto')
                setTimeout(() => {
                    $('#collapseForeign').addClass('show')
                }, 100)
                return
            }
            this.newEvent.foreign_nodes.push(this.newForeignNode)
            this.resetForeignNodeData()
        },

        getListsValueById(id, element) {
            return this.lists[element]?.filter(item => item.id === id)[0]
        },

        clearFilters() {
            this.filters = this.cloneDeep(this.defaultFilters)
            this.$refs['eventTable'].sortOrder = []
            this.eventsUrl = this.defaultEventsUrl
            this.$nextTick(() => {
                this.$refs['eventTable'].$refs['eventVueTable'].reload()
            })
        },

        applyFiltersAndFetchData() {
            this.eventsUrl = this.defaultEventsUrl
            this.eventsUrl = this.getRouteFilters(this.eventsUrl)
        },

        cloneDeep(value) {
            return JSON.parse(JSON.stringify(value))
        },

        getRouteFilters(route) {
            const queryString = null
            let sortData = this.getTableSortData()
            let currentPage = this.getTableCurrentPage()
            let perPage = this.getTableperPage()

            let url
            let separation = '?'

            const orderByQuery = `&order_by=${sortData?.field}&sort_by=${sortData?.direction}`
            url = `${route}${separation}page=${currentPage}&per_page=${perPage}${orderByQuery}${queryString ? '&' + queryString : ''}`

            separation = '&'

            let extraQueryString = ''
            if (Object.keys(this.filters).length > 0) {
                extraQueryString = separation + this.stringify(this.filters)
            }

            return url + extraQueryString
        },

        stringify(allParams) {
            const params = JSON.parse(JSON.stringify(allParams))
            const stringify = Object.keys(params)
                .filter(key => params[key] !== null && params[key] !== '' && params[key] !== undefined)
                .map((key) => {
                    if (typeof params[key] === 'object' && params[key]) {
                        return this.objectToArray(key, params[key])
                    }

                    return encodeURIComponent(key) + '=' + encodeURIComponent(params[key])
                })
                .filter(item => item !== null && item !== '' && item !== undefined)

            return (
                stringify.length > 1 ? stringify.join('&') : stringify.join('')
            ).replace(/^\&/, '').trim()
        },

        objectToArray(param, object) {
            return Object.keys(object)
                .filter(key => object[key] !== null & object[key] !== '')
                .map(key => {
                    return encodeURIComponent(`${param}[${key}]`) + '=' + encodeURIComponent(object[key])
                }).join('&')
        },
    },

    created() {
    },

    mounted() {
        this.getLists(['entities', 'categories', 'subcategories', 'internet_links', 'ministries', 'countries', 'sources', 'contributes'])
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
