<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { Inertia } from '@inertiajs/inertia';
    
    const form = useForm({
        whatsapp_number: '',
        whatsapper_url: '',
        telegram_number: '',
        api_id: '',
        api_hash: '',
        chat_id: '',
        email: '',
        system_status: '',
    })
    function submit(){
        Inertia.post(route('settings.store'), form);
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
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="whatsapp_number" type="text" 
                                    v-model="form.whatsapp_number" placeholder="Whatsapp Number">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="match_case">
                                        Whatsapper URL
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="whatsapper_url"  type="text" 
                                    v-model="form.whatsapper_url" placeholder="Whatsapper URL">
                                </div>
                                </div>
                                <h1 class="my-3 font-bold">Telegram Section</h1>
                                <div class="grid grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="match_case">
                                        Telegram Number
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="api_id" type="text" 
                                    v-model="form.telegram_number" placeholder="Telegram Number">
                                </div>
                                 <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="match_case">
                                        API ID
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="api_id" type="text" 
                                    v-model="form.api_id" placeholder="API ID">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="match_case">
                                        API Hash
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="api_hash"  type="text" 
                                    v-model="form.api_hash" placeholder="API Hash">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="match_case">
                                        Chat ID
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="chat_id" type="text" 
                                    v-model="form.chat_id" placeholder="Chat ID">
                                </div>
                                </div>
                                <h1 class="my-3 font-bold">General Settings</h1>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="match_case">
                                        Email
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email"  type="mail" 
                                    v-model="form.email" placeholder="Email">
                                </div>
                                 <div class="mb-4 md:items-center md:flex">
                                    <label class="md:w-2/3 block text-gray-500 font-bold mt-5">
                                    <input class="mr-2 leading-tight" type="checkbox" id="system_status"  v-model="form.system_status" checked>
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
            </div>
        </AuthenticatedLayout>
    </template>
    