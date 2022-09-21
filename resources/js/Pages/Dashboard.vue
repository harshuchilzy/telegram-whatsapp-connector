<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import Swal from 'sweetalert2'

// Swal.fire({
//   title: 'Error!',
//   text: 'Do you want to continue',
//   icon: 'error',
//   confirmButtonText: 'Cool'
// })

const props = defineProps({
    accounts: Object,
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
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-6 mb-5">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <thead class="text-xs text-white uppercase bg-gray-50 dark:bg-slate-700 dark:text-white">
                        <tr>
                             <th scope="col" class="px-6 py-3">
                                AccountId
                             </th>
                             <th scope="col" class="px-6 py-3">
                                Account Name
                             </th>
                             <th scope="col" class="px-6 py-3">
                                Currency
                             </th>
                             <th scope="col" class="px-6 py-3">
                                Available Blance
                             </th>
                             <th scope="col" class="px-6 py-3">
                                Current Blance
                             </th>
                             <th scope="col" class="px-6 py-3">
                                Deposit
                             </th>
                             <th scope="col" class="px-6 py-3">
                                ProfitLoss
                             </th>
                             <th scope="col" class="px-6 py-3">
                                Status
                             </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="account in accounts.accounts" :key="account.accountId" class="bg-white border-b border-gray-100   hover:bg-gray-50 dark:hover:bg-slate-700/50">
                            <th scope="row" class="px-6 py-4 font-medium text-black dark:text-dark whitespace-nowrap">
                                {{ account.accountId }}
                            </th>
                            <td class="px-6 py-4">
                                {{ account.accountName }}
                            </td>
                            <td class="px-6 py-4">
                                {{ account.currency }}
                            </td>
                            <td class="px-6 py-4">
                                {{ account.balance.available }}
                            </td>  
                            <td class="px-6 py-4">
                                {{ account.balance.balance }}
                            </td>  
                            <td class="px-6 py-4">
                                {{ account.balance.deposit }}
                            </td>  
                            <td class="px-6 py-4">
                                {{ account.balance.profitLoss }}
                            </td>  
                            <td class="px-6 py-4">
                                {{ account.status }}
                            </td>  
                        </tr>
                    </tbody>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-2 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        Current Trades
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        Hello there
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
