<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { Inertia } from '@inertiajs/inertia';
    
    const props = defineProps({
        errors: Object
    })
    
    const form = useForm({
        match_case: '',
        exact_match: '',
        type: 'currency'
    })
    function submit() {
        Inertia.post(route('filters.store'), form);
    }
    </script>
        
    <template>
    
        <Head title="Dashboard" />
    
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Add Filter
                </h2>
            </template>
    
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <form @submit.prevent="submit" class="px-8 pt-6 pb-8 mb-4">
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="match_case">
                                        Match case
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="match_case" name="match_case" type="text" v-model="form.match_case" placeholder="Filter word">
                                    <span v-if="props.errors.match_case" class="text-red-500 text-sm">{{props.errors.match_case}}</span>
                                </div>
    
                                <div class="md:flex md:items-center mb-6">
                                    <label class="md:w-2/3 block text-gray-500 font-bold">
                                        <input class="mr-2 leading-tight" type="checkbox" id="exact_match" name="exact_match" v-model="form.exact_match">
                                        <span class="text-sm">
                                            Exact match?
                                        </span>
                                    </label>
                                </div>
    
                        
                                <div class="flex items-center justify-between">
                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                        Create
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </template>
        