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
                                    <h2 class="mb-0">Noticias</h2>
                                </div>
                                <div class="col">
                                    <ul class="nav nav-pills justify-content-end">
                                        <li class="nav-item mr-2 mr-md-0">
                                            <a @click.prevent="openCreateEditNewsModal" href="#"
                                               class="nav-link py-2 px-3 active">
                                                <span class="d-none d-md-block">+ Nuevo Noticia</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <simple-table reference="newsVueTable"
                                          :key="newsTableKey"
                                          ref="newsTable"
                                          :api-url="newsUrl"
                                          :has-settings="false"
                                          :has-header="false"
                                          :fields="newsFields"
                                          :per-page="5"
                                          paginationFontSize="small"
                                          :action-default-options="['edit', 'delete']"
                                          @edit="openCreateEditNewsModal(...arguments)"
                                          @delete="deleteNews(...arguments)">
                            </simple-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal title="Añadir Noticia"
               :show="showNewNewsModal"
               @accept="saveNewsData"
               @cancel="closeCreateNewsModal">
            <div class="container">
                <div class="form-group mb-3">
                    <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                        </div>
                        <input v-model="newNews.title" class="form-control" placeholder="Inserte Titulo"
                               type="text">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-bar"></i></span>
                        </div>
                        <textarea v-model="newNews.body" class="form-control" placeholder="Inserte Cuerpo de Noticia"
                               type="text"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-world-2"></i></span>
                        </div>
                        <input v-model="newNews.url" class="form-control" placeholder="Inserte Url"
                               type="text">
                    </div>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
import Modal from '../../components/utils/modal'
import simpleTable from "../../components/utils/simpleTable/simpleTable";
import dialog from "../../libs/custom/dialog";

export default {
    name: 'News',
    components: {
        Modal,
        simpleTable,
    },

    data() {
        return {
            isLoading: false,
            newsTableKey: 0,
            newNews: {
                title: null,
                description: null,
            },
            lists: { },
            newsFields: [
                {
                    name: 'title',
                    title: 'Titulo',
                    sortField: 'title',
                    titleClass: "text-left",
                    dataClass: "text-left",
                },
                {
                    name: 'body',
                    title: 'Descripcion',
                    sortField: 'body',
                    titleClass: "text-left",
                    dataClass: "text-left",
                },
                {
                    name: 'url',
                    title: 'Url',
                    sortField: 'url',
                    titleClass: "text-left",
                    dataClass: "text-left",
                },
                {
                    name: "actions-slot",
                    title: 'Actions',
                    titleClass: "text-center",
                    dataClass: "text-center",
                },
            ],
            showNewNewsModal: false,
        }
    },

    computed: {
        newsUrl() {
            return route('news.all')
        },
    },

    watch: {
    },

    methods: {
        reloadTable(tableReference, vuetableReference) {
            this.$refs[tableReference].$refs[vuetableReference].reload()
        },

        resetNewsData() {
            this.newNews = {
                title: null,
                description: null,
            }
        },

        closeCreateNewsModal() {
            this.showNewNewsModal = false
            this.resetNewsData()
        },

        openCreateEditNewsModal(newsData) {
            if (newsData.id) {
                this.newNews.id = newsData.id
                this.newNews.title = newsData.title
                this.newNews.body = newsData.body
                this.newNews.url = newsData.url
            }
            this.showNewNewsModal = true
        },

        saveNewsData() {
            this.isLoading = true
            let url = this.newNews.id ? route('news.edit', this.newNews.id) : route('news.create')
            axios.post(url, this.newNews)
                .then(response => {
                    if (response.status === 200) {
                        this.isLoading = false
                        dialog.success(response.data.message)
                        this.closeCreateNewsModal()
                        this.reloadTable('newsTable', 'newsVueTable')
                    } else {
                        console.log(response.data)
                        dialog.error()
                    }
                }).catch(error => {
                this.isLoading = false
                if (!error.response) {
                    // network error
                    this.errorStatus = 'Error: Problemas de Conexión';
                    dialog.error(this.errorStatus)
                } else {
                    this.errorStatus = error.response.data.message;
                    dialog.error(this.errorStatus, error.response.data.errors)
                }
            })
        },

        deleteNews(id) {
            this.$swal({
                icon: 'warning',
                title: 'Está seguro de que desea eliminar este noticia?',
                showCancelButton: true,
                confirmButtonText: `Eliminar`,
                cancelButtonText: `Cancelar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    this.isLoading = true
                    axios.delete(route('news.remove', id))
                        .then(response => {
                            if (response.status === 200) {
                                this.isLoading = false
                                dialog.success(response.data.message)
                                this.reloadTable('newsTable', 'newsVueTable')
                            } else {
                                this.isLoading = false
                                dialog.error()
                            }
                        }).catch(error => {
                        this.isLoading = false
                        if (!error.response) {
                            // network error
                            this.errorStatus = 'Error: Problemas de Conexión';
                            dialog.error(this.errorStatus)
                        } else {
                            this.errorStatus = error.response.data.message;
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
