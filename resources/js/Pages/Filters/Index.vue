<script setup>
    import Pagination from '@/Components/Pagination.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { Inertia } from '@inertiajs/inertia';


    const props = defineProps({
        filters: Object
    })

    function destroy(id){
        Inertia.delete(route('filters.destroy', id));
    }
    </script>
    
    <template>
        <Head title="Dashboard" />
    
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Filters
                </h2>
            </template>
    
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <a class="float-right " :href="route('filters.create')">Add</a>
                            <table class="table w-full text-sm text-left text-gray-500 dark:text-gray-400" id="datatable_1">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-slate-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Filter Word
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Exact match
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Type
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="filter in filters.data" :key="filter.id" class="bg-white border-b border-gray-100 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700/50">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ filter.match_case }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{filter.exact_match}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{filter.type}}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a :href="route('filters.edit', filter.id)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                            <form @submit.prevent="destroy(filter.id)">
                                                <button type="submit" class="text-red-500">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table> 
                            <Pagination class="my-2" :links="filters.links"/>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </template>
    