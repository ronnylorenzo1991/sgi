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
                <div class="col-6">
                    <div class="card shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="mb-0">Categorias</h2>
                                </div>
                                <div class="col">
                                    <ul class="nav nav-pills justify-content-end">
                                        <li class="nav-item mr-2 mr-md-0">
                                            <a @click.prevent="openCreateEditModal('category')" href="#"
                                               class="nav-link py-2 px-3 active">
                                                <span class="d-none d-md-block">+ Nueva Categoria</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <simple-table reference="categoryVueTable"
                                          :actionDefaultOptions="['edit', 'delete']"
                                          ref="categoryTable"
                                          :api-url="categoriesUrl"
                                          :has-settings="false"
                                          :has-header="false"
                                          :fields="categoriesFields"
                                          :per-page="5"
                                          paginationFontSize="small"
                                          :hasCustomActions="false"
                                          @edit="openCreateEditModal('category', ...arguments)"
                                          @delete="removeElement('category','categories.remove', ...arguments)">
                            </simple-table>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="mb-0">Subcategorias</h2>
                                </div>
                                <div class="col">
                                    <ul class="nav nav-pills justify-content-end">
                                        <li class="nav-item mr-2 mr-md-0">
                                            <a @click.prevent="openCreateEditModal('subcategory')" href="#"
                                               class="nav-link py-2 px-3 active">
                                                <span class="d-none d-md-block">+ Nueva Subcategoria</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <simple-table reference="subcategoryVueTable"
                                          :actionDefaultOptions="['edit', 'delete']"
                                          ref="subcategoryTable"
                                          :api-url="subcategoriesUrl"
                                          :has-settings="false"
                                          :has-header="false"
                                          :fields="subcategoriesFields"
                                          :per-page="5"
                                          paginationFontSize="small"
                                          :hasCustomActions="false"
                                          @edit="openCreateEditModal('subcategory', ...arguments)"
                                          @delete="removeElement('subcategory','subcategories.remove', ...arguments)">
                            </simple-table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="card shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="mb-0">Sitios Web</h2>
                                </div>
                                <div class="col">
                                    <ul class="nav nav-pills justify-content-end">
                                        <li class="nav-item mr-2 mr-md-0">
                                            <a @click.prevent="openCreateEditModal('site')" href="#"
                                               class="nav-link py-2 px-3 active">
                                                <span class="d-none d-md-block">+ Nuevo Sitio Web</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <simple-table reference="siteVueTable"
                                          :actionDefaultOptions="['edit', 'delete']"
                                          ref="siteTable"
                                          :api-url="sitesUrl"
                                          :has-settings="false"
                                          :has-header="false"
                                          :fields="sitesFields"
                                          :per-page="5"
                                          paginationFontSize="small"
                                          :hasCustomActions="false"
                                          @edit="openCreateEditModal('site', ...arguments)"
                                          @delete="removeElement('site','sites.remove', ...arguments)">
                            </simple-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modals -->
        <modal-sites ref="siteModal" :item="newEditingItem" @savedComplete="savedElement('site')"/>
        <modal-categories ref="categoryModal" :item="newEditingItem" @savedComplete="savedElement('category')"/>
        <modal-subcategories ref="subcategoryModal" :item="newEditingItem" @savedComplete="savedElement('subcategory')"
                             :lists="lists"/>
    </div>
</template>


<script>
import Modal from '../../components/utils/modal'
import simpleTable from '../../components/utils/simpleTable/simpleTable'
import simpleTableSwitchField from '../../components/utils/simpleTable/simpleTableSwitchField'
import dialog from '../../libs/custom/dialog'
import Multi_select from '../../components/utils/multiselect'
import ModalCategories from './partials/modalCategories'
import ModalSubcategories from './partials/modalSubcategories'
import ModalSites from './partials/modalSites'

export default {
    name: 'Settings',
    components: {
        ModalSites,
        ModalSubcategories,
        ModalCategories,
        Modal,
        simpleTable,
        simpleTableSwitchField,
        Multi_select,
    },

    data() {
        return {
            showCategoryModal: false,
            isLoading: false,
            lists: {
                categories: [],
                subcategories: [],
            },
            categoriesFields: [
                {
                    name: 'name',
                    title: 'Nombre',
                    sortField: 'name',
                    titleClass: 'text-left',
                    dataClass: 'text-left',
                    width: '40%',
                },
                {
                    name: 'description',
                    title: 'Descripcion',
                    sortField: 'description',
                    titleClass: 'text-left',
                    dataClass: 'text-left',
                    width: '40%',
                },
                {
                    name: 'actions-slot',
                    title: 'Actions',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                    width: '20%',
                },
            ],
            subcategoriesFields: [
                {
                    name: 'name',
                    title: 'Nombre',
                    sortField: 'name',
                    titleClass: 'text-left',
                    dataClass: 'text-left',
                    width: '700px',
                },
                {
                    name: 'category_id',
                    title: 'Categoria',
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
                    name: 'description',
                    title: 'Descripcion',
                    sortField: 'description',
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
            sitesFields: [
                {
                    name: 'name',
                    title: 'Nombre',
                    sortField: 'name',
                    titleClass: 'text-left',
                    dataClass: 'text-left',
                    width: '700px',
                },
                {
                    name: 'description',
                    title: 'Descripcion',
                    sortField: 'description',
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
            newEditingItem: {},
        }
    },

    computed: {
        categoriesUrl() {
            return route('categories.all')
        },

        subcategoriesUrl() {
            return route('subcategories.all')
        },

        sitesUrl() {
            return route('sites.all')
        },
    },

    methods: {
        openCreateEditModal(element, item, index) {
            if (element) {
                if (item?.id) {
                    this.newEditingItem = item
                }
                this.$refs[`${element}Modal`].showModal = true
            }
        },

        reloadTable(tableReference, vuetableReference) {
            this.$refs[tableReference].$refs[vuetableReference].reload()
        },

        closeCreateEditModal() {
            this.showNewSettingModal = false
            this.resetSettingData()
        },

        getListsValueById(id, element) {
            return this.lists[element].filter(item => item.id === id)[0]
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

        removeElement(element, removeUrl, item, index) {
            if (element) {
                this.$swal({
                    icon: 'warning',
                    title: 'Está seguro de que desea eliminar este elemento?',
                    showCancelButton: true,
                    confirmButtonText: `Eliminar`,
                    cancelButtonText: `Cancelar`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.isLoading = true
                        axios.delete(route(removeUrl, item.id))
                            .then(response => {
                                if (response.status === 200) {
                                    this.isLoading = false
                                    dialog.success(response.data.message)
                                    this.reloadTable(`${element}Table`, `${element}VueTable`)
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
            }
        },
        savedElement(element) {
            this.reloadTable(`${element}Table`, `${element}VueTable`)
            this.newEditingItem = {}
        }
    },

    created() {
    },

    mounted() {
        this.getLists(['categories', 'subcategories', 'sites'])
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
