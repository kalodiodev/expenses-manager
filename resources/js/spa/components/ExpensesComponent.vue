<template>
    <v-container fluid>
        <v-row>
            <v-col class="text-center">
                <v-data-table :headers="headers"
                              :items="entries"
                              :page="page"
                              :items-per-page="totalEntries"
                              class="elevation-1"
                              :loading="loading"
                              hide-default-footer>

                    <template v-slot:top>
                        <v-toolbar flat color="white">
                            <v-toolbar-title>Expenses</v-toolbar-title>

                            <v-divider class="mx-4" inset vertical></v-divider>

                            <v-spacer></v-spacer>

                            <expense-form-component
                                :dialog="dialog"
                                :editedItem="editedItem"
                                :title="dialogTitle"
                                :new-btn="'New Expense'"
                                @new-dialog="newExpense"
                                @save-dialog="save($event)"
                                @close-dialog="close"></expense-form-component>
                        </v-toolbar>
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
    import ExpenseFormComponent from "./ExpenseFormComponent";
    export default {
        components: {ExpenseFormComponent},
        mounted() {
            this.fetchEntries(this.page);
        },
        data() {
            return {
                dialog: false,
                loading: false,
                page: 1,
                totalPages: 1,
                totalEntries: 0,
                toEntry: 0,
                fromEntry: 0,
                searchTerm: '',
                baseUrl: '/expenses',
                dialogTitle: '',

                editedItem: {},
                editedIndex: -1,

                headers: [
                    {
                        text: 'Date',
                        align: 'start',
                        sortable: true,
                        value: 'date',
                    },
                    {text: 'Description', value: 'description'},
                    {text: 'Cost', value: 'cost'},
                    {text: 'Actions', value: 'actions', sortable: false},
                ],
                entries: [],
            }
        },
        methods: {
            onPageChange() {
                this.fetchEntries(this.page);
            },
            fetchEntries: function (page) {
                this.loading = true;

                axios.get(this.baseUrl + '?page=' + page + "&search=" + (this.searchTerm ? this.searchTerm : ''))
                    .then(res => {
                        this.fromEntry = res.data.from;
                        this.toEntry = res.data.to;
                        this.page = res.data.current_page
                        this.totalEntries = res.data.total
                        this.totalPages = res.data.last_page

                        this.entries = res.data.data;

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
                        'date': item.date,
                        'description': item.description,
                        'cost': item.cost
                    })
                        .then(res => {
                            this.entries[this.editedIndex] = res.data.data
                        })
                        .catch(err => {

                        })
                }

                axios.post(this.baseUrl, {
                    'date': item.date,
                    'description': item.description,
                    'cost': item.cost
                })
                    .then(res => {
                        this.fetchEntries(this.page)
                        this.close();
                    })
                    .catch(err => {

                    })
            },
            newExpense: function () {
                this.dialogTitle = 'New Expense';
                this.editedIndex = -1;
                this.editedItem = {
                    date: this.editedItem.date = new Date().toISOString().substr(0,10),
                    description: '',
                    cost: ''
                };
                this.dialog = true;
            },
        }
    }
</script>
