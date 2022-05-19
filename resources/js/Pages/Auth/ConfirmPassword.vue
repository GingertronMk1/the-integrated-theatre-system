<script setup>
import ValidationErrors from "@/Components/ValidationErrors";

const form = useForm({
    password: "",
});

const submit = () => {
    form.post(route("password.confirm"), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <DefaultLayout>
        <Head title="Confirm Password" />

        <div class="mb-4 text-sm text-gray-600">
            This is a secure area of the application. Please confirm your
            password before continuing.
        </div>

        <ValidationErrors />

        <v-card>
            <v-form class="flex flex-col" @submit.prevent="submit">
                <v-icon color="blue darken-2" class="mx-auto text-h1">
                    mdi-drama-masks
                </v-icon>
                <div>
                    <v-text-field
                        id="password"
                        v-model="form.password"
                        label="Password"
                        type="password"
                        required
                        autocomplete="current-password"
                        autofocus
                    />
                </div>
                <v-btn
                    class="ml-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                    v-text="`Confirm`"
                />
            </v-form>
        </v-card>
    </DefaultLayout>
</template>
