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
    export default {
        mounted() {
            this.fetchEntries(this.page);
        },
        data() {
            return {
                loading: false,
                page: 1,
                totalPages: 1,
                totalEntries: 0,
                toEntry: 0,
                fromEntry: 0,
                searchTerm: '',
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
            }
        }
    }
</script>
