<template>
    <v-container fluid>
        <v-row >
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
                            <v-toolbar-title>Categories</v-toolbar-title>

                            <v-divider class="mx-4" inset vertical></v-divider>

                            <v-spacer></v-spacer>

                            <category-form-component
                                :dialog="dialog"
                                :editedItem="editedItem"
                                :title="dialogTitle"
                                :newBtn="'New Category'"
                                :exists-url="baseUrl + '/' + 'exists'"
                                @new-dialog="newItem"
                                @save-dialog="save($event)"
                                @close-dialog="close"></category-form-component>
                        </v-toolbar>

                        <v-container>
                            <v-row class="flex-row-reverse">
                                <search-component v-model="searchTerm"
                                                  @search="search"
                                                  @cleared="clearSearch"></search-component>
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
import SearchComponent from "./SearchComponent";
import table from "../mixins/table";

export default {
    mixins: [table],
    components: {
        SearchComponent,
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
            headers: [
                {text: 'Name', value: 'name'},
                {text: 'Description', value: 'description'},
                {text: 'Actions', value: 'actions', sortable: false},
            ],

            newItemDialogTitle: 'New Category',
            editItemDialogTitle: 'Edit Category',
            deleteItemDialogTitle: 'Delete Category',
            deleteItemConfirmMessage: 'Are you sure you want to delete this category?'
        }
    },
    methods: {
        postData: function (item) {
            return {
                'name': item.name,
                'description': item.description
            }
        },
        newItemObject: function () {
            return {
                name: '',
                description: ''
            }
        },
    }
}
</script>
