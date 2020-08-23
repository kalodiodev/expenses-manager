<template>
    <v-dialog :value="dialog" max-width="800px" persistent fullscreen hide-overlay transition="dialog-bottom-transition">
        <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" dark class="mb-2" v-bind="attrs" @click="newDialog">{{ newBtn }}</v-btn>
        </template>
        <v-card>
            <v-toolbar dark color="primary">
                <v-btn icon dark @click="close">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
                <v-toolbar-title>{{ title }}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn dark text @click="save">Save</v-btn>
                </v-toolbar-items>
            </v-toolbar>

            <v-card-text>
                <v-row>
                    <v-col cols="12" md="4" class="text-center">
                        <v-date-picker v-model="editedItem.date" class="align-content-center"></v-date-picker>
                    </v-col>

                    <v-col cols="12" md="6">
                        <v-textarea
                            v-model="editedItem.description"
                            :rows="3"
                            label="Description"></v-textarea>

                        <v-text-field
                            v-model="editedItem.cost"
                            type="number"
                            step="0.01"
                            label="Cost"></v-text-field>

                    </v-col>
                </v-row>

            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                <v-btn color="blue darken-1" text @click="save">Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    props: {
        dialog: {
            default: false,
            type: Boolean
        },
        title: {
            type: String
        },
        newBtn: {
            type: String,
            default: "New"
        },
        editedItem: {
            type: Object
        }
    },
    data() {
        return {
        }
    },
    methods: {
        newDialog() {
            this.$emit('new-dialog');
        },
        close() {
            this.$emit('close-dialog');
        },
        save() {
            this.$emit('save-dialog', this.editedItem);
        },
    }
}
</script>
