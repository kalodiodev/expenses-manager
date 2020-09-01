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
                        <v-select
                            :items="categories"
                            item-text="name"
                            item-value="id"
                            v-model="editedItem.category_id"
                            label="Category"
                            :error-messages="categoryErrors"
                            @change="$v.editedItem.category_id.$touch()"
                            @blur="$v.editedItem.category_id.$touch()"
                        ></v-select>

                        <v-textarea
                            v-model="editedItem.description"
                            :rows="3"
                            :error-messages="descriptionErrors"
                            @input="$v.editedItem.description.$touch()"
                            @blur="$v.editedItem.description.$touch()"
                            label="Description"></v-textarea>

                        <v-text-field
                            v-model="editedItem.amount"
                            type="number"
                            step="0.01"
                            :error-messages="amountErrors"
                            @input="$v.editedItem.amount.$touch()"
                            @blur="$v.editedItem.amount.$touch()"
                            label="Amount"></v-text-field>

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
import required from "vuelidate/lib/validators/required";
import maxLength from "vuelidate/lib/validators/maxLength";
import decimal from "vuelidate/lib/validators/decimal";
const positive = (value) => value >= 0

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
        },
    },
    mounted() {
        this.fetchCategories()
    },
    data() {
        return {
            categories: [],
        }
    },
    validations: {
        editedItem: {
            category_id: {
                required,
            },
            description: {
                maxLength: maxLength(190)
            },
            amount: {
                positive,
                required,
                decimal
            }
        }
    },
    methods: {
        fetchCategories: function () {
            axios.get('/income-categories?nopagination=1')
                .then(res => {
                    this.categories = res.data;
                });
        },
        newDialog() {
            this.$emit('new-dialog');
        },
        close() {
            this.$v.$reset();

            this.$emit('close-dialog');
        },
        save() {
            this.$v.editedItem.$touch();

            if (this.$v.editedItem.$invalid) return;

            this.$v.$reset();

            this.$emit('save-dialog', this.editedItem);
        },
    },
    computed: {
        categoryErrors() {
            const errors = []
            if (!this.$v.editedItem.category_id.$dirty) return errors
            !this.$v.editedItem.category_id.required && errors.push('Category is required.')

            return errors
        },
        descriptionErrors() {
            const errors = []
            if (!this.$v.editedItem.description.$dirty) return errors
            !this.$v.editedItem.description.maxLength && errors.push('Description must be at most 190 characters long.')

            return errors
        },
        amountErrors() {
            const errors = []
            if (!this.$v.editedItem.amount.$dirty) return errors
            !this.$v.editedItem.amount.required && errors.push('Amount is required.')
            !this.$v.editedItem.amount.decimal && errors.push('Amount must be a number.')
            !this.$v.editedItem.amount.positive && errors.push('Amount must be positive.')

            return errors
        }
    }
}
</script>
