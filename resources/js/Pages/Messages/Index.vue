<script setup>
    import Pagination from '@/Components/Pagination.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { Inertia } from '@inertiajs/inertia';

    const props = defineProps({
    messages: Object,
    accepted: Object,
 
})


    </script>
    
    <template>
        <Head title="Dashboard" />
    
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Meassages
                </h2>
            </template>
    
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="grid grid-cols-10 gap-4">
                            <div class="p-6 bg-white border-b border-gray-200 col-span-5"> 
                                <h1 class="mb-4">Accepted</h1>        
                                <table class="table w-full text-sm text-left text-gray-500 dark:text-gray-400" id="datatable_1">
                                    <thead class="text-xs text-white uppercase bg-gray-50 dark:bg-slate-700 dark:text-white">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Derections
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Sender
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Message
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="accepted in accepted" :key="accepted.id" class="bg-white border-b border-gray-100 text-black">
                                            <th scope="row" class="px-6 py-4 font-medium text-black dark:text-dark whitespace-nowrap">
                                                {{ accepted.direction }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{accepted.sender}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{accepted.message}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{accepted.action}}
                                            </td>
                                        
                                        </tr>
                                    </tbody>
                                </table> 
                            
                            </div>

                            <div class="p-6 bg-white border-b border-gray-200 col-span-5">
                                <h1 class="mb-4">Rejected</h1>      
                                <table class="table w-full text-sm text-left text-gray-500 dark:text-gray-400" id="datatable_1">
                                    <thead class="text-xs text-white uppercase bg-gray-50 dark:bg-slate-700 dark:text-white">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Derections
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Sender
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Message
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="message in messages" :key="message.id"  class="bg-white border-b border-gray-100 text-black" >
                                        
                                                <th scope="row" class="px-6 py-4 font-medium text-black dark:text-dark whitespace-nowrap">
                                                    {{ message.direction }}
                                                </th>
                                                <td class="px-6 py-4">
                                                    {{message.sender}}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{message.message}}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{message.action}}
                                                </td>
                                          
                                        </tr>
                                    </tbody>
                                </table> 
                            
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </template>
    