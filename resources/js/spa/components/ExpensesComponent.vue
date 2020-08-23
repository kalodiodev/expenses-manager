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
                                @new-dialog="newItem"
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
    import table from "../mixins/table";

    export default {
        mixins: [table],
        components: {ExpenseFormComponent},
        data() {
            return {
                baseUrl: '/expenses',
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
                newItemDialogTitle: 'New Expense'
            }
        },
        methods: {
            postData: function (item) {
                return {
                    'date': item.date,
                    'description': item.description,
                    'cost': item.cost
                }
            },
            newItemObject: function () {
                return {
                    date: this.editedItem.date = new Date().toISOString().substr(0,10),
                    description: '',
                    cost: ''
                }
            }
        }
    }
</script>
