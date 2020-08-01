<template>
    <v-dialog :value="dialog" max-width="500px" persistent>
        <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" dark class="mb-2" v-bind="attrs" @click="newDialog">{{ newBtn }}</v-btn>
        </template>
        <v-card>
            <v-card-title>
                <span class="headline">{{ title }}</span>
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
                type: String
            },
            editedItem: {
                type: Object
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
            }
        }
    }
</script>
