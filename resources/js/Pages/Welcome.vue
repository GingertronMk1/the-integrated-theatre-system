<script setup>
defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <DefaultLayout>
        <v-alert type="success"> V-Alert </v-alert>
    </DefaultLayout>
</template>
