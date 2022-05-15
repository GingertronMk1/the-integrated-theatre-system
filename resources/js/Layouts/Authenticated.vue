<template>
    <v-app>
        <v-navigation-drawer app expand-on-hover rail>
            <v-list v-if="$page?.props?.auth?.user || false">
                <v-list-item>
                    <svg
                        class="ml-2 -mr-0.5 h-4 w-4"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        />
                    </svg>

                    {{ $page.props.auth.user.name }}
                </v-list-item>
            </v-list>
            <template #append>
                <div class="pa-2">
                    <v-btn block>
                        <Link :href="route('logout')" method="post" as="button">
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
