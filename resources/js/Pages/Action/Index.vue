<script setup>
import Pagination from '@/Components/Pagination.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import moment from 'moment';
const props = defineProps({
    actions: Object,
})
function formatDate(dateString) {
    var date = new Date(dateString);
    return moment(date).format('Do, MMM YYYY, h:mm:ss a');
}
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
                        <div class="p-6 bg-white border-b border-gray-200 col-span-12 break-all">
                            <table class="table w-full text-sm text-left text-gray-500 dark:text-gray-400" id="datatable_1">
                                <thead class="text-xs text-black uppercase bg-gray-50 dark:bg-slate-700 dark:text-white">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Message
                                        </th>
                                        <!-- <th scope="col" class="px-6 py-3">
                                            Model id
                                        </th> -->
                                        <th scope="col" class="px-6 py-3">
                                            Action
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Log
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Time
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="action in actions.data" :key="action.id" class="bg-white border-b border-gray-100 text-black">
                                        <th scope="row" class="px-6 py-4 font-medium text-black dark:text-dark whitespace-nowrap">
                                            <!-- <div v-show='action.model == "App\\Models\\Message"'>
                                                <a href="">Message</a>
                                            </div> -->
                                            {{action.model}}
                                        </th>
                                        <!-- <td class="px-6 py-4">
                                            {{action.model_id}}
                                        </td> -->
                                        <td class="px-6 py-4 capitalize">
                                            {{action.action}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{action.log}}
                                        </td>
                                        <td class="px-6 py-4 capitalize">
                                            {{action.status}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{formatDate(action.updated_at)}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <Pagination class="my-2" :links="actions.links" />
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
    