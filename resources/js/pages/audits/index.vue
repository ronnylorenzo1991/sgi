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
                                    <h2 class="mb-0">Trazas</h2>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <simple-table reference="auditVueTable"
                                          :key="auditTableKey"
                                          ref="auditTable"
                                          :api-url="auditsUrl"
                                          :has-settings="false"
                                          :has-header="false"
                                          :fields="auditsFields"
                                          :per-page="5"
                                          paginationFontSize="small"
                                          :hasCustomActions="true">
                                <template slot="custom-actions" slot-scope="props">
                                </template>
                            </simple-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import simpleTable from "../../components/utils/simpleTable/simpleTable";
import simpleTableSwitchField from "../../components/utils/simpleTable/simpleTableSwitchField";
import VueMoment from 'vue-moment'
import moment from 'moment-timezone'
import Vue from 'vue'
import dialog from '../../libs/custom/dialog'

Vue.use(VueMoment, {
    moment,
})

export default {
    name: 'Audits',
    components: {
        simpleTable,
        simpleTableSwitchField,
    },

    data() {
        return {
            isLoading: false,
            auditTableKey: 0,
            lists: {
                users: [],
            },
            auditsFields: [
                {
                    name: 'created_at',
                    title: 'Fecha',
                    sortField: 'created_at',
                    titleClass: "text-left",
                    dataClass: "text-left",
                    formatter: (value) => {
                        return Vue.moment(value).format('YYYY-MM-DDThh:mm:ss')
                    }
                },
                {
                    name: 'user_id',
                    title: 'Usuario',
                    sortField: 'user_id',
                    titleClass: "text-left",
                    dataClass: "text-left",
                    formatter: (value) => {
                        return this.getListsValueById(value, 'users')?.name
                    }
                },
                {
                    name: 'event',
                    title: 'Evento',
                    sortField: 'event',
                    titleClass: "text-left",
                    dataClass: "text-left",
                },
                {
                    name: 'auditable_type',
                    title: 'Modelo',
                    sortField: 'auditable_type',
                    titleClass: "text-left",
                    dataClass: "text-left",

                },
                {
                    name: 'old_values',
                    title: 'Valor Anterior',
                    sortField: 'old_values',
                    titleClass: "text-left",
                    dataClass: "text-left",
                },
                {
                    name: 'new_values',
                    title: 'Nuevo Valor',
                    sortField: 'new_values',
                    titleClass: "text-left",
                    dataClass: "text-left",
                },
            ],
        }
    },

    computed: {
        auditsUrl() {
            return route('audits.all')
        },
    },

    watch: {
    },

    methods: {
        getModelName(string) {
            let parts = string.split("\\")
            return parts[parts.length - 1];
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
        }
    },

    created() {
    },

    mounted() {
        this.getLists(['users'])
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
