<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import Swal from 'sweetalert2';

const props = defineProps({
    token: Object,
    settings: Object
})

const form = useForm({
    whatsappNumber: props.settings.whatsappNumber,
    telegramChatID: props.settings.telegramChatID,
    email: props.settings.email,
    system_status: props.settings.system_status
})
function submit() {
    Inertia.post(route('settings.store'), form);
}

const tokenForm = useForm({
    token_name: ''
})

function submitToken() {
    Inertia.post(route('user.token.create', props.token), tokenForm);
}

const ig = useForm({
    igApiKey: props.settings.igApiKey,
    igUsername: props.settings.igUsername,
    igPassword: ''
});
function submitIG(){
    Inertia.post(route('settings.store'), ig);
}
</script>
    
<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Settings
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit" class="px-8 pt-6 pb-8 mb-4">
                            <h1 class="my-3 font-bold">Whatsapp Section</h1>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="match_case">
                                        Whatsapp Number
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="whatsapp_number" type="text" v-model="form.whatsappNumber" placeholder="Whatsapp Number">
                                </div>
                            </div>

                            <h1 class="my-3 font-bold">Telegram Details</h1>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="match_case">
                                        Chat ID
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="chat_id" type="text" v-model="form.chat_id" placeholder="Chat ID">
                                </div>
                            </div>

                            <h1 class="my-3 font-bold">General Settings</h1>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="match_case">
                                        Email
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="mail" v-model="form.email" placeholder="Email">
                                </div>
                                <div class="mb-4 md:items-center md:flex">
                                    <label class="md:w-2/3 block text-gray-500 font-bold mt-5">
                                        <input class="mr-2 leading-tight" type="checkbox" id="system_status" v-model="form.system_status" checked>
                                        <span class="text-sm">
                                            System Status
                                        </span>
                                    </label>
                                </div>
                            </div>


                            <div class="flex items-center justify-between">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                    Update Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submitIG" class="px-8 pt-6 pb-8 mb-4">
                            <h1 class="my-3 font-bold">IG Trader</h1>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="igAPIKey">
                                    IG API Key
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="igAPIKey" type="text" v-model="ig.igApiKey" placeholder="API Key">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="igUsername">
                                        IG Username
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="igUsername" type="text" v-model="ig.igUsername" placeholder="Username">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="igPassword">
                                        IG Password
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="igPassword" type="password" v-model="ig.igPassword" placeholder="Password">
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                    Authenticate
                                </button>
                            </div>                        </form>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submitToken" class="px-8 pt-6 pb-8 mb-4">

                            <h1 class="my-3 font-bold">Token</h1>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="match_case">
                                        Token Name
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="token_name" type="token" v-model="tokenForm.token_name" placeholder="Token Name">
                                </div>

                            </div>
                            {{props.token}}
                            <div class="flex items-center justify-between">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                    Get Token
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
    