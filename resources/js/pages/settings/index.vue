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
            <div class="row pb-5">
                <div class="col-6">
                    <div class="card shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="mb-0">Categorías</h2>
                                </div>
                                <div class="col">
                                    <ul class="nav nav-pills justify-content-end">
                                        <li class="nav-item mr-2 mr-md-0" v-if="can('settings.categories.create')">
                                            <a @click.prevent="openCreateEditModal('category')" href="#"
                                               class="nav-link py-2 px-3 active">
                                                <span class="d-none d-md-block">+ Nueva Categoría</span>
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
                                          :can-export="can('settings.categories.export')"
                                          :can-edit="can('settings.categories.edit')"
                                          :can-delete="can('settings.categories.delete')"
                                          :can-show="can('settings.categories.show')"
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
                                    <h2 class="mb-0">Subcategorías</h2>
                                </div>
                                <div class="col">
                                    <ul class="nav nav-pills justify-content-end">
                                        <li class="nav-item mr-2 mr-md-0" v-if="can('settings.subcategories.edit')">
                                            <a @click.prevent="openCreateEditModal('subcategory')" href="#"
                                               class="nav-link py-2 px-3 active">
                                                <span class="d-none d-md-block">+ Nueva Subcategoría</span>
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
                                          :can-export="can('settings.subcategories.export')"
                                          :can-edit="can('settings.subcategories.edit')"
                                          :can-delete="can('settings.subcategories.delete')"
                                          :can-show="can('settings.subcategories.show')"
                                          @edit="openCreateEditModal('subcategory', ...arguments)"
                                          @delete="removeElement('subcategory','subcategories.remove', ...arguments)">
                            </simple-table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pb-5">
                <div class="col-6">
                    <div class="card shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="mb-0">Sitios Web</h2>
                                </div>
                                <div class="col">
                                    <ul class="nav nav-pills justify-content-end">
                                        <li class="nav-item mr-2 mr-md-0" v-if="can('settings.sites.edit')">
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
                                          :can-export="can('settings.sites.export')"
                                          :can-edit="can('settings.sites.edit')"
                                          :can-delete="can('settings.sites.delete')"
                                          :can-show="can('settings.sites.show')"
                                          @edit="openCreateEditModal('site', ...arguments)"
                                          @delete="removeElement('site','sites.remove', ...arguments)">
                            </simple-table>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="mb-0">Ministerios</h2>
                                </div>
                                <div class="col">
                                    <ul class="nav nav-pills justify-content-end">
                                        <li class="nav-item mr-2 mr-md-0" v-if="can('settings.ministries.edit')">
                                            <a @click.prevent="openCreateEditModal('ministry')" href="#"
                                               class="nav-link py-2 px-3 active">
                                                <span class="d-none d-md-block">+ Nuevo Ministerio</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <simple-table reference="ministryVueTable"
                                          :actionDefaultOptions="['edit', 'delete']"
                                          ref="ministryTable"
                                          :api-url="ministriesUrl"
                                          :has-settings="false"
                                          :has-header="false"
                                          :fields="ministriesFields"
                                          :per-page="5"
                                          paginationFontSize="small"
                                          :can-export="can('settings.ministries.export')"
                                          :can-edit="can('settings.ministries.edit')"
                                          :can-delete="can('settings.ministries.delete')"
                                          :can-show="can('settings.ministries.show')"
                                          :hasCustomActions="false"
                                          @edit="openCreateEditModal('ministry', ...arguments)"
                                          @delete="removeElement('ministry','ministries.remove', ...arguments)">
                            </simple-table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pb-5">
                <div class="col-6">
                    <div class="card shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="mb-0">Entidades</h2>
                                </div>
                                <div class="col">
                                    <ul class="nav nav-pills justify-content-end">
                                        <li class="nav-item mr-2 mr-md-0" v-if="can('settings.entities.edit')">
                                            <a @click.prevent="openCreateEditModal('entity')" href="#"
                                               class="nav-link py-2 px-3 active">
                                                <span class="d-none d-md-block">+ Nueva Entidad</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <simple-table reference="entityVueTable"
                                          :actionDefaultOptions="['edit', 'delete']"
                                          ref="entityTable"
                                          :api-url="entitiesUrl"
                                          :has-settings="false"
                                          :has-header="false"
                                          :fields="entitiesFields"
                                          :per-page="5"
                                          paginationFontSize="small"
                                          :hasCustomActions="false"
                                          :can-export="can('settings.entities.export')"
                                          :can-edit="can('settings.entities.edit')"
                                          :can-delete="can('settings.entities.delete')"
                                          :can-show="can('settings.entities.show')"
                                          @edit="openCreateEditModal('entity', ...arguments)"
                                          @delete="removeElement('entity','entities.remove', ...arguments)">
                            </simple-table>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="mb-0">Enlaces de Internet</h2>
                                </div>
                                <div class="col">
                                    <ul class="nav nav-pills justify-content-end">
                                        <li class="nav-item mr-2 mr-md-0" v-if="can('settings.internet_links.edit')">
                                            <a @click.prevent="openCreateEditModal('internetLink')" href="#"
                                               class="nav-link py-2 px-3 active">
                                                <span class="d-none d-md-block">+ Nuevo Enlace</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <simple-table reference="internetLinkVueTable"
                                          :actionDefaultOptions="['edit', 'delete']"
                                          ref="internetLinkTable"
                                          :api-url="internetLinksUrl"
                                          :has-settings="false"
                                          :has-header="false"
                                          :fields="internetLinksFields"
                                          :per-page="5"
                                          paginationFontSize="small"
                                          :hasCustomActions="false"
                                          :can-export="can('settings.internet_links.export')"
                                          :can-edit="can('settings.internet_links.edit')"
                                          :can-delete="can('settings.internet_links.delete')"
                                          :can-show="can('settings.internet_links.show')"
                                          @edit="openCreateEditModal('internetLink', ...arguments)"
                                          @delete="removeElement('internetLink','internet_links.remove', ...arguments)">
                            </simple-table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pb-5">
                <div class="col-6">
                    <div class="card shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="mb-0">Fuentes de Detección</h2>
                                </div>
                                <div class="col">
                                    <ul class="nav nav-pills justify-content-end">
                                        <li class="nav-item mr-2 mr-md-0" v-if="can('settings.sources.edit')">
                                            <a @click.prevent="openCreateEditModal('source')" href="#"
                                               class="nav-link py-2 px-3 active">
                                                <span class="d-none d-md-block">+ Nueva Fuente</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <simple-table reference="sourceVueTable"
                                          :actionDefaultOptions="['edit', 'delete']"
                                          ref="sourceTable"
                                          :api-url="sourcesUrl"
                                          :has-settings="false"
                                          :has-header="false"
                                          :fields="sourcesFields"
                                          :per-page="5"
                                          paginationFontSize="small"
                                          :hasCustomActions="false"
                                          :can-export="can('settings.sources.export')"
                                          :can-edit="can('settings.sources.edit')"
                                          :can-delete="can('settings.sources.delete')"
                                          :can-show="can('settings.sources.show')"
                                          @edit="openCreateEditModal('source', ...arguments)"
                                          @delete="removeElement('source','sources.remove', ...arguments)">
                            </simple-table>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="mb-0">Entidades (Tributa)</h2>
                                </div>
                                <div class="col">
                                    <ul class="nav nav-pills justify-content-end">
                                        <li class="nav-item mr-2 mr-md-0" v-if="can('settings.contributes.edit')">
                                            <a @click.prevent="openCreateEditModal('contribute')" href="#"
                                               class="nav-link py-2 px-3 active">
                                                <span class="d-none d-md-block">+ Nueva Entidad</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <simple-table reference="contributeVueTable"
                                          :actionDefaultOptions="['edit', 'delete']"
                                          ref="contributeTable"
                                          :api-url="contributesUrl"
                                          :has-settings="false"
                                          :has-header="false"
                                          :fields="contributesFields"
                                          :per-page="5"
                                          paginationFontSize="small"
                                          :hasCustomActions="false"
                                          :can-export="can('settings.contributes.export')"
                                          :can-edit="can('settings.contributes.edit')"
                                          :can-delete="can('settings.contributes.delete')"
                                          :can-show="can('settings.contributes.show')"
                                          @edit="openCreateEditModal('contribute', ...arguments)"
                                          @delete="removeElement('contribute','contributes.remove', ...arguments)">
                            </simple-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modals -->
        <modal-sites ref="siteModal" :item="newEditingItem" @savedComplete="savedElement('site')"/>
        <modal-internet-link ref="internetLinkModal" :item="newEditingItem" @savedComplete="savedElement('internetLink')"/>
        <modal-ministries ref="ministryModal" :item="newEditingItem" @savedComplete="savedElement('ministry')"/>
        <modal-entities ref="entityModal" :item="newEditingItem" @savedComplete="savedElement('entity')"/>
        <modal-categories ref="categoryModal" :item="newEditingItem" @savedComplete="savedElement('category')"/>
        <modal-sources ref="sourceModal" :item="newEditingItem" @savedComplete="savedElement('source')"/>
        <modal-contributes ref="contributeModal" :item="newEditingItem" @savedComplete="savedElement('contribute')"/>
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
import ModalMinistries from './partials/modalMinistries'
import ModalEntities from './partials/modalEntities'
import ModalInternetLink from './partials/modalInternetLinks'
import ModalSources from './partials/modalSources'
import ModalContributes from './partials/modalContributes'

export default {
    name: 'Settings',
    components: {
        ModalContributes,
        ModalSources,
        ModalInternetLink,
        ModalEntities,
        ModalMinistries,
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
                    title: 'Descripción',
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
            internetLinksFields: [
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
                    title: 'Descripción',
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
            entitiesFields: [
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
                    title: 'Descripción',
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
            ministriesFields: [
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
                    title: 'Descripción',
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
                    name: 'description',
                    title: 'Descripción',
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
                    title: 'Descripción',
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
            sourcesFields: [
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
                    title: 'Descripción',
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
            contributesFields: [
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
                    title: 'Descripción',
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

        ministriesUrl() {
            return route('ministries.all')
        },

        entitiesUrl() {
            return route('entities.all')
        },

        internetLinksUrl() {
            return route('internet_links.all')
        },

        sourcesUrl() {
            return route('sources.all')
        },

        contributesUrl() {
            return route('contributes.all')
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
