<script setup>
import { Head, useForm } from "@inertiajs/inertia-vue3";
import ValidationErrors from "@/Components/ValidationErrors";

defineProps({
    status: {
        type: String,
        default: "",
    },
});

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("password.email"));
};
</script>

<template>
    <DefaultLayout>
        <Head title="Forgot Password" />

        <ValidationErrors />

        <v-card>
            <div class="mb-4 text-sm text-gray-600">
                Forgot your password? No problem. Just let us know your email
                address and we will email you a password reset link that will
                allow you to choose a new one.
            </div>

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <v-form class="flex flex-col" @submit.prevent="submit">
                <div>
                    <v-text-field
                        id="email"
                        v-model="form.email"
                        label="Email"
                        type="email"
                        required
                        autofocus
                        autocomplete="username"
                    />
                </div>
                <v-btn
                    class="ml-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                    v-text="`Email Password Reset Link`"
                />
            </v-form>
        </v-card>
    </DefaultLayout>
</template>
