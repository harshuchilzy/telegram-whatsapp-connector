<script setup>
    import Pagination from '@/Components/Pagination.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { Inertia } from '@inertiajs/inertia';

    const props = defineProps({
        actions: Object,
})
    </script>
    
    <template>
        <Head title="Dashboard" />
    
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Logs
                </h2>
            </template>
    
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="grid grid-cols-10 gap-4">
                            <div class="p-6 bg-white border-b border-gray-200 col-span-12"> 
                                <table class="table w-full text-sm text-left text-gray-500 dark:text-gray-400" id="datatable_1">
                                    <thead class="text-xs text-black uppercase bg-gray-50 dark:bg-slate-700 dark:text-white">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Model
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Model id
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Action
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Log
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Status
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="action in actions" :key="action.id" class="bg-white border-b border-gray-100 text-black">
                                            <th scope="row" class="px-6 py-4 font-medium text-black dark:text-dark whitespace-nowrap">
                                                {{ action.model }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{action.model_id}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{action.action}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{action.log}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{action.status}}
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
    