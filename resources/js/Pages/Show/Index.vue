<script setup>
defineProps({
    shows: {
        type: Array,
        default: () => [],
    },
});
</script>
<template>
    <DefaultLayout>
        <Head>Shows</Head>
        <template #header>
            <h2>Shows</h2>
            <v-btn color="secondary" class="ml-auto">
                <Link
                    :href="route('show.create')"
                    class="text-black text-decoration-none"
                >
                    <v-icon>mdi-plus</v-icon>
                    Add Show
                </Link>
            </v-btn>
        </template>
        <v-card
            v-for="show in shows"
            :key="show.id"
            :subtitle="show.default_venue?.name"
            :text="show.description"
            class="mb-3"
        >
            <template #title>
                <div class="d-flex justify-space-between align-center w-100">
                    <h4>
                        <Link
                            :href="route('show.show', show.id)"
                            class="text-black text-decoration-none"
                            v-text="show.name"
                        />
                    </h4>
                    <span>
                        <v-icon :color="show.season?.colour">
                            mdi-checkbox-blank-circle
                        </v-icon>
                        <v-tooltip anchor="start" activator="parent">
                            {{ show.season?.name }}
                        </v-tooltip>
                    </span>
                </div>
            </template>
        </v-card>
    </DefaultLayout>
</template>
