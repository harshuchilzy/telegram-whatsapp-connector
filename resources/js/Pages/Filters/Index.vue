<script setup>
    import Pagination from '@/Components/Pagination.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { Inertia } from '@inertiajs/inertia';

    const props = defineProps({
        tradingFilters: Object,
        currencyFilters: Object
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
                    <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="grid grid-cols-10 gap-4">
                        <div class="p-6 bg-white border-b border-gray-200 col-span-5">
                            <a class="float-left mb-6 px-3 py-1 bg-blue-600 rounded-full text-white hover:bg-blue-700" :href="route('filters.trading')">Add Trading Filters</a>
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
                                    <tr v-for="filter in tradingFilters.data" :key="filter.id" class="bg-white border-b border-gray-100   hover:bg-gray-50 dark:hover:bg-slate-700/50">
                                        <th scope="row" class="px-6 py-4 font-medium text-black dark:text-dark whitespace-nowrap">
                                            {{ filter.match_case }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{filter.exact_match == 1 ? 'Yes' : 'No'}}
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
                            <Pagination class="my-2" :links="tradingFilters.links"/>
                        </div>
                        <div class="p-6 bg-white border-b border-gray-200 col-span-5">
                            <a class="float-right mb-6 px-3 py-1 bg-blue-600 rounded-full text-white hover:bg-blue-700" :href="route('filters.currency')">Add Currency Pairs</a>
                            <table class="table w-full text-sm text-left text-gray-500 dark:text-gray-400" id="datatable_1">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-slate-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Filter Word
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
                                    <tr v-for="filter in currencyFilters.data" :key="filter.id" class="bg-white border-b border-gray-100  dark:hover:text-white  hover:bg-gray-50 dark:hover:bg-slate-700/50">
                                        <th scope="row" class="px-6 py-4 font-medium text-black dark:text-dark whitespace-nowrap">
                                            {{ filter.match_case }}
                                        </th>
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
                            <Pagination class="my-2" :links="currencyFilters.links"/>
                        </div>
                    </div>
                        
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </template>
    