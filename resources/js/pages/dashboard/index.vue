<template>
    <div>
        <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
            <div class="container-fluid">
                <div class="header-body">
                    <!-- Filters -->
                    <div class="row">
                        <div class="col-12">
                            <card>
                                <div class="row align-items-center">
                                    <div class="col ml--2 mb-2">
                                        <h4 class="mb-0">
                                            Filtros
                                        </h4>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-sm-12 col-md-4 mb-2 mt-2">
                                        <date-range-picker @update="applyFilters" v-model="generalFilters.pickerDates">
                                        </date-range-picker>
                                    </div>
                                    <div class="col-auto ml-auto mb-2 mt-2">
                                        <button class="btn btn-sm btn-outline-primary" @click="clearFilters">Limpiar
                                        </button>
                                    </div>
                                </div>
                            </card>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Charts -->
        <div class="container-fluid mt--7">
            <div class="row mt-5 mb-5">
                <div class="col-xl-8 mb-5 mb-xl-0">
                    <div class="card bg-gradient-default shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="text-uppercase text-light ls-1 mb-1">Total</h6>
                                    <h2 class="text-white mb-0">Incidentes</h2>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas :height="350" :id="salesChartID" :key="eventsChartKey"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 mb-5 mb-xl-0">
                    <div class="card shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="text-uppercase ls-1 mb-1">Total de Incidentes</h6>
                                    <h2 class="mb-0">Entidades</h2>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas :height="350" :id="entitiesChartId"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5 mb-5">
                <div class="col-xl-6 mb-5 mb-xl-0">
                    <div class="card shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="text-uppercase ls-1 mb-1">Total de incidencias por Categorías</h6>
                                    <h2 class="mb-0">Categorías</h2>
                                </div>
                                <div class="col">
                                    <a class="mb-0 btn btn-secondary float-right" href="#" @click="exportChartToImage(categoriesChartId)"><i class="fa fa-arrow-down pr-1"></i>Exportar</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas :height="350" :id="categoriesChartId"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 mb-5 mb-xl-0">
                    <div class="card shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="text-uppercase ls-1 mb-1">Total de incidencias por Subcategorías</h6>
                                    <h2 class="mb-0">Subcategorías</h2>
                                </div>
                                <div class="col">
                                    <a class="mb-0 btn btn-secondary float-right" href="#" @click="exportChartToImage(subcategoriesChartId)"><i class="fa fa-arrow-down pr-1"></i>Exportar</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas :height="350" :id="subcategoriesChartId"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5 mb-5">
                <div class="col-xl-6 mb-5 mb-xl-0">
                    <div class="card shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="text-uppercase ls-1 mb-1">Total de incidencias por Fuente</h6>
                                    <h2 class="mb-0">Fuentes de Informacion</h2>
                                </div>
                                <div class="col">
                                    <a class="mb-0 btn btn-secondary float-right" href="#" @click="exportChartToImage(detectedByChartId)"><i class="fa fa-arrow-down pr-1"></i>Exportar</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas :height="350" :id="detectedByChartId"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 mb-5 mb-xl-0">
                    <div class="card shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="text-uppercase ls-1 mb-1">Total de incidencias por Ministerios</h6>
                                    <h2 class="mb-0">Ministerios</h2>
                                </div>
                                <div class="col">
                                    <a class="mb-0 btn btn-secondary float-right" href="#" @click="exportChartToImage(ministriesChartId)"><i class="fa fa-arrow-down pr-1"></i>Exportar</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas :height="350" :id="ministriesChartId"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5 mb-5">
                <div class="col-xl-6 mb-5 mb-xl-0">
                    <div class="card shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="text-uppercase ls-1 mb-1">Total de incidencias por Entidades
                                        Nacionales</h6>
                                    <h2 class="mb-0">Entidades Nacionales</h2>
                                </div>
                                <div class="col">
                                    <a class="mb-0 btn btn-secondary float-right" href="#" @click="exportChartToImage(entitiesNationalsChartId)"><i class="fa fa-arrow-down pr-1"></i>Exportar</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas :height="350" :id="entitiesNationalsChartId"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 mb-5 mb-xl-0">
                    <div class="card shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="text-uppercase ls-1 mb-1">Total de incidencias por Entidades Extranjeras
                                        Involucradas</h6>
                                    <h2 class="mb-0">Entidades Extranjeras Involucradas</h2>
                                </div>
                                <div class="col">
                                    <a class="mb-0 btn btn-secondary float-right" href="#" @click="exportChartToImage(foreignEntitiesInvolvedChartId)"><i class="fa fa-arrow-down pr-1"></i>Exportar</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas :height="350" :id="foreignEntitiesInvolvedChartId"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5 mb-5">
                <div class="col-xl-6 mb-5 mb-xl-0">
                    <div class="card shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="text-uppercase ls-1 mb-1">Total de incidencias por Países
                                        Involucrados</h6>
                                    <h2 class="mb-0">Países Involucrados</h2>
                                </div>
                                <div class="col">
                                    <a class="mb-0 btn btn-secondary float-right" href="#" @click="exportChartToImage(countriesInvolvedChartId)"><i class="fa fa-arrow-down pr-1"></i>Exportar</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas :height="350" :id="countriesInvolvedChartId"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 mb-5 mb-xl-0">
                    <div class="card shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="text-uppercase ls-1 mb-1">Total de incidencias por Origen y Destino</h6>
                                    <h2 class="mb-0">Origen y Destino</h2>
                                </div>
                                <div class="col">
                                    <a class="mb-0 btn btn-secondary float-right" href="#" @click="exportChartToImage(sourceTargetChartId)"><i class="fa fa-arrow-down pr-1"></i>Exportar</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas :height="350" :id="sourceTargetChartId"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5 mb-5">
                <div class="col-xl-6 mb-5 mb-xl-0">
                    <div class="card shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="text-uppercase ls-1 mb-1">Total de incidencias por Tributa</h6>
                                    <h2 class="mb-0">Tributa</h2>
                                </div>
                                <div class="col">
                                    <a class="mb-0 btn btn-secondary float-right" href="#" @click="exportChartToImage(contributeChartId)"><i class="fa fa-arrow-down pr-1"></i>Exportar</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas :height="350" :id="contributeChartId"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueLoadImage from 'vue-load-image'
import simpleTable from '../../components/utils/simpleTable/simpleTable'
import stat from '../../components/utils/stat'
import modal from '../../components/utils/modal'
import dialog from '../../libs/custom/dialog'
import {lineChart, doughnutChart, barChartStacked, barChart} from '../../components/Charts/Chart'
import Multi_select from '../../components/utils/multiselect'
import Card from '../../components/Cards/Card'
import DateRangePicker from 'vue2-daterange-picker'
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css'

export default {
    name: 'Dashboard',
    components: {
        Multi_select,
        'vue-load-image': VueLoadImage,
        simpleTable,
        stat,
        modal,
        DateRangePicker,
        Card,
    },

    filters: {
        date(date) {
            return new Intl.DateTimeFormat('en-US').format(date)
        }
    },

    data() {
        return {
            eventsByEntities: null,
            eventsChartKey: 0,
            generalFilters: {
                pickerDates: {
                    startDate: new Date(new Date().getFullYear(), 0, 1),
                    endDate: new Date(new Date().getFullYear(), 11, 31),
                },
            },
            percentStatsId: 'percentStatsChart',
            entitiesChartId: 'barChartStackedId',
            categoriesChartId: 'barCategoryTotalsId',
            subcategoriesChartId: 'barSubCategoryTotalsId',
            detectedByChartId: 'barDetectedByTotalsId',
            ministriesChartId: 'barMinistriesTotalsId',
            sourceTargetChartId: 'barSourceTargetTotalsId',
            entitiesNationalsChartId: 'barEntitiesNationalsTotalsId',
            countriesInvolvedChartId: 'barCountriesInvolvedTotalsId',
            foreignEntitiesInvolvedChartId: 'barForeignEntitiesInvolvedTotalsId',
            contributeChartId: 'barContributeTotalsId',
            salesChartID: 'lineChart',
            eventsByMonthData: [],
            lists: {},
        }
    },

    computed: {},

    watch: {},

    methods: {
        applyFilters() {
            this.getEventsByMonth()
            this.getTrendByEntity()
            this.getCategoriesByEvents()
            this.getSubCategoriesByEvents()
            this.getDetectedByEvents()
            this.getMinistriesEvents()
            this.getEntitiesNationalsEvents()
            this.getCountriesInvolvedEvents()
            this.getForeignEntitiesInvolvedEvents()
            this.getContributeEvents()
            this.getSourceTargetByEvents()
        },

        getFormatDate(stringDate) {
            return new Intl.DateTimeFormat('en-US').format(stringDate)
        },

        clearFilters() {
            this.generalFilters = {
                pickerDates: {
                    startDate: new Date(new Date().getFullYear(), 0, 1),
                    endDate: new Date(new Date().getFullYear(), 11, 31),
                },
            }
            this.applyFilters()
        },

        getEventsByMonth() {
            this.isLoading = true
            this.eventsChartKey++
            axios.get(route('events.total_by_month') + `?startDate=${this.getFormatDate(this.generalFilters.pickerDates.startDate)}&endDate=${this.getFormatDate(this.generalFilters.pickerDates.endDate)}`)
                .then(response => {
                    if (response.status === 200) {
                        this.eventsByMonthData = response.data.totals
                        lineChart.createChart(
                            this.salesChartID,
                            this.eventsByMonthData,
                            response.data.labels
                        )
                        this.isLoading = false
                    } else {
                        this.isLoading = false
                        dialog.error()
                    }
                }).catch(error => {
                console.log(error)
                this.isLoading = false
                if (!error.response) {
                    // network error
                    this.errorStatus = 'Error: Network Error'
                    dialog.error(this.errorStatus)
                } else {
                    this.errorStatus = error.response.data.message
                    dialog.error(this.errorStatus)
                }
            })
        },

        getTrendByEntity() {
            this.isLoading = true
            axios.get(route('events.totals_by_entities') + `?startDate=${this.getFormatDate(this.generalFilters.pickerDates.startDate)}&endDate=${this.getFormatDate(this.generalFilters.pickerDates.endDate)}`)
                .then(response => {
                    if (response.status === 200) {
                        this.eventsByEntities = response.data.totals
                        barChartStacked.createChart(
                            this.entitiesChartId,
                            this.generateDatasets(this.eventsByEntities),
                            response.data.labels
                        )
                        this.isLoading = false
                    } else {
                        this.isLoading = false
                        dialog.error()
                    }
                }).catch(error => {
                console.log(error)
                this.isLoading = false
                if (!error.response) {
                    // network error
                    this.errorStatus = 'Error: Network Error'
                    dialog.error(this.errorStatus)
                } else {
                    this.errorStatus = error.response.data.message
                    dialog.error(this.errorStatus)
                }
            })
        },

        getCategoriesByEvents() {
            this.isLoading = true
            axios.get(route('events.totals_by_categories') + `?startDate=${this.getFormatDate(this.generalFilters.pickerDates.startDate)}&endDate=${this.getFormatDate(this.generalFilters.pickerDates.endDate)}`)
                .then(response => {
                    if (response.status === 200) {
                        barChart.createChart(
                            this.categoriesChartId,
                            response.data.labels,
                            response.data.totals,
                            'Incidentes',
                            '#3291ef'
                        )
                        this.isLoading = false
                    } else {
                        this.isLoading = false
                        dialog.error()
                    }
                }).catch(error => {
                console.log(error)
                this.isLoading = false
                if (!error.response) {
                    // network error
                    this.errorStatus = 'Error: Network Error'
                    dialog.error(this.errorStatus)
                } else {
                    this.errorStatus = error.response.data.message
                    dialog.error(this.errorStatus)
                }
            })
        },

        getDetectedByEvents() {
            this.isLoading = true
            axios.get(route('events.totals_by_detected_by') + `?startDate=${this.getFormatDate(this.generalFilters.pickerDates.startDate)}&endDate=${this.getFormatDate(this.generalFilters.pickerDates.endDate)}`)
                .then(response => {
                    if (response.status === 200) {
                        barChart.createChart(
                            this.detectedByChartId,
                            response.data.labels,
                            response.data.totals,
                            'Incidentes',
                            '#3291ef'
                        )
                        this.isLoading = false
                    } else {
                        this.isLoading = false
                        dialog.error()
                    }
                }).catch(error => {
                console.log(error)
                this.isLoading = false
                if (!error.response) {
                    // network error
                    this.errorStatus = 'Error: Network Error'
                    dialog.error(this.errorStatus)
                } else {
                    this.errorStatus = error.response.data.message
                    dialog.error(this.errorStatus)
                }
            })
        },

        getMinistriesEvents() {
            this.isLoading = true
            axios.get(route('events.totals_by_ministries') + `?startDate=${this.getFormatDate(this.generalFilters.pickerDates.startDate)}&endDate=${this.getFormatDate(this.generalFilters.pickerDates.endDate)}`)
                .then(response => {
                    if (response.status === 200) {
                        barChart.createChart(
                            this.ministriesChartId,
                            response.data.labels,
                            response.data.totals,
                            'Incidentes',
                            '#3291ef'
                        )
                        this.isLoading = false
                    } else {
                        this.isLoading = false
                        dialog.error()
                    }
                }).catch(error => {
                console.log(error)
                this.isLoading = false
                if (!error.response) {
                    // network error
                    this.errorStatus = 'Error: Network Error'
                    dialog.error(this.errorStatus)
                } else {
                    this.errorStatus = error.response.data.message
                    dialog.error(this.errorStatus)
                }
            })
        },

        getSubCategoriesByEvents() {
            this.isLoading = true
            axios.get(route('events.totals_by_subcategories') + `?startDate=${this.getFormatDate(this.generalFilters.pickerDates.startDate)}&endDate=${this.getFormatDate(this.generalFilters.pickerDates.endDate)}`)
                .then(response => {
                    if (response.status === 200) {
                        barChart.createChart(
                            this.subcategoriesChartId,
                            response.data.labels,
                            response.data.totals,
                            'Incidentes',
                            '#3291ef'
                        )
                        this.isLoading = false
                    } else {
                        this.isLoading = false
                        dialog.error()
                    }
                }).catch(error => {
                console.log(error)
                this.isLoading = false
                if (!error.response) {
                    // network error
                    this.errorStatus = 'Error: Network Error'
                    dialog.error(this.errorStatus)
                } else {
                    this.errorStatus = error.response.data.message
                    dialog.error(this.errorStatus)
                }
            })
        },

        getSourceTargetByEvents() {
            this.isLoading = true
            axios.get(route('events.totals_by_source_target') + `?startDate=${this.getFormatDate(this.generalFilters.pickerDates.startDate)}&endDate=${this.getFormatDate(this.generalFilters.pickerDates.endDate)}`)
                .then(response => {
                    if (response.status === 200) {
                        barChart.createChart(
                            this.sourceTargetChartId,
                            response.data.labels,
                            response.data.totals,
                            'Incidentes',
                            '#3291ef'
                        )

                        this.isLoading = false
                    } else {
                        this.isLoading = false
                        dialog.error()
                    }
                }).catch(error => {
                console.log(error)
                this.isLoading = false
                if (!error.response) {
                    // network error
                    this.errorStatus = 'Error: Network Error'
                    dialog.error(this.errorStatus)
                } else {
                    this.errorStatus = error.response.data.message
                    dialog.error(this.errorStatus)
                }
            })
        },

        getEntitiesNationalsEvents() {
            this.isLoading = true
            axios.get(route('events.totals_by_entities_nationals') + `?startDate=${this.getFormatDate(this.generalFilters.pickerDates.startDate)}&endDate=${this.getFormatDate(this.generalFilters.pickerDates.endDate)}`)
                .then(response => {
                    if (response.status === 200) {
                        barChart.createChart(
                            this.entitiesNationalsChartId,
                            response.data.labels,
                            response.data.totals,
                            'Incidentes',
                            '#3291ef'
                        )
                        this.isLoading = false
                    } else {
                        this.isLoading = false
                        dialog.error()
                    }
                }).catch(error => {
                console.log(error)
                this.isLoading = false
                if (!error.response) {
                    // network error
                    this.errorStatus = 'Error: Network Error'
                    dialog.error(this.errorStatus)
                } else {
                    this.errorStatus = error.response.data.message
                    dialog.error(this.errorStatus)
                }
            })
        },

        getCountriesInvolvedEvents() {
            this.isLoading = true
            axios.get(route('events.totals_by_countries_involved') + `?startDate=${this.getFormatDate(this.generalFilters.pickerDates.startDate)}&endDate=${this.getFormatDate(this.generalFilters.pickerDates.endDate)}`)
                .then(response => {
                    if (response.status === 200) {
                        barChart.createChart(
                            this.countriesInvolvedChartId,
                            response.data.labels,
                            response.data.totals,
                            'Incidentes',
                            '#3291ef'
                        )
                        this.isLoading = false
                    } else {
                        this.isLoading = false
                        dialog.error()
                    }
                }).catch(error => {
                console.log(error)
                this.isLoading = false
                if (!error.response) {
                    // network error
                    this.errorStatus = 'Error: Network Error'
                    dialog.error(this.errorStatus)
                } else {
                    this.errorStatus = error.response.data.message
                    dialog.error(this.errorStatus)
                }
            })
        },

        getForeignEntitiesInvolvedEvents() {
            this.isLoading = true
            axios.get(route('events.totals_by_foreign_entities_involved') + `?startDate=${this.getFormatDate(this.generalFilters.pickerDates.startDate)}&endDate=${this.getFormatDate(this.generalFilters.pickerDates.endDate)}`)
                .then(response => {
                    if (response.status === 200) {
                        barChart.createChart(
                            this.foreignEntitiesInvolvedChartId,
                            response.data.labels,
                            response.data.totals,
                            'Incidentes',
                            '#3291ef'
                        )
                        this.isLoading = false
                    } else {
                        this.isLoading = false
                        dialog.error()
                    }
                }).catch(error => {
                console.log(error)
                this.isLoading = false
                if (!error.response) {
                    // network error
                    this.errorStatus = 'Error: Network Error'
                    dialog.error(this.errorStatus)
                } else {
                    this.errorStatus = error.response.data.message
                    dialog.error(this.errorStatus)
                }
            })
        },

        getContributeEvents() {
            this.isLoading = true
            axios.get(route('events.totals_by_contribute') + `?startDate=${this.getFormatDate(this.generalFilters.pickerDates.startDate)}&endDate=${this.getFormatDate(this.generalFilters.pickerDates.endDate)}`)
                .then(response => {
                    if (response.status === 200) {
                        barChart.createChart(
                            this.contributeChartId,
                            response.data.labels,
                            response.data.totals,
                            'Incidentes',
                            '#3291ef'
                        )
                        this.isLoading = false
                    } else {
                        this.isLoading = false
                        dialog.error()
                    }
                }).catch(error => {
                console.log(error)
                this.isLoading = false
                if (!error.response) {
                    // network error
                    this.errorStatus = 'Error: Network Error'
                    dialog.error(this.errorStatus)
                } else {
                    this.errorStatus = error.response.data.message
                    dialog.error(this.errorStatus)
                }
            })
        },

        generateDatasets(data) {
            let dataset = []
            Object.keys(data).forEach(item => {
                dataset.push({
                    label: item,
                    maxBarThickness: 10,
                    tension: 0.4,
                    data: data[item],
                    backgroundColor: this.randomColorGenerator(),
                })
            })
            return dataset
        },

        randomColorGenerator() {
            return '#' + (Math.random() * 0xFFFFFF << 0).toString(16)
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
                    this.errorStatus = 'Error: Network Error'
                    dialog.error(this.errorStatus)
                } else {
                    this.errorStatus = error.response.data.message
                    dialog.error(this.errorStatus)
                }
            })
        },

        exportChartToImage(id) {
                let downloadLink = document.createElement('a');
                downloadLink.setAttribute('download', 'image.png');
                let canvas = document.getElementById(id);
                let dataURL = canvas.toDataURL('image/png');
                let url = dataURL.replace(/^data:image\/png/,'data:application/octet-stream');
                downloadLink.setAttribute('href',url);
                downloadLink.click();
        }
    },

    mounted() {
        this.getEventsByMonth()
        this.getTrendByEntity()
        this.getCategoriesByEvents()
        this.getSubCategoriesByEvents()
        this.getDetectedByEvents()
        this.getMinistriesEvents()
        this.getEntitiesNationalsEvents()
        this.getCountriesInvolvedEvents()
        this.getForeignEntitiesInvolvedEvents()
        this.getContributeEvents()
        this.getSourceTargetByEvents()
        this.getLists(['subcategories'])
    },
}
</script>

<style>
.vue-daterange-picker {
    display: block !important;
}

.vue-daterange-picker .reportrange-text {
    height: 42px !important;
    padding-top: 10px;
}

</style>
