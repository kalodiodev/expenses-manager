<template>
    <v-app id="inspire">
        <v-navigation-drawer v-model="drawer" app>
            <v-list dense>
                <v-list-item link :to="{ name: 'dashboard'}" style="text-decoration: none;" exact>
                    <v-list-item-action>
                        <v-icon>mdi-home</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>{{ $t('Dashboard') }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link :to="{ name: 'expense-categories'}" style="text-decoration: none;">
                    <v-list-item-action>
                        <v-icon>mdi-folder</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>{{ $t('Expense Categories') }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link :to="{ name: 'expenses'}" style="text-decoration: none;">
                    <v-list-item-action>
                        <v-icon>mdi-cash</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>{{ $t('Expenses') }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link :to="{ name: 'income-categories'}" style="text-decoration: none;">
                    <v-list-item-action>
                        <v-icon>mdi-folder</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>{{ $t('Income Categories') }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link :to="{ name: 'incomes'}" style="text-decoration: none;">
                    <v-list-item-action>
                        <v-icon>mdi-cash</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>{{ $t('Incomes') }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>

            <template v-slot:append>
                <LanguageSwitchComponent></LanguageSwitchComponent>
            </template>
        </v-navigation-drawer>

        <v-app-bar app color="blue" light>
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>Expenses Manager</v-toolbar-title>
        </v-app-bar>

        <v-main class="fill-height">
            <router-view></router-view>
        </v-main>
        <v-footer color="blue" app light>
            <span class="white--text">&copy; TNS-DEVELOPMENT</span>
        </v-footer>
    </v-app>
</template>

<script>
import LanguageSwitchComponent from "./components/LanguageSwitchComponent";

export default {
    components: {
        LanguageSwitchComponent
    },
    data() {
        return {
            drawer: true,
        }
    },
    created() {
        const locale = localStorage.getItem("locale");

        if (locale) {
            this.$i18n.locale = locale;
        } else if (navigator.language) {
            this.$i18n.locale = navigator.language.substring(0, 2);
        }
    }
}
</script>
