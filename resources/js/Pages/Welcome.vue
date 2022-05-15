<script setup>
defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Authenticated>
        <v-alert type="success"> V-Alert </v-alert>
    </Authenticated>
</template>
