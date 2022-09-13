<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {ref} from 'vue';
console.log(telegram)

const form = useForm({
    phoneNumber: '',
    phoneCode: null,
});
// const TelegramClient = new telegram.TelegramClient
const apiId = 19672483
const apiHash = 'b0174da910bcd41bd76bb4633ad2dbf5'
var stringSession = new telegram.sessions.StringSession('')
stringSession = 'dsa'
const client = ref();
function clientInit(){
    client.value = new telegram.TelegramClient(stringSession, apiId, apiHash, {})
    // client.value = await telegram.TelegramClient('', apiId, apiHash, {
    //     connectionRetries: 5,
    // });
}

async function clientStart(){
    clientInit();
    await client.value.start({
        phoneNumber: form.phoneNumber,
        onError: (err) => console.log(err),
    });
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        You're logged in!
                        <div>
                            <InputLabel for="phoneNumber" value="Phone Number" />
                            <TextInput id="phoneNumber" type="text" class="mt-1 block w-full" v-model="form.phoneNumber" @change="clientStart" required autofocus/>
                            <InputError class="mt-2" :message="form.errors.phoneNumber" />
                        </div>

                        <div>
                            <InputLabel for="phoneCode" value="OTP" />
                            <TextInput id="phoneCode" type="number" class="mt-1 block w-full" v-model="form.phoneCode" @change="phoneCode" required/>
                            <InputError class="mt-2" :message="form.errors.phoneCode" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
