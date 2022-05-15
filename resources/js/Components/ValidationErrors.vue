<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
const errors = computed(() => usePage().props.value.errors);
const hasErrors = computed(() => Object.keys(errors.value).length > 0);
</script>

<template>
    <template v-if="hasErrors">
        <v-alert
            v-for="(error, index) in errors"
            :key="index"
            type="error"
            class="mb-4"
        >
            {{ error }}
        </v-alert>
    </template>
</template>
