<template>
    <v-container>
        <v-row class="flex-row-reverse">
            <v-col cols="12" sm="6" md="3">
                <v-text-field
                    :value="value"
                    @input="$emit('input', $event)"
                    @keypress.enter="$emit('search')"
                    @click:clear="$emit('input', '')"
                    :label='$t("Search")'
                    clearable
                ></v-text-field>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    props: {
        value: {
            default: '',
            type: String
        }
    }
}
</script>
