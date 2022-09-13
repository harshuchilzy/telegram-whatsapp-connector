<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';

const props = defineProps({
    messages: Object
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
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex-1 p:2 sm:p-6 justify-between flex flex-col h-auto">
                            <div class="flex sm:items-center justify-between py-3 border-b-2 border-gray-200">
                                <div class="relative flex items-center space-x-4">
                                    <div class="relative">
                                        <span class="absolute text-green-500 right-0 bottom-0">
                                            <svg width="20" height="20">
                                                <circle cx="8" cy="8" r="8" fill="currentColor"></circle>
                                            </svg>
                                        </span>
                                        <img src="https://images.unsplash.com/photo-1549078642-b2ba4bda0cdb?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=3&amp;w=144&amp;h=144" alt="" class="w-10 sm:w-16 h-10 sm:h-16 rounded-full">
                                    </div>
                                    <div class="flex flex-col leading-tight">
                                        <div class="text-2xl mt-1 flex items-center">
                                            <span class="text-gray-700 mr-3">Trading Messages</span>
                                        </div>
                                        <span class="text-lg text-gray-600">DayZ Solutions</span>
                                    </div>
                                </div>
                            </div>
                            <div v-for="message in messages" :key="message.id" class="flex flex-col space-y-4 p-3 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
                                <div class="chat-message">
                                    <div class="flex items-start">
                                        <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-2 items-start">
                                            <div><span class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-gray-300 text-gray-600">{{message.message}}</span></div>
                                        </div>
                                        <img src="https://images.unsplash.com/photo-1549078642-b2ba4bda0cdb?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=3&amp;w=144&amp;h=144" alt="My profile" class="w-6 h-6 rounded-full order-1">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
    