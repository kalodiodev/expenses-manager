<template>
    <categories-component :base-url="'/expense-categories'"></categories-component>
</template>

<script>
import CategoriesComponent from "./CategoriesComponent";

export default {
    components: {CategoriesComponent}
}
</script>
