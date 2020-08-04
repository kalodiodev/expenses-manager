<template>
    <v-container fluid>
        <v-row >
            <v-col class="text-center">
                <v-data-table :headers="headers"
                              :items="categories"
                              :page="page"
                              :items-per-page="totalEntries"
                              class="elevation-1"
                              :loading="loading"
                              hide-default-footer>

                    <template v-slot:top>
                        <v-toolbar flat color="white">
                            <v-toolbar-title>Categories</v-toolbar-title>

                            <v-divider class="mx-4" inset vertical></v-divider>

                            <v-spacer></v-spacer>

                            <category-form-component
                                :dialog="dialog"
                                :editedItem="editedItem"
                                :title="dialogTitle"
                                :newBtn="'New Category'"
                                @new-dialog="newCategory"
                                @save-dialog="save($event)"
                                @close-dialog="close"></category-form-component>
                        </v-toolbar>

                        <v-container>
                            <v-row class="flex-row-reverse">
                                <v-col cols="12" sm="6" md="3">
                                    <v-text-field
                                        v-model="searchTerm"
                                        @keypress.enter="search"
                                        @click:clear="clearSearch"
                                        label="Search"
                                        clearable
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                    </template>

                    <template v-slot:item.actions="{ item }">
                        <v-icon
                            small
                            class="mr-2"
                            @click="editItem(item)"
                        >
                            mdi-pencil
                        </v-icon>
                        <v-icon
                            small
                            @click="deleteItem(item)"
                        >
                            mdi-delete
                        </v-icon>
                    </template>
                </v-data-table>

                <div class="text-center mt-3">
                    <p>{{ fromEntry }} to {{ toEntry }} of {{ totalEntries }} Entries</p>
                </div>

                <div class="mt-3 text-center">
                    <v-pagination
                        v-model="page"
                        :length="totalPages"
                        :total-visible="7"
                        @input="onPageChange"
                    ></v-pagination>
                </div>

            </v-col>
        </v-row>

        <confirm-dialog-component ref="confirm"></confirm-dialog-component>
    </v-container>
</template>

<script>
import CategoryFormComponent from "./CategoryFormComponent";
import ConfirmDialogComponent from "./ConfirmDialogComponent";

export default {
    components: {
        ConfirmDialogComponent,
        CategoryFormComponent
    },
    props: {
        baseUrl: {
            type: String
        }
    },
    data() {
        return {
            dialog: false,
            loading: false,
            dialogTitle: '',

            editedItem: {},
            editedIndex: -1,

            searchTerm: '',

            page: 1,
            totalPages: 1,
            totalEntries: 0,
            toEntry: 0,
            fromEntry: 0,

            headers: [
                {
                    text: 'ID',
                    align: 'start',
                    sortable: true,
                    value: 'id',
                },
                {text: 'Name', value: 'name'},
                {text: 'Description', value: 'description'},
                {text: 'Actions', value: 'actions', sortable: false},
            ],
            categories: [],
        }
    },
    mounted() {
        this.fetchCategories(1);
    },
    methods: {
        onPageChange() {
            this.fetchCategories(this.page);
        },
        fetchCategories: function (page) {
            this.loading = true;

            if (!this.searchTerm) {
                this.searchTerm = '';
            }

            axios.get(this.baseUrl + '?page=' + page + "&search=" + this.searchTerm)
                .then(res => {
                    this.fromEntry = res.data.from;
                    this.toEntry = res.data.to;
                    this.page = res.data.current_page
                    this.totalEntries = res.data.total
                    this.totalPages = res.data.last_page

                    this.categories = res.data.data;

                    this.loading = false;
                })
                .catch(err => {
                    this.loading = false;
                })
        },
        close: function () {
            this.dialog = false
            this.editedItem = {};
            this.editedIndex = -1;
        },
        save: function (item) {
            if (this.editedIndex > -1) {
                axios.patch(this.baseUrl + '/' + item.id, {
                    'name': item.name,
                    'description': item.description
                })
                    .then(res => {
                        this.categories[this.editedIndex] = res.data.data
                    })
                    .catch(err => {

                    })
            }

            axios.post(this.baseUrl, {
                'name': item.name,
                'description': item.description
            })
                .then(res => {
                    this.fetchCategories(this.page)
                    this.close();
                })
                .catch(err => {

                })
        },
        newCategory: function () {
            this.dialogTitle = 'New Category';
            this.editedIndex = -1;
            this.editedItem = {
                name: '',
                description: ''
            };
            this.dialog = true;
        },
        editItem: function (item) {
            this.editedIndex = this.categories.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true;
            this.dialogTitle = 'Edit Category';
        },
        deleteItem: function (item) {
            this.$refs.confirm.open({
                title: 'Delete Category',
                message: 'Are you sure you want to delete this category?',
                confirmText: 'Confirm',
                rejectText: 'Cancel'
            }).then(result => {
                if (result) {
                    axios.delete(this.baseUrl + '/' + item.id)
                        .then(res => {
                            this.fetchCategories(this.page)
                        })
                        .catch(err => {

                        })
                }
            });
        },
        search: function () {
            this.categories = [];
            this.fetchCategories(1);
        },
        clearSearch: function () {
            this.searchTerm = '';
            this.fetchCategories(1);
        },
    }
}
</script>
