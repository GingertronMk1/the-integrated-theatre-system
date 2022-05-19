<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import ValidationErrors from "@/Components/ValidationErrors";

defineProps({
    canResetPassword: {
        type: Boolean,
        default: true,
    },
    status: {
        type: String,
        default: "",
    },
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <DefaultLayout>
        <Head title="Log in" />

        <ValidationErrors />

        <v-card>
            <v-form class="flex flex-col" @submit.prevent="submit">
                <v-icon color="blue darken-2" class="mx-auto text-h1">
                    mdi-drama-masks
                </v-icon>
                <div>
                    <v-text-field
                        id="email"
                        v-model="form.email"
                        label="Email"
                        type="email"
                        required
                        autofocus
                        autocomplete="username"
                        hide-details
                    />

                    <v-text-field
                        id="password"
                        v-model="form.password"
                        label="Password"
                        type="password"
                        required
                        autocomplete="current-password"
                        hide-details
                    />
                </div>

                <div class="flex content-between items-center px-3">
                    <v-checkbox
                        v-model="form.remember"
                        name="remember"
                        label="Remember Me"
                        color="blue"
                        hide-details
                        class="flex-grow-0"
                    />

                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="ml-auto"
                    >
                        Forgot your password?
                    </Link>

                    <v-btn
                        class="ml-4"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        type="submit"
                        v-text="`Log in`"
                    />
                </div>
            </v-form>
        </v-card>
    </DefaultLayout>
</template>
