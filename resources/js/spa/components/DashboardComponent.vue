<template>
    <v-container fluid>
        <v-row>
            <v-col class="text-center">
                <div class="text-h3">Dashboard</div>

               <v-simple-table dense>
                    <template v-slot:default class="stats-table">
                        <thead class="stats-head">
                        <tr>
                            <th class="text-left">Period</th>
                            <th class="text-right">Income</th>
                            <th class="text-right">Expenses</th>
                        </tr>
                        </thead>
                        <tbody class="stats-body">
                        <tr
                            v-for="(item, period) in stats"
                            :key="period"
                        >
                            <td class="text-left">{{ period | ucWordFirst }}</td>
                            <td class="text-right">{{  $n(item.income, 'currency') }}</td>
                            <td class="text-right">{{ $n(item.expenses, 'currency') }}</td>
                        </tr>
                        </tbody>
                    </template>
                </v-simple-table>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        mounted() {
            axios.get("/stats")
                .then(res => {
                    this.stats = res.data;
                })
                .catch(err => {

                })
        },
        data() {
            return {
                stats: []
            }
        },
        filters: {
            ucWordFirst: function (value) {
                let result = "";
                let words = value.toString().split(/[ _]+/);

                for(let word in words) {
                    console.log(words[word])
                    result += words[word].charAt(0).toUpperCase() + words[word].slice(1) + " "
                }

                return result.trimEnd();
            }
        }
    }
</script>
