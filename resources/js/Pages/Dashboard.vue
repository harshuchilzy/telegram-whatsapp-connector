<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import Swal from 'sweetalert2'

const props = defineProps({
    accounts: Object,
    orders: Object,
    positions: Object
})

function formatCurrency(currencyCode) {
    if (currencyCode == 'USD') {
        return '$';
    } else if (currencyCode == 'EUR') {
        return '€';
    } else if (currencyCode == 'GBP') {
        return '£';
    } else {
        return currencyCode;
    }
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
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-6 mb-5">
                <div class="overflow-hidden grid grid-cols-3 gap-4">
                    <div v-for="account in accounts.accounts" :key="account.accountId">
                        <div class="bg-white p-5 m-5 shadow-lg sm:rounded-lg">
                            <p class="text-center bg-emerald-400 rounded-full"><small class="p-1 text-white uppercase">Market Status - <b class="text-white">{{ account.status }}</b></small></p>

                            <div class="grid grid-cols-2 gap-4 my-2">
                                <div>
                                    <h1><small>Account ID</small></h1> <b>{{ account.accountId }}</b>
                                </div>
                                <div>
                                    <p><small>Account Name</small></p><b>{{ account.accountName }}</b>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="avalible">
                                    <p class="font-bold">Current balance</p> {{ formatCurrency(account.currency) }}{{ account.balance.available }}
                                </div>
                                <div class="blance">
                                    <p class="font-bold">Opening balance</p> {{ formatCurrency(account.currency) }}{{ account.balance.balance }}
                                </div>
                                <div class="deposit">
                                    <p class="font-bold">Deposit</p> {{ formatCurrency(account.currency) }}{{ account.balance.deposit }}
                                </div>
                                <div class="profit">
                                    <p class="font-bold">Profit/Loss</p> {{ formatCurrency(account.currency) }}{{ account.balance.profitLoss }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-3">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h1 class="mb-4">Current Working Orders</h1>
                        <table class="table w-full text-sm text-left text-gray-500 dark:text-gray-400" id="datatable_1">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-slate-700 dark:text-white">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        MARKET
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        DERECTION
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        SIZE
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        LEVEL
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        LAST
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        STOP
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        LIMIT
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        ORDER TYPE
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        GOOD TILL
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="order in orders.workingOrders" :key="order.id" class="dark:hover:text-white bg-white border-b border-gray-100 hover:bg-gray-50 dark:hover:bg-slate-700/50">
                                    <th scope="row" class="px-6 py-4 font-medium text-black dark:text-dark whitespace-nowrap">
                                        {{ order.marketData.instrumentName }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ order.workingOrderData.direction }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ order.workingOrderData.size }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ order.workingOrderData.level }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ order.marketData.offer }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ order.workingOrderData.contingentStop }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ order.workingOrderData.contingentLimit }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ order.workingOrderData.requestType }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ order.workingOrderData.goodTill }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h1 class="mb-4">Current Positions</h1>
                        <table class="table w-full text-sm text-left text-gray-500 dark:text-gray-400" id="datatable_1">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-slate-700 dark:text-white">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        MARKET
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        DERECTION
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        SIZE
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        OPENING
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        LAST
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        STOP
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        LIMIT
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="position in positions.positions" :key="position.id" class="dark:hover:text-white bg-white border-b border-gray-100 hover:bg-gray-50 dark:hover:bg-slate-700/50">
                                    <th scope="row" class="px-6 py-4 font-medium text-black dark:text-dark whitespace-nowrap">
                                        {{ position.market.instrumentName }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ position.position.direction }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ position.position.dealSize }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ position.position.openLevel }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ position.market.offer }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ position.position.stopLevel }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ position.position.limitLevel }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
