<script setup>
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
const nav_items = ref([
    {
        icon: "mdi-home",
        title: "Home",
        path: route("dashboard"),
    },
    {
        icon: "mdi-ticket",
        title: "Shows",
        path: route("show.index"),
    },
]);

function nav_link(link, params = {}) {
    return Inertia.visit(link, params);
}
</script>

<template>
    <template v-if="$page?.props?.auth?.user">
        <v-app>
            <v-navigation-drawer permanent expand-on-hover rail app>
                <v-list>
                    <v-list-item
                        prepend-icon="mdi-account"
                        :title="$page.props.auth.user.name"
                        :subtitle="$page.props.auth.user.email"
                    />
                </v-list>

                <v-divider />

                <v-list nav dense>
                    <v-list-item
                        v-for="(item, index) in nav_items"
                        :key="index"
                        :prepend-icon="item.icon"
                        :title="item.title"
                        @click="nav_link(item.path)"
                    />
                </v-list>
                <template #append>
                    <div class="pa-2">
                        <v-btn block>
                            <Link
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </Link>
                        </v-btn>
                    </div>
                </template>
            </v-navigation-drawer>

            <v-app-bar app>
                <slot name="header" />
            </v-app-bar>

            <!-- Sizes your content based upon application components -->
            <v-main>
                <v-container fluid>
                    <slot />
                </v-container>
            </v-main>
        </v-app>
    </template>
    <template v-else>
        <v-app>
            <!-- Sizes your content based upon application components -->
            <v-main>
                <v-container fluid>
                    <slot />
                </v-container>
            </v-main>
        </v-app>
    </template>
</template>
