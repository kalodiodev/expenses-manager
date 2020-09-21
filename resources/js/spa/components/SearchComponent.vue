<template>
    <v-col cols="12" sm="6" md="3" class="align-self-center">
        <v-text-field
            :value="value"
            @input="input"
            @keypress.enter="search"
            @blur="search"
            @click:clear="clear"
            :label='$t("Search")'
            clearable
        ></v-text-field>
    </v-col>
</template>

<script>
export default {
    props: {
        value: {
            default: '',
            type: String
        }
    },
    data() {
        return {
            dirty: false,
            cleared: true,
            submitted: false
        }
    },
    methods: {
        input($event) {
            if (this.cleared && !$event) return

            this.dirty = true
            this.cleared = false
            this.$emit('input', $event)
        },
        clear() {
            this.$emit('input', '')
            if (!this.cleared && this.submitted) this.$emit('cleared')

            this.dirty = false
            this.cleared = true
            this.submitted = false
        },
        search() {
            if (this.dirty && !this.cleared) {
                this.$emit('search')
                this.submitted = true;
            }

            this.dirty = false
            this.cleared = false
        }
    }
}
</script>
