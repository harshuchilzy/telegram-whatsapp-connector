<script setup>
import Pagination from '@/Components/Pagination.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import moment from 'moment'
const props = defineProps({
    messages: Object,
    accepted: Object,
});

function formatDate(dateString){
    var date = new Date(dateString);
    return moment(date).format('Do, MMM YYYY, h:mm:ss.SSS a');
}

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
                    <div class="">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h1 class="mb-4 text-2xl text-green-600 text-center">Accepted</h1>
                            <table class="table w-full text-sm text-left text-gray-500 dark:text-gray-400" id="datatable_1">
                                <thead class="text-xs text-black uppercase bg-gray-50 dark:bg-slate-700 dark:text-white">
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
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Time
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="accepted in accepted.data" :key="accepted.id" class="bg-white border-b border-gray-100 text-black">
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
                                        <td class="px-6 py-4">
                                            {{formatDate(accepted.updated_at)}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <Pagination class="my-2" :links="accepted.links" />

                        </div>

                        <div class="p-6 bg-white border-b border-gray-200 mt-6">
                            <h1 class="mb-4 text-2xl text-red-600 text-center">Rejected</h1>
                            <table class="table w-full text-sm text-left text-gray-500 dark:text-gray-400" id="datatable_1">
                                <thead class="text-xs text-black uppercase bg-gray-50 dark:bg-slate-700 dark:text-white">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Direction
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Sender
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Message
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
                                    <tr v-for="message in messages.data" :key="message.id" class="bg-white border-b border-gray-100 text-black">
                                        <th scope="row" class="px-6 py-4 font-medium text-black dark:text-dark whitespace-nowrap capitalize">
                                            {{ message.direction }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{message.sender}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{message.message}}
                                        </td>
                                        <td class="px-6 py-4 capitalize">
                                            {{message.action}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{formatDate(message.updated_at)}}
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                            <Pagination class="my-2" :links="messages.links" />

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
    