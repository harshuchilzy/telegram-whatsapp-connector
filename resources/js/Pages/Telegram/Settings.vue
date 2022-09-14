<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    appId: String,
    appHash: String
})
const form = useForm({
    appId: props.appId,
    appHash: props.appHash
});

function submit() {
    Inertia.post(route('telegram.settings.store'), form);
}
</script>
    
<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Telegram Settings
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="mb-6">
                                <InputLabel for="appId" value="App ID" />
                                <TextInput id="appId" type="text" class="mt-1 block w-full" v-model="form.appId" required autofocus />
                                <InputError class="mt-2" :message="form.errors.appId" />
                            </div>

                            <div class="mb-6">
                                <InputLabel for="appHash" value="App Hash" />
                                <TextInput id="appHash" type="text" class="mt-1 block w-full" v-model="form.appHash" required />
                                <InputError class="mt-2" :message="form.errors.appHash" />
                            </div>
                            <PrimaryButton>Save Settings</PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
    