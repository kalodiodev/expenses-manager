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
                            <v-toolbar-title>Incomes</v-toolbar-title>

                            <v-divider class="mx-4" inset vertical></v-divider>

                            <v-spacer></v-spacer>

                            <income-form-component
                                :dialog="dialog"
                                :editedItem="editedItem"
                                :title="dialogTitle"
                                :new-btn="'New Income'"
                                @new-dialog="newItem"
                                @save-dialog="save($event)"
                                @close-dialog="close"></income-form-component>

                        </v-toolbar>

                        <v-row class="flex-row justify-space-between">
                            <v-col cols="12" sm="6" md="3">
                                <v-col class="d-flex" cols="12" sm="6">
                                    <v-select item-text="name"
                                              item-value="id"
                                              :items="categories"
                                              v-model="categoryId"
                                              :label='"Category"'
                                              clearable
                                              @change="fetchEntries(1)"></v-select>
                                </v-col>
                            </v-col>

                            <search-component v-model="searchTerm"
                                              @search="search"
                                              @cleared="clearSearch"></search-component>
                        </v-row>
                    </template>

                    <template v-slot:item.date="{ item }">
                        {{ $d( new Date(item.date), 'short') }}
                    </template>

                    <template v-slot:item.category="{ item }">
                        <v-btn fab height="15px" width="15px" :color="item.category.color" class="mr-2"></v-btn> {{ item.category.name }}
                    </template>

                    <template v-slot:item.amount="{ item }">
                        {{ $n(item.amount, "currency") }}
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
import IncomeFormComponent from "./IncomeFormComponent";
import ConfirmDialogComponent from "./ConfirmDialogComponent";
import SearchComponent from "./SearchComponent";
import table from "../mixins/table";

export default {
    mixins: [table],
    components: {
        IncomeFormComponent,
        SearchComponent,
        ConfirmDialogComponent
    },
    data() {
        return {
            baseUrl: '/incomes',
            headers: [
                {
                    text: 'Date',
                    align: 'start',
                    sortable: true,
                    value: 'date',
                },
                {text: 'Description', value: 'description'},
                {text: 'Category', value: 'category'},
                {text: 'Amount', value: 'amount', align: 'end'},
                {text: 'Actions', value: 'actions', sortable: false},
            ],
            newItemDialogTitle: 'New Income',
            editItemDialogTitle: 'Edit Income',
            deleteItemDialogTitle: 'Delete Income',
            deleteItemConfirmMessage: 'Are you sure you want to delete this income?',

            categories: [],
            categoryId: null
        }
    },
    mounted() {
        this.fetchCategories()
    },
    methods: {
        entriesUrl: function (page) {
            let url = this.baseUrl + '?page=' + page + "&";

            if (this.categoryId) {
                url += "category=" + this.categoryId + "&";
            }

            url += "search=" + (this.searchTerm ? this.searchTerm : '');

            return url;
        },
        fetchCategories: function () {
            axios.get('/income-categories?nopagination=1')
                .then(res => {
                    this.categories = res.data;
                });
        },
        postData: function (item) {
            return {
                'date': item.date,
                'description': item.description,
                'amount': item.amount,
                'category_id': item.category_id
            }
        },
        newItemObject: function () {
            return {
                date: this.editedItem.date = new Date().toISOString().substr(0,10),
                description: '',
                amount: '',
                category_id: null
            }
        }
    }
}
</script>
