<template>
    <v-container fluid>
        <v-row >
            <v-col class="text-center">
                <v-data-table :headers="headers"
                              :items="categories"
                              :page="page"
                              :items-per-page="totalEntries"
                              class="elevation-1"
                              hide-default-footer>

                    <template v-slot:top>
                        <v-toolbar flat color="white">
                            <v-toolbar-title>Categories</v-toolbar-title>

                            <v-divider class="mx-4" inset vertical></v-divider>

                            <v-spacer></v-spacer>

                            <v-dialog v-model="dialog" max-width="500px">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn
                                        color="primary"
                                        dark
                                        class="mb-2"
                                        v-bind="attrs"
                                        v-on="on"
                                        @click="formTitle = 'New Category'"
                                    >New Item</v-btn>
                                </template>
                                <v-card>
                                    <v-card-title>
                                        <span class="headline">{{ formTitle }}</span>
                                    </v-card-title>

                                    <v-card-text>
                                        <v-container>
                                            <v-col>
                                                <v-col>
                                                    <v-text-field v-model="editedItem.name" label="Category Name"></v-text-field>
                                                </v-col>
                                                <v-col>
                                                    <v-textarea v-model="editedItem.description" label="Description"></v-textarea>
                                                </v-col>
                                            </v-col>
                                        </v-container>
                                    </v-card-text>

                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                                        <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                        </v-toolbar>

                        <v-container>
                            <v-row class="flex-row-reverse">
                                <v-col cols="12" sm="6" md="3">
                                    <v-text-field
                                        label="Search"
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
    </v-container>
</template>

<script>
    export default {
        data() {
            return {
                dialog: false,
                formTitle: '',
                editedItem: '',

                page: 1,
                totalPages: 1,
                totalEntries: 0,
                search: '',
                toEntry: 0,
                fromEntry: 0,

                headers: [
                    {
                        text: 'ID',
                        align: 'start',
                        sortable: true,
                        value: 'id',
                    },
                    { text: 'Name', value: 'name'},
                    { text: 'Description', value: 'description' },
                    { text: 'Actions', value: 'actions', sortable: false },
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
                axios.get('/expense-categories?page=' + page)
                    .then(res => {
                        this.fromEntry = res.data.from;
                        this.toEntry = res.data.to;
                        this.page = res.data.current_page
                        this.totalEntries = res.data.total
                        this.totalPages = res.data.last_page

                        this.categories = res.data.data;
                    })
                    .catch(err => {

                    })
            },
            close: function () {
                this.dialog = false
                this.editedItem = '';
            },
            save: function () {
                this.close();
            },
            editItem: function (item) {
                this.editedItem = item;
                this.dialog = true;
                this.formTitle = 'Edit Category';
                console.log(item)
            },
            deleteItem: function (item) {
                console.log(item)
            }
        }
    }
</script>
