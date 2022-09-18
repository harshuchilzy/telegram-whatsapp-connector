<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/inertia-vue3';
import Swal from 'sweetalert2'
import { ref } from 'vue';
import VueQrcode from '@chenfengyuan/vue-qrcode';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
// Swal.fire({
//   title: 'Error!',
//   text: 'Do you want to continue',
//   icon: 'error',
//   confirmButtonText: 'Cool'
// })
// Whatsapp
const qrCode = ref('empty')
Echo.channel('whatsapp').listen('WhatsappEvent', (e) => {
    qrCode.value = e.data.qr
    console.log(e.data.qr)
    console.log("QR received")
});

const serverStats = ref({
    whatsapp: 'not connected',
    telegram: 'not connected'
});
async function checkStatuses() {
    let whatsapp = await axios.get(usePage().props.value.telesapp + '/whatsapp/status');
    let telegram = await axios.get(usePage().props.value.telesapp + '/telegram/status');
    serverStats.value.whatsapp = whatsapp.data.status;
    serverStats.value.telegram = telegram.data.status;
    console.log(serverStats.value)
}
checkStatuses();

// Telegram
const telegram = useForm({
    phoneNumber: '',
    phoneCode: ''
})
function submitPhoneNumber(){
    Inertia.post(route('api.telegram.webhook', {
        type: 'auth-phone-number',
        phoneNumber: telegram.phoneNumber
    }))
}
const teleQrCode = ref('empty')

Echo.channel('telegramChannel').listen('TelegramEvent', (e) => {
    console.log(e.data)
    if(e.data.qr !== undefined){
        teleQrCode.value = e.data.qr
    }
})
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
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-2 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 h-full">

                        <div v-if="serverStats.telegram == 'not connected'" class="grid grid-cols-2 gap-6 items-center h-full">
                            <div v-if="teleQrCode == 'empty'">
                                <div class="flex justify-center items-center">
                                    <div class="spinner-border animate-spin inline-block w-16 h-16 border-4 rounded-full" role="status">
                                        <span class="visually-hidden">Loading</span>
                                    </div>
                                </div>
                            </div>
                            <vue-qrcode v-else :value="'tg://login?token=' + teleQrCode" :options="{ width: '100%' }" ></vue-qrcode>
                            <div>
                                <h1 class="text-lg font-bold">Log in to Telegram by QR Code</h1>
                                <ol class="text-md font-bold mt-6">
                                    <li>Open Telegram on your phone</li>
                                    <li>Go to Settings → Devices → Link Desktop Device</li>
                                    <li>Point your phone at this screen to confirm login</li>
                                    <li>Refresh this page after scanning</li>
                                </ol>
                            </div>
                        </div>
                        <div v-else class="text-center grid grid-cols-2 gap-6 items-center justify-center col-span-2">      
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#56cc6c" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                            <span class="text-xl bg-green-500 text-white py-2 px-4 text-center rounded-full">{{ serverStats.whatsapp }}</span>
                        </div>

                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white bg-[url('../whatsapp-bg.jpeg')] bg-contain bg-repeat h-full border-b border-gray-200">
                        <div v-if="serverStats.whatsapp === 'not connected'" class="grid grid-cols-2 gap-6 items-center h-full">
                            <div v-if="qrCode == 'empty'">
                                <div class="flex justify-center items-center">
                                    <div class="spinner-border animate-spin inline-block w-16 h-16 border-4 rounded-full" role="status">
                                        <span class="visually-hidden">Loading</span>
                                    </div>
                                </div>
                            </div>
                            <vue-qrcode v-else :value="qrCode" :options="{ width: '100%' }"></vue-qrcode>
                            <div>
                                <h1 class="text-lg font-bold">To use Whatsapp on this system</h1>
                                <ol class="text-md font-bold mt-6">
                                    <li>Open Whatsapp on your phone</li>
                                    <li>Tap "Menu" or "Settings" and select Linked devices</li>
                                    <li>Point your phone to this screen to capture the code</li>
                                    <li>Refresh this page after scanning</li>
                                </ol>
                            </div>
                        </div>
                        <div v-else class="text-center grid grid-cols-2 gap-6 items-center justify-center col-span-2">      
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#56cc6c" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                            <span class="text-xl bg-green-500 text-white py-2 px-4 text-center rounded-full">{{ serverStats.whatsapp }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
    