<script setup>
import Pagination from '@/Components/Pagination.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import moment from 'moment'
import { ref, watch } from 'vue';
import axios from 'axios';

import LitepieDatepicker from 'litepie-datepicker';

function formatDate(dateString) {
    var date = new Date(dateString);
    return moment(date).format('Do, MMM YYYY, h:mm:ss.SSS a');
}

const histories = ref({});

const form = useForm({
    dates: []
})
const loading = ref(false);
async function fetchHistory() {
    var histry = await axios.post(route('account.history.fetch'), form);
    histories.value = histry.data
    loading.value = false;
}
watch(() => form.dates, (first, second) => {
    loading.value = true;
    fetchHistory()
});


const formatter = ref({
    date: 'DD-MM-YYYY',
    month: 'MMM'
})

</script>
        
<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                History
            </h2>
        </template>

        <div class="py-12 ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="min-h-screen">
                        <div class="p-6 bg-white border-b border-gray-200">


                            <div class="flex max-w-md relative mb-6">
                                <litepie-datepicker as-single use-range overlay :formatter="formatter" trigger="fetchHistory" v-model="form.dates"></litepie-datepicker>
                            </div>


                            <table class="table w-full text-sm text-left text-gray-500 dark:text-gray-400" id="datatable_1">
                                <thead class="text-xs text-black uppercase bg-gray-50 dark:bg-slate-700 dark:text-white">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Market
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Date
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Epic
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Result
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="history in histories.activities" :key="history.activityHistoryId" class="bg-white border-b border-gray-100 text-black">
                                        <th scope="row" class="px-6 py-4 font-medium text-black dark:text-dark whitespace-nowrap">
                                            {{ history.marketName }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{history.actionStatus}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{history.date}} {{history.time}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{history.epic}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{history.result}}
                                        </td>
                                    </tr>
                                    <tr v-if="Object.keys(histories).length == 0 && loading == false">
                                        <td colspan="5"><div class="text-center text-lg mt-4">Please select a date range</div></td>
                                    </tr>

                                    <tr v-if="histories.activities && Object.keys(histories.activities).length == 0 && loading == false">
                                        <td colspan="5"><div class="text-center text-lg mt-4">No data to be found</div></td>
                                    </tr>
                                    <tr v-if="loading">
                                        <td colspan="5">
                                            <div class="flex items-center justify-center my-5">
                                                <button type="button" class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-white bg-indigo-500 hover:bg-indigo-400 transition ease-in-out duration-150 cursor-not-allowed" disabled="">
                                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                Processing...
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- <Pagination class="my-2" :links="accepted.links" /> -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style>

.space-x-1>:not([hidden])~:not([hidden]) {
    --tw-space-x-reverse: 0;
    margin-right: calc(0.25rem*var(--tw-space-x-reverse));
    margin-left: calc(0.25rem*(1 - var(--tw-space-x-reverse)))
}

.space-x-2>:not([hidden])~:not([hidden]) {
    --tw-space-x-reverse: 0;
    margin-right: calc(0.5rem*var(--tw-space-x-reverse));
    margin-left: calc(0.5rem*(1 - var(--tw-space-x-reverse)))
}

.space-x-3>:not([hidden])~:not([hidden]) {
    --tw-space-x-reverse: 0;
    margin-right: calc(0.75rem*var(--tw-space-x-reverse));
    margin-left: calc(0.75rem*(1 - var(--tw-space-x-reverse)))
}

.space-y-4>:not([hidden])~:not([hidden]) {
    --tw-space-y-reverse: 0;
    margin-top: calc(1rem*(1 - var(--tw-space-y-reverse)));
    margin-bottom: calc(1rem*var(--tw-space-y-reverse))
}

.space-x-4>:not([hidden])~:not([hidden]) {
    --tw-space-x-reverse: 0;
    margin-right: calc(1rem*var(--tw-space-x-reverse));
    margin-left: calc(1rem*(1 - var(--tw-space-x-reverse)))
}

.space-y-6>:not([hidden])~:not([hidden]) {
    --tw-space-y-reverse: 0;
    margin-top: calc(1.5rem*(1 - var(--tw-space-y-reverse)));
    margin-bottom: calc(1.5rem*var(--tw-space-y-reverse))
}

.space-x-6>:not([hidden])~:not([hidden]) {
    --tw-space-x-reverse: 0;
    margin-right: calc(1.5rem*var(--tw-space-x-reverse));
    margin-left: calc(1.5rem*(1 - var(--tw-space-x-reverse)))
}

.space-y-20>:not([hidden])~:not([hidden]) {
    --tw-space-y-reverse: 0;
    margin-top: calc(5rem*(1 - var(--tw-space-y-reverse)));
    margin-bottom: calc(5rem*var(--tw-space-y-reverse))
}

.space-x-1\.5>:not([hidden])~:not([hidden]) {
    --tw-space-x-reverse: 0;
    margin-right: calc(0.375rem*var(--tw-space-x-reverse));
    margin-left: calc(0.375rem*(1 - var(--tw-space-x-reverse)))
}

.-space-x-0>:not([hidden])~:not([hidden]) {
    --tw-space-x-reverse: 0;
    margin-right: calc(0px*var(--tw-space-x-reverse));
    margin-left: calc(0px*(1 - var(--tw-space-x-reverse)))
}

.-space-x-0\.5>:not([hidden])~:not([hidden]) {
    --tw-space-x-reverse: 0;
    margin-right: calc(-0.125rem*var(--tw-space-x-reverse));
    margin-left: calc(-0.125rem*(1 - var(--tw-space-x-reverse)))
}

.divide-y>:not([hidden])~:not([hidden]) {
    --tw-divide-y-reverse: 0;
    border-top-width: calc(1px*(1 - var(--tw-divide-y-reverse)));
    border-bottom-width: calc(1px*var(--tw-divide-y-reverse))
}

.divide-gray-200>:not([hidden])~:not([hidden]) {
    --tw-divide-opacity: 1;
    border-color: rgba(229, 231, 235, var(--tw-divide-opacity))
}

.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border-width: 0
}

.bg-clip-text {
    -webkit-background-clip: text;
    background-clip: text
}

.bg-black {
    --tw-bg-opacity: 1;
    background-color: rgba(0, 0, 0, var(--tw-bg-opacity))
}

.bg-white {
    --tw-bg-opacity: 1;
    background-color: rgba(255, 255, 255, var(--tw-bg-opacity))
}

.bg-gray-50 {
    --tw-bg-opacity: 1;
    background-color: rgba(249, 250, 251, var(--tw-bg-opacity))
}

.bg-yellow-50 {
    --tw-bg-opacity: 1;
    background-color: rgba(255, 251, 235, var(--tw-bg-opacity))
}

.bg-indigo-50 {
    --tw-bg-opacity: 1;
    background-color: rgba(238, 242, 255, var(--tw-bg-opacity))
}

.bg-light-blue-500 {
    --tw-bg-opacity: 1;
    background-color: rgba(14, 165, 233, var(--tw-bg-opacity))
}

.bg-light-blue-600 {
    --tw-bg-opacity: 1;
    background-color: rgba(2, 132, 199, var(--tw-bg-opacity))
}

.bg-litepie-primary-100 {
    --tw-bg-opacity: 1;
    background-color: rgba(209, 250, 229, var(--tw-bg-opacity))
}

.bg-litepie-primary-500 {
    --tw-bg-opacity: 1;
    background-color: rgba(16, 185, 129, var(--tw-bg-opacity))
}

.bg-litepie-primary-600 {
    --tw-bg-opacity: 1;
    background-color: rgba(5, 150, 105, var(--tw-bg-opacity))
}

.hover\:bg-light-blue-700:hover {
    --tw-bg-opacity: 1;
    background-color: rgba(3, 105, 161, var(--tw-bg-opacity))
}

.hover\:bg-litepie-primary-700:hover {
    --tw-bg-opacity: 1;
    background-color: rgba(4, 120, 87, var(--tw-bg-opacity))
}

.hover\:bg-litepie-secondary-50:hover {
    --tw-bg-opacity: 1;
    background-color: rgba(249, 250, 251, var(--tw-bg-opacity))
}

.hover\:bg-litepie-secondary-100:hover {
    --tw-bg-opacity: 1;
    background-color: rgba(243, 244, 246, var(--tw-bg-opacity))
}

.focus\:bg-litepie-primary-50:focus {
    --tw-bg-opacity: 1;
    background-color: rgba(236, 253, 245, var(--tw-bg-opacity))
}

.focus\:bg-litepie-secondary-100:focus {
    --tw-bg-opacity: 1;
    background-color: rgba(243, 244, 246, var(--tw-bg-opacity))
}

.dark .dark\:bg-gray-800 {
    --tw-bg-opacity: 1;
    background-color: rgba(31, 41, 55, var(--tw-bg-opacity))
}

.dark .dark\:bg-litepie-secondary-700 {
    --tw-bg-opacity: 1;
    background-color: rgba(55, 65, 81, var(--tw-bg-opacity))
}

.dark .dark\:bg-litepie-secondary-800 {
    --tw-bg-opacity: 1;
    background-color: rgba(31, 41, 55, var(--tw-bg-opacity))
}

.dark .dark\:hover\:bg-litepie-secondary-700:hover {
    --tw-bg-opacity: 1;
    background-color: rgba(55, 65, 81, var(--tw-bg-opacity))
}

.dark .dark\:focus\:bg-litepie-secondary-600:focus {
    --tw-bg-opacity: 1;
    background-color: rgba(75, 85, 99, var(--tw-bg-opacity))
}

.dark .dark\:focus\:bg-litepie-secondary-700:focus {
    --tw-bg-opacity: 1;
    background-color: rgba(55, 65, 81, var(--tw-bg-opacity))
}

.bg-gradient-to-r {
    background-image: linear-gradient(90deg, var(--tw-gradient-stops))
}

.from-gray-100 {
    --tw-gradient-from: #f3f4f6;
    --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(243, 244, 246, 0))
}

.from-gray-200 {
    --tw-gradient-from: #e5e7eb;
    --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(229, 231, 235, 0))
}

.to-white {
    --tw-gradient-to: #fff
}

.to-light-blue-400 {
    --tw-gradient-to: #38bdf8
}

.bg-opacity-60 {
    --tw-bg-opacity: .6
}

.bg-opacity-85 {
    --tw-bg-opacity: .85
}

.dark .dark\:bg-opacity-50,
.dark .dark\:focus\:bg-opacity-50:focus {
    --tw-bg-opacity: .5
}

.border-transparent {
    border-color: transparent
}

.border-black {
    --tw-border-opacity: 1;
    border-color: rgba(0, 0, 0, var(--tw-border-opacity))
}

.border-gray-200 {
    --tw-border-opacity: 1;
    border-color: rgba(229, 231, 235, var(--tw-border-opacity))
}

.border-gray-700 {
    --tw-border-opacity: 1;
    border-color: rgba(55, 65, 81, var(--tw-border-opacity))
}

.border-red-500 {
    --tw-border-opacity: 1;
    border-color: rgba(239, 68, 68, var(--tw-border-opacity))
}

.border-yellow-100 {
    --tw-border-opacity: 1;
    border-color: rgba(254, 243, 199, var(--tw-border-opacity))
}

.border-yellow-400 {
    --tw-border-opacity: 1;
    border-color: rgba(251, 191, 36, var(--tw-border-opacity))
}

.border-green-400 {
    --tw-border-opacity: 1;
    border-color: rgba(52, 211, 153, var(--tw-border-opacity))
}

.border-indigo-200 {
    --tw-border-opacity: 1;
    border-color: rgba(199, 210, 254, var(--tw-border-opacity))
}

.border-litepie-secondary-300 {
    --tw-border-opacity: 1;
    border-color: rgba(209, 213, 219, var(--tw-border-opacity))
}

.focus\:border-litepie-primary-300:focus {
    --tw-border-opacity: 1;
    border-color: rgba(110, 231, 183, var(--tw-border-opacity))
}

.dark .dark\:border-litepie-secondary-700 {
    --tw-border-opacity: 1;
    border-color: rgba(55, 65, 81, var(--tw-border-opacity))
}

.dark .dark\:focus\:border-litepie-primary-500:focus {
    --tw-border-opacity: 1;
    border-color: rgba(16, 185, 129, var(--tw-border-opacity))
}

.border-opacity-5 {
    --tw-border-opacity: .05
}

.border-opacity-10 {
    --tw-border-opacity: .1
}

.border-opacity-70 {
    --tw-border-opacity: .7
}

.dark .dark\:border-opacity-100 {
    --tw-border-opacity: 1
}

.rounded {
    border-radius: .25rem
}

.rounded-md {
    border-radius: .375rem
}

.rounded-lg {
    border-radius: .5rem
}

.rounded-xl {
    border-radius: .75rem
}

.rounded-full {
    border-radius: 9999px
}

.rounded-r-full {
    border-top-right-radius: 9999px;
    border-bottom-right-radius: 9999px
}

.rounded-l-full {
    border-top-left-radius: 9999px;
    border-bottom-left-radius: 9999px
}

.rounded-tl-3xl {
    border-top-left-radius: 1.5rem
}

.border-0 {
    border-width: 0
}

.border-2 {
    border-width: 2px
}

.border {
    border-width: 1px
}

.border-b-0 {
    border-bottom-width: 0
}

.border-t {
    border-top-width: 1px
}

.border-b {
    border-bottom-width: 1px
}

.cursor-default {
    cursor: default
}

.disabled\:cursor-not-allowed:disabled {
    cursor: not-allowed
}

.block {
    display: block
}

.inline {
    display: inline
}

.flex {
    display: flex
}

.inline-flex {
    display: inline-flex
}

.table {
    display: table
}

.grid {
    display: grid
}

.hidden {
    display: none
}

.flex-wrap {
    flex-wrap: wrap
}

.items-start {
    align-items: flex-start
}

.items-center {
    align-items: center
}

.justify-center {
    justify-content: center
}

.justify-between {
    justify-content: space-between
}

.flex-1 {
    flex: 1 1 0%
}

.flex-auto {
    flex: 1 1 auto
}

.flex-none {
    flex: none
}

.flex-grow {
    flex-grow: 1
}

.flex-shrink-0 {
    flex-shrink: 0
}

.order-last {
    order: 9999
}

.font-mono {
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, Liberation\ Mono, Courier\ New, monospace
}

.font-light {
    font-weight: 300
}

.font-normal {
    font-weight: 400
}

.font-medium {
    font-weight: 500
}

.font-semibold {
    font-weight: 600
}

.font-bold {
    font-weight: 700
}

.font-extrabold {
    font-weight: 800
}

.h-1 {
    height: .25rem
}

.h-3 {
    height: .75rem
}

.h-5 {
    height: 1.25rem
}

.h-6 {
    height: 1.5rem
}

.h-10 {
    height: 2.5rem
}

.h-12 {
    height: 3rem
}

.h-auto {
    height: auto
}

.text-xs {
    font-size: .75rem;
    line-height: 1rem
}

.text-sm {
    font-size: .875rem;
    line-height: 1.25rem
}

.text-base {
    font-size: 1rem;
    line-height: 1.5rem
}

.text-lg {
    font-size: 1.125rem;
    line-height: 1.75rem
}

.text-3xl {
    font-size: 1.875rem;
    line-height: 2.25rem
}

.text-4xl {
    font-size: 2.25rem;
    line-height: 2.5rem
}

.leading-6 {
    line-height: 1.5rem
}

.leading-none {
    line-height: 1
}

.leading-relaxed {
    line-height: 1.625
}

.my-1 {
    margin-top: .25rem;
    margin-bottom: .25rem
}

.mx-2 {
    margin-left: .5rem;
    margin-right: .5rem
}

.my-6 {
    margin-top: 1.5rem;
    margin-bottom: 1.5rem
}

.mx-auto {
    margin-left: auto;
    margin-right: auto
}

.-mx-4 {
    margin-left: -1rem;
    margin-right: -1rem
}

.mt-0 {
    margin-top: 0
}

.mt-1 {
    margin-top: .25rem
}

.mr-1 {
    margin-right: .25rem
}

.mt-2 {
    margin-top: .5rem
}

.mb-2 {
    margin-bottom: .5rem
}

.mt-3 {
    margin-top: .75rem
}

.mb-3 {
    margin-bottom: .75rem
}

.mt-4 {
    margin-top: 1rem
}

.ml-4 {
    margin-left: 1rem
}

.mt-6 {
    margin-top: 1.5rem
}

.ml-6 {
    margin-left: 1.5rem
}

.mb-8 {
    margin-bottom: 2rem
}

.mt-10 {
    margin-top: 2.5rem
}

.mb-10 {
    margin-bottom: 2.5rem
}

.mb-14 {
    margin-bottom: 3.5rem
}

.mt-16 {
    margin-top: 4rem
}

.mt-20 {
    margin-top: 5rem
}

.mb-20 {
    margin-bottom: 5rem
}

.mt-40 {
    margin-top: 10rem
}

.mt-0\.5 {
    margin-top: .125rem
}

.mt-1\.5 {
    margin-top: .375rem
}

.-ml-4 {
    margin-left: -1rem
}

.max-w-md {
    max-width: 28rem
}

.max-w-screen-md {
    max-width: 768px
}

.max-w-screen-lg {
    max-width: 1024px
}

.min-h-screen {
    min-height: 100vh
}

.opacity-0 {
    opacity: 0
}

.group:hover .group-hover\:opacity-100,
.opacity-100 {
    opacity: 1
}

.focus\:outline-none:focus {
    outline: 2px solid transparent;
    outline-offset: 2px
}

.overflow-hidden {
    overflow: hidden
}

.overflow-y-auto {
    overflow-y: auto
}

.p-1 {
    padding: .25rem
}

.p-1\.5 {
    padding: .375rem
}

.px-0 {
    padding-left: 0;
    padding-right: 0
}

.py-1 {
    padding-top: .25rem;
    padding-bottom: .25rem
}

.px-1 {
    padding-left: .25rem;
    padding-right: .25rem
}

.py-2 {
    padding-top: .5rem;
    padding-bottom: .5rem
}

.px-2 {
    padding-left: .5rem;
    padding-right: .5rem
}

.py-3 {
    padding-top: .75rem;
    padding-bottom: .75rem
}

.px-3 {
    padding-left: .75rem;
    padding-right: .75rem
}

.py-4 {
    padding-top: 1rem;
    padding-bottom: 1rem
}

.px-4 {
    padding-left: 1rem;
    padding-right: 1rem
}

.py-5 {
    padding-top: 1.25rem;
    padding-bottom: 1.25rem
}

.px-6 {
    padding-left: 1.5rem;
    padding-right: 1.5rem
}

.px-0\.5 {
    padding-left: .125rem;
    padding-right: .125rem
}

.py-1\.5 {
    padding-top: .375rem;
    padding-bottom: .375rem
}

.px-1\.5 {
    padding-left: .375rem;
    padding-right: .375rem
}

.py-2\.5 {
    padding-top: .625rem;
    padding-bottom: .625rem
}

.pr-0 {
    padding-right: 0
}

.pt-1 {
    padding-top: .25rem
}

.pl-3 {
    padding-left: .75rem
}

.pt-6 {
    padding-top: 1.5rem
}

.pt-10 {
    padding-top: 2.5rem
}

.pr-12 {
    padding-right: 3rem
}

.pb-12 {
    padding-bottom: 3rem
}

.pt-16 {
    padding-top: 4rem
}

.placeholder-litepie-secondary-400::placeholder {
    --tw-placeholder-opacity: 1;
    color: rgba(156, 163, 175, var(--tw-placeholder-opacity))
}

.dark .dark\:placeholder-litepie-secondary-500::placeholder {
    --tw-placeholder-opacity: 1;
    color: rgba(107, 114, 128, var(--tw-placeholder-opacity))
}

.static {
    position: static
}

.fixed {
    position: fixed
}

.absolute {
    position: absolute
}

.relative {
    position: relative
}

.inset-0 {
    right: 0;
    left: 0
}

.inset-0,
.inset-y-0 {
    top: 0;
    bottom: 0
}

.inset-x-0 {
    right: 0;
    left: 0
}

.right-0 {
    right: 0
}

.bottom-0 {
    bottom: 0
}

.left-0 {
    left: 0
}

.right-1 {
    right: .25rem
}

.right-auto {
    right: auto
}

.left-auto {
    left: auto
}

.right-1\.5 {
    right: .375rem
}

.top-1\/3 {
    top: 33.333333%
}

.top-full {
    top: 100%
}

* {
    --tw-shadow: 0 0 transparent
}

.shadow-sm {
    --tw-shadow: 0 1px 2px 0 rgba(0, 0, 0, .05)
}

.shadow-lg,
.shadow-sm {
    box-shadow: var(--tw-ring-offset-shadow, 0 0 transparent), var(--tw-ring-shadow, 0 0 transparent), var(--tw-shadow)
}

.shadow-lg {
    --tw-shadow: 0 10px 15px -3px rgba(0, 0, 0, .1), 0 4px 6px -2px rgba(0, 0, 0, .05)
}

.shadow-2xl {
    --tw-shadow: 0 25px 50px -12px rgba(0, 0, 0, .25)
}

.shadow-2xl,
.shadow-inner {
    box-shadow: var(--tw-ring-offset-shadow, 0 0 transparent), var(--tw-ring-shadow, 0 0 transparent), var(--tw-shadow)
}

.shadow-inner {
    --tw-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, .06)
}

* {
    --tw-ring-inset: var(--tw-empty);
    --tw-ring-offset-width: 0;
    --tw-ring-offset-color: #fff;
    --tw-ring-color: rgba(59, 130, 246, .5);
    --tw-ring-offset-shadow: 0 0 transparent;
    --tw-ring-shadow: 0 0 transparent
}

.focus\:ring-2:focus {
    --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
    --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color)
}

.focus\:ring-2:focus,
.focus\:ring:focus {
    box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 transparent)
}

.focus\:ring:focus {
    --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
    --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(3px + var(--tw-ring-offset-width)) var(--tw-ring-color)
}

.focus\:ring-offset-black:focus {
    --tw-ring-offset-color: #000
}

.focus\:ring-offset-white:focus {
    --tw-ring-offset-color: #fff
}

.dark .dark\:ring-offset-litepie-secondary-800 {
    --tw-ring-offset-color: #1f2937
}

.focus\:ring-offset-2:focus {
    --tw-ring-offset-width: 2px
}

.focus\:ring-gray-300:focus {
    --tw-ring-opacity: 1;
    --tw-ring-color: rgba(209, 213, 219, var(--tw-ring-opacity))
}

.focus\:ring-indigo-300:focus {
    --tw-ring-opacity: 1;
    --tw-ring-color: rgba(165, 180, 252, var(--tw-ring-opacity))
}

.focus\:ring-light-blue-400:focus {
    --tw-ring-opacity: 1;
    --tw-ring-color: rgba(56, 189, 248, var(--tw-ring-opacity))
}

.focus\:ring-litepie-primary-500:focus {
    --tw-ring-opacity: 1;
    --tw-ring-color: rgba(16, 185, 129, var(--tw-ring-opacity))
}

.focus\:ring-opacity-10:focus {
    --tw-ring-opacity: .1
}

.dark .dark\:focus\:ring-opacity-20:focus {
    --tw-ring-opacity: .2
}

.dark .dark\:focus\:ring-opacity-25:focus {
    --tw-ring-opacity: .25
}

.text-center {
    text-align: center
}

.text-transparent {
    color: transparent
}

.text-white {
    --tw-text-opacity: 1;
    color: rgba(255, 255, 255, var(--tw-text-opacity))
}

.text-gray-50 {
    --tw-text-opacity: 1;
    color: rgba(249, 250, 251, var(--tw-text-opacity))
}

.text-gray-300 {
    --tw-text-opacity: 1;
    color: rgba(209, 213, 219, var(--tw-text-opacity))
}

.text-gray-400 {
    --tw-text-opacity: 1;
    color: rgba(156, 163, 175, var(--tw-text-opacity))
}

.text-gray-500 {
    --tw-text-opacity: 1;
    color: rgba(107, 114, 128, var(--tw-text-opacity))
}

.text-gray-700 {
    --tw-text-opacity: 1;
    color: rgba(55, 65, 81, var(--tw-text-opacity))
}

.text-gray-900 {
    --tw-text-opacity: 1;
    color: rgba(17, 24, 39, var(--tw-text-opacity))
}

.text-red-50 {
    --tw-text-opacity: 1;
    color: rgba(254, 242, 242, var(--tw-text-opacity))
}

.text-red-500 {
    --tw-text-opacity: 1;
    color: rgba(239, 68, 68, var(--tw-text-opacity))
}

.text-yellow-400 {
    --tw-text-opacity: 1;
    color: rgba(251, 191, 36, var(--tw-text-opacity))
}

.text-green-400 {
    --tw-text-opacity: 1;
    color: rgba(52, 211, 153, var(--tw-text-opacity))
}

.text-indigo-50 {
    --tw-text-opacity: 1;
    color: rgba(238, 242, 255, var(--tw-text-opacity))
}

.text-indigo-400 {
    --tw-text-opacity: 1;
    color: rgba(129, 140, 248, var(--tw-text-opacity))
}

.text-orange-400 {
    --tw-text-opacity: 1;
    color: rgba(251, 146, 60, var(--tw-text-opacity))
}

.text-light-blue-50 {
    --tw-text-opacity: 1;
    color: rgba(240, 249, 255, var(--tw-text-opacity))
}

.text-light-blue-400 {
    --tw-text-opacity: 1;
    color: rgba(56, 189, 248, var(--tw-text-opacity))
}

.text-litepie-primary-500 {
    --tw-text-opacity: 1;
    color: rgba(16, 185, 129, var(--tw-text-opacity))
}

.text-litepie-primary-600 {
    --tw-text-opacity: 1;
    color: rgba(5, 150, 105, var(--tw-text-opacity))
}

.text-litepie-secondary-400 {
    --tw-text-opacity: 1;
    color: rgba(156, 163, 175, var(--tw-text-opacity))
}

.text-litepie-secondary-500 {
    --tw-text-opacity: 1;
    color: rgba(107, 114, 128, var(--tw-text-opacity))
}

.text-litepie-secondary-600 {
    --tw-text-opacity: 1;
    color: rgba(75, 85, 99, var(--tw-text-opacity))
}

.text-litepie-secondary-700 {
    --tw-text-opacity: 1;
    color: rgba(55, 65, 81, var(--tw-text-opacity))
}

.hover\:text-gray-400:hover {
    --tw-text-opacity: 1;
    color: rgba(156, 163, 175, var(--tw-text-opacity))
}

.hover\:text-gray-900:hover {
    --tw-text-opacity: 1;
    color: rgba(17, 24, 39, var(--tw-text-opacity))
}

.hover\:text-indigo-900:hover {
    --tw-text-opacity: 1;
    color: rgba(49, 46, 129, var(--tw-text-opacity))
}

.hover\:text-litepie-primary-700:hover {
    --tw-text-opacity: 1;
    color: rgba(4, 120, 87, var(--tw-text-opacity))
}

.hover\:text-litepie-secondary-900:hover {
    --tw-text-opacity: 1;
    color: rgba(17, 24, 39, var(--tw-text-opacity))
}

.focus\:text-litepie-primary-600:focus {
    --tw-text-opacity: 1;
    color: rgba(5, 150, 105, var(--tw-text-opacity))
}

.focus\:text-litepie-secondary-900:focus {
    --tw-text-opacity: 1;
    color: rgba(17, 24, 39, var(--tw-text-opacity))
}

.disabled\:text-litepie-secondary-500:disabled {
    --tw-text-opacity: 1;
    color: rgba(107, 114, 128, var(--tw-text-opacity))
}

.dark .dark\:text-litepie-primary-400 {
    --tw-text-opacity: 1;
    color: rgba(52, 211, 153, var(--tw-text-opacity))
}

.dark .dark\:text-litepie-secondary-100 {
    --tw-text-opacity: 1;
    color: rgba(243, 244, 246, var(--tw-text-opacity))
}

.dark .dark\:text-litepie-secondary-200 {
    --tw-text-opacity: 1;
    color: rgba(229, 231, 235, var(--tw-text-opacity))
}

.dark .dark\:text-litepie-secondary-300 {
    --tw-text-opacity: 1;
    color: rgba(209, 213, 219, var(--tw-text-opacity))
}

.dark .dark\:text-litepie-secondary-400 {
    --tw-text-opacity: 1;
    color: rgba(156, 163, 175, var(--tw-text-opacity))
}

.dark .dark\:hover\:text-litepie-primary-300:hover {
    --tw-text-opacity: 1;
    color: rgba(110, 231, 183, var(--tw-text-opacity))
}

.dark .dark\:hover\:text-litepie-secondary-100:hover {
    --tw-text-opacity: 1;
    color: rgba(243, 244, 246, var(--tw-text-opacity))
}

.dark .dark\:hover\:text-litepie-secondary-300:hover {
    --tw-text-opacity: 1;
    color: rgba(209, 213, 219, var(--tw-text-opacity))
}

.dark .dark\:focus\:text-litepie-primary-300:focus {
    --tw-text-opacity: 1;
    color: rgba(110, 231, 183, var(--tw-text-opacity))
}

.dark .dark\:focus\:text-litepie-secondary-100:focus {
    --tw-text-opacity: 1;
    color: rgba(243, 244, 246, var(--tw-text-opacity))
}

.text-opacity-75 {
    --tw-text-opacity: .75
}

.dark .dark\:text-opacity-70 {
    --tw-text-opacity: .7
}

.uppercase {
    text-transform: uppercase
}

.antialiased {
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale
}

.ordinal {
    --tw-ordinal: var(--tw-empty);
    --tw-slashed-zero: var(--tw-empty);
    --tw-numeric-figure: var(--tw-empty);
    --tw-numeric-spacing: var(--tw-empty);
    --tw-numeric-fraction: var(--tw-empty);
    font-variant-numeric: var(--tw-ordinal) var(--tw-slashed-zero) var(--tw-numeric-figure) var(--tw-numeric-spacing) var(--tw-numeric-fraction);
    --tw-ordinal: ordinal
}

.tracking-tight {
    letter-spacing: -.025em
}

.tracking-wide {
    letter-spacing: .025em
}

.whitespace-nowrap {
    white-space: nowrap
}

.w-3 {
    width: .75rem
}

.w-5 {
    width: 1.25rem
}

.w-6 {
    width: 1.5rem
}

.w-8 {
    width: 2rem
}

.w-12 {
    width: 3rem
}

.w-32 {
    width: 8rem
}

.w-auto {
    width: auto
}

.w-1\/2 {
    width: 50%
}

.w-full {
    width: 100%
}

.z-10 {
    z-index: 10
}

.z-50 {
    z-index: 50
}

.gap-1 {
    gap: .25rem
}

.gap-6 {
    gap: 1.5rem
}

.gap-y-0 {
    row-gap: 0
}

.gap-y-8 {
    row-gap: 2rem
}

.gap-y-0\.5 {
    row-gap: .125rem
}

.grid-cols-1 {
    grid-template-columns: repeat(1, minmax(0, 1fr))
}

.grid-cols-2 {
    grid-template-columns: repeat(2, minmax(0, 1fr))
}

.grid-cols-7 {
    grid-template-columns: repeat(7, minmax(0, 1fr))
}

.col-span-2 {
    grid-column: span 2/span 2
}

.transform {
    --tw-translate-x: 0;
    --tw-translate-y: 0;
    --tw-rotate: 0;
    --tw-skew-x: 0;
    --tw-skew-y: 0;
    --tw-scale-x: 1;
    --tw-scale-y: 1;
    transform: translateX(var(--tw-translate-x)) translateY(var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
}

.-rotate-6 {
    --tw-rotate: -6deg
}

.-rotate-2 {
    --tw-rotate: -2deg
}

.translate-x-10 {
    --tw-translate-x: 2.5rem
}

.translate-y-0 {
    --tw-translate-y: 0
}

.translate-y-3 {
    --tw-translate-y: .75rem
}

.translate-y-32 {
    --tw-translate-y: 8rem
}

.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(.4, 0, .2, 1);
    transition-duration: .15s
}

.transition {
    transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
    transition-timing-function: cubic-bezier(.4, 0, .2, 1);
    transition-duration: .15s
}

.transition-colors {
    transition-property: background-color, border-color, color, fill, stroke;
    transition-timing-function: cubic-bezier(.4, 0, .2, 1);
    transition-duration: .15s
}

.transition-opacity {
    transition-property: opacity;
    transition-timing-function: cubic-bezier(.4, 0, .2, 1);
    transition-duration: .15s
}

.ease-in {
    transition-timing-function: cubic-bezier(.4, 0, 1, 1)
}

.ease-out {
    transition-timing-function: cubic-bezier(0, 0, .2, 1)
}

.duration-150 {
    transition-duration: .15s
}

.duration-200 {
    transition-duration: .2s
}

.duration-300 {
    transition-duration: .3s
}

@keyframes spin {
    to {
        transform: rotate(1turn)
    }
}

@keyframes ping {

    75%,
    to {
        transform: scale(2);
        opacity: 0
    }
}

@keyframes pulse {
    50% {
        opacity: .5
    }
}

@keyframes bounce {

    0%,
    to {
        transform: translateY(-25%);
        animation-timing-function: cubic-bezier(.8, 0, 1, 1)
    }

    50% {
        transform: none;
        animation-timing-function: cubic-bezier(0, 0, .2, 1)
    }
}

@media (min-width:640px) {
    .sm\:space-y-0>:not([hidden])~:not([hidden]) {
        --tw-space-y-reverse: 0;
        margin-top: calc(0px*(1 - var(--tw-space-y-reverse)));
        margin-bottom: calc(0px*var(--tw-space-y-reverse))
    }

    .sm\:space-x-4>:not([hidden])~:not([hidden]) {
        --tw-space-x-reverse: 0;
        margin-right: calc(1rem*var(--tw-space-x-reverse));
        margin-left: calc(1rem*(1 - var(--tw-space-x-reverse)))
    }

    .sm\:space-y-6>:not([hidden])~:not([hidden]) {
        --tw-space-y-reverse: 0;
        margin-top: calc(1.5rem*(1 - var(--tw-space-y-reverse)));
        margin-bottom: calc(1.5rem*var(--tw-space-y-reverse))
    }

    .sm\:space-y-10>:not([hidden])~:not([hidden]) {
        --tw-space-y-reverse: 0;
        margin-top: calc(2.5rem*(1 - var(--tw-space-y-reverse)));
        margin-bottom: calc(2.5rem*var(--tw-space-y-reverse))
    }

    .sm\:space-x-10>:not([hidden])~:not([hidden]) {
        --tw-space-x-reverse: 0;
        margin-right: calc(2.5rem*var(--tw-space-x-reverse));
        margin-left: calc(2.5rem*(1 - var(--tw-space-x-reverse)))
    }

    .sm\:space-y-32>:not([hidden])~:not([hidden]) {
        --tw-space-y-reverse: 0;
        margin-top: calc(8rem*(1 - var(--tw-space-y-reverse)));
        margin-bottom: calc(8rem*var(--tw-space-y-reverse))
    }

    .sm\:space-x-reverse>:not([hidden])~:not([hidden]) {
        --tw-space-x-reverse: 1
    }

    .sm\:rounded-lg {
        border-radius: .5rem
    }

    .sm\:rounded-xl {
        border-radius: .75rem
    }

    .sm\:border {
        border-width: 1px
    }

    .sm\:border-t-0 {
        border-top-width: 0
    }

    .sm\:border-b {
        border-bottom-width: 1px
    }

    .sm\:flex {
        display: flex
    }

    .sm\:hidden {
        display: none
    }

    .sm\:flex-row-reverse {
        flex-direction: row-reverse
    }

    .sm\:flex-nowrap {
        flex-wrap: nowrap
    }

    .sm\:flex-none {
        flex: none
    }

    .sm\:order-last {
        order: 9999
    }

    .sm\:order-none {
        order: 0
    }

    .sm\:font-medium {
        font-weight: 500
    }

    .sm\:h-8 {
        height: 2rem
    }

    .sm\:text-sm {
        font-size: .875rem;
        line-height: 1.25rem
    }

    .sm\:text-base {
        font-size: 1rem;
        line-height: 1.5rem
    }

    .sm\:text-2xl {
        font-size: 1.5rem;
        line-height: 2rem
    }

    .sm\:text-6xl {
        font-size: 3.75rem;
        line-height: 1
    }

    .sm\:leading-4 {
        line-height: 1rem
    }

    .sm\:leading-10 {
        line-height: 2.5rem
    }

    .sm\:mx-0 {
        margin-left: 0;
        margin-right: 0
    }

    .sm\:mx-1 {
        margin-left: .25rem;
        margin-right: .25rem
    }

    .sm\:mt-0 {
        margin-top: 0
    }

    .sm\:mb-0 {
        margin-bottom: 0
    }

    .sm\:mt-1 {
        margin-top: .25rem
    }

    .sm\:mb-1 {
        margin-bottom: .25rem
    }

    .sm\:mt-2 {
        margin-top: .5rem
    }

    .sm\:mr-2 {
        margin-right: .5rem
    }

    .sm\:ml-2 {
        margin-left: .5rem
    }

    .sm\:ml-3 {
        margin-left: .75rem
    }

    .sm\:mb-10 {
        margin-bottom: 2.5rem
    }

    .sm\:ml-10 {
        margin-left: 2.5rem
    }

    .sm\:mb-11 {
        margin-bottom: 2.75rem
    }

    .sm\:mt-14 {
        margin-top: 3.5rem
    }

    .sm\:mb-20 {
        margin-bottom: 5rem
    }

    .sm\:mb-1\.5 {
        margin-bottom: .375rem
    }

    .sm\:mt-2\.5 {
        margin-top: .625rem
    }

    .sm\:overflow-visible {
        overflow: visible
    }

    .sm\:px-0 {
        padding-left: 0;
        padding-right: 0
    }

    .sm\:py-1 {
        padding-top: .25rem;
        padding-bottom: .25rem
    }

    .sm\:px-1 {
        padding-left: .25rem;
        padding-right: .25rem
    }

    .sm\:px-2 {
        padding-left: .5rem;
        padding-right: .5rem
    }

    .sm\:px-6 {
        padding-left: 1.5rem;
        padding-right: 1.5rem
    }

    .sm\:py-1\.5 {
        padding-top: .375rem;
        padding-bottom: .375rem
    }

    .sm\:pr-1 {
        padding-right: .25rem
    }

    .sm\:pt-8 {
        padding-top: 2rem
    }

    .sm\:pt-12 {
        padding-top: 3rem
    }

    .sm\:pt-20 {
        padding-top: 5rem
    }

    .sm\:pb-20 {
        padding-bottom: 5rem
    }

    .sm\:static {
        position: static
    }

    .sm\:relative {
        position: relative
    }

    .sm\:top-0 {
        top: 0
    }

    .sm\:shadow-sm {
        --tw-shadow: 0 1px 2px 0 rgba(0, 0, 0, .05);
        box-shadow: var(--tw-ring-offset-shadow, 0 0 transparent), var(--tw-ring-shadow, 0 0 transparent), var(--tw-shadow)
    }

    .sm\:w-1 {
        width: .25rem
    }

    .sm\:w-80 {
        width: 20rem
    }

    .sm\:w-auto {
        width: auto
    }

    .sm\:z-auto {
        z-index: auto
    }

    .sm\:gap-y-12 {
        row-gap: 3rem
    }

    .sm\:grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr))
    }

    .sm\:grid-cols-3 {
        grid-template-columns: repeat(3, minmax(0, 1fr))
    }

    .sm\:translate-x-24 {
        --tw-translate-x: 6rem
    }

    .sm\:translate-y-1\/2 {
        --tw-translate-y: 50%
    }
}

@media (min-width:768px) {
    .md\:space-y-40>:not([hidden])~:not([hidden]) {
        --tw-space-y-reverse: 0;
        margin-top: calc(10rem*(1 - var(--tw-space-y-reverse)));
        margin-bottom: calc(10rem*var(--tw-space-y-reverse))
    }

    .md\:px-8 {
        padding-left: 2rem;
        padding-right: 2rem
    }

    .md\:pt-24 {
        padding-top: 6rem
    }
}

@media (min-width:1024px) {
    .lg\:space-x-4>:not([hidden])~:not([hidden]) {
        --tw-space-x-reverse: 0;
        margin-right: calc(1rem*var(--tw-space-x-reverse));
        margin-left: calc(1rem*(1 - var(--tw-space-x-reverse)))
    }

    .lg\:space-y-44>:not([hidden])~:not([hidden]) {
        --tw-space-y-reverse: 0;
        margin-top: calc(11rem*(1 - var(--tw-space-y-reverse)));
        margin-bottom: calc(11rem*var(--tw-space-y-reverse))
    }

    .lg\:border-b-0 {
        border-bottom-width: 0
    }

    .lg\:border-r {
        border-right-width: 1px
    }

    .lg\:block {
        display: block
    }

    .lg\:flex-nowrap {
        flex-wrap: nowrap
    }

    .lg\:h-8 {
        height: 2rem
    }

    .lg\:h-10 {
        height: 2.5rem
    }

    .lg\:text-xs {
        font-size: .75rem;
        line-height: 1rem
    }

    .lg\:text-7xl {
        font-size: 4.5rem;
        line-height: 1
    }

    .lg\:mx-0 {
        margin-left: 0;
        margin-right: 0
    }

    .lg\:mb-0 {
        margin-bottom: 0
    }

    .lg\:mr-1 {
        margin-right: .25rem
    }

    .lg\:mb-24 {
        margin-bottom: 6rem
    }

    .lg\:w-8 {
        width: 2rem
    }

    .lg\:w-10 {
        width: 2.5rem
    }

    .lg\:gap-x-8 {
        column-gap: 2rem
    }

    .lg\:gap-x-10 {
        column-gap: 2.5rem
    }

    .lg\:gap-y-0 {
        row-gap: 0
    }

    .lg\:grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr))
    }

    .lg\:grid-cols-3 {
        grid-template-columns: repeat(3, minmax(0, 1fr))
    }

    .lg\:translate-y-1\/2 {
        --tw-translate-y: 50%
    }
}

@media (min-width:1280px) {
    .xl\:mb-8 {
        margin-bottom: 2rem
    }

    .xl\:mb-32 {
        margin-bottom: 8rem
    }

    .xl\:max-w-screen-xl {
        max-width: 1280px
    }

    .xl\:pt-32 {
        padding-top: 8rem
    }

    .xl\:w-1\/2 {
        width: 50%
    }

    .xl\:gap-8 {
        gap: 2rem
    }

    .xl\:translate-y-36 {
        --tw-translate-y: 9rem
    }
}

@media (min-width:1536px) {
    .2xl\:text-sm {
        font-size: .875rem;
        line-height: 1.25rem
    }

    .2xl\:mb-40 {
        margin-bottom: 10rem
    }
}
</style>