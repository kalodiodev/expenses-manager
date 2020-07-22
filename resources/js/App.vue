<template>
    <v-app id="inspire">
        <v-navigation-drawer v-model="drawer" app>
            <v-list dense>
                <v-list-item link :to="{ name: 'dashboard'}" style="text-decoration: none;" exact>
                    <v-list-item-action>
                        <v-icon>mdi-home</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Dashboard</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link :to="{ name: 'expense-categories'}" style="text-decoration: none;">
                    <v-list-item-action>
                        <v-icon>mdi-folder</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Expense Categories</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link :to="{ name: 'expenses'}" style="text-decoration: none;">
                    <v-list-item-action>
                        <v-icon>mdi-cash</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Expenses</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar app color="light-blue" light>
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>Expenses Manager</v-toolbar-title>
        </v-app-bar>

        <v-main class="fill-height">
            <router-view></router-view>
        </v-main>
        <v-footer color="light-blue" app light>
            <span class="white--text">&copy; TNS-DEVELOPMENT</span>
        </v-footer>
    </v-app>
</template>

<script>
export default {
    data() {
        return {
            drawer: true,
        }
    }
}
</script>
