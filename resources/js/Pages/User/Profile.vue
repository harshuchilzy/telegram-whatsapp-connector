<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { Head } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { ref, onUpdated } from 'vue';
import Swal from 'sweetalert2';



const form = useForm({
    id: props.user.id,
    name: props.user.name,
    email: props.user.email,
    password: props.user.password
})
const props = defineProps({
    user: Object,
    errors: Object,
    flash: Object,
})

function submit() {
    Inertia.put(route('user.profile.update', props.user.id), form);
}

onUpdated(() => {
    if (props.flash.success) {
        Swal.fire({
            icon: 'success',
            title: props.flash.success,
            showConfirmButton: false,
            timer: 1500
        })
    } else if (props.flash.error) {
        Swal.fire(
            'Fail!',
            props.flash.error,
            'error'
        )
    }
})
</script>
    
<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profile
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="submit" class="px-8 pt-6 pb-8 mb-4">
                    <input class="shadow d-none" id="id" type="text" v-model="form.id" placeholder="User Name" hidden>

                    <div class="grid grid-cols-3 gap-4">
                            <div class="mb-4">
                                        <label class="block text-gray-700 text-sm font-bold mb-2" for="match_case">
                                            Name
                                            </label>
                                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" v-model="form.name" placeholder="User Name" required>
                                            <span v-if="props.errors.name" class="text-red-500 text-sm">{{props.errors.name}}</span>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2" for="match_case">
                                            Email
                                            </label>
                                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email"  type="mail" v-model="form.email" placeholder="User Email" required>
                                            <span v-if="props.errors.email" class="text-red-500 text-sm">{{props.errors.email}}</span>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2" for="match_case">
                                            Password
                                            </label>
                                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password"  type="password" v-model="form.password" placeholder="New Password" required>
                                            <span v-if="props.errors.password" class="text-red-500 text-sm">{{props.errors.password}}</span>
                                        </div>
                            </div>
                            <div class="flex items-center justify-between mt-3">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                    Update
                                </button>
                            </div>
                        </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
    