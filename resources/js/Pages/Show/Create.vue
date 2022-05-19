<script setup>
import { useForm } from "@inertiajs/inertia-vue3";

defineProps({
    venues: {
        type: Array,
        default: () => [],
    },
    seasons: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    name: "",
    description: "",
    default_venue_id: null,
    season_id: null,
});

function submit() {
    form.post(route("shows.store"));
}
</script>
<template>
    <DefaultLayout>
        <template #header>New Show</template>
        <v-form @submit.prevent="submit">
            <v-text-field v-model="form.name" label="Name" required />
            <v-textarea
                v-model="form.description"
                label="Description"
                auto-grow
            />
            <span v-text="form.default_venue_id" />
            <v-select
                v-model="form.default_venue_id"
                :items="venues"
                label="Default Venue"
                item-text="name"
                item-value="name"
                persistent-hint
                return-object
                single-line
            />

            <span v-text="form.season_id" />

            <v-select
                v-model="form.season_id"
                :items="seasons"
                label="Season"
                item-text="name"
                item-value="name"
                persistent-hint
                return-object
                single-line
            />
        </v-form>
    </DefaultLayout>
</template>
