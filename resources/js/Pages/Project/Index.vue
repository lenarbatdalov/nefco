<script setup>
import {Head, useForm, Link} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps({
    projects: Object,
});

const form = useForm({
    name: ''
});

const submit = () => {
    form.post(route('project.store'), {
        onSuccess: () => form.reset('name')
    });
};

function formatDate(dateString, format = 'YYYY-MM-DD') {
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('default', { dateStyle: 'long' }).format(date);
}

const deleteProject = (id) => {
    useForm({})
        .delete(route('project.destroy', id), {
            preserveScroll: true,
        });
};

function handleInput(id, name) {
    useForm({ name: name })
        .patch(route('project.update', id), {
            preserveScroll: true,
        });
}
</script>

<template>
    <Head title="Project" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Projects</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="flex flex-row gap-2">
                            <TextInput
                                id="name"
                                type="text"
                                placeholder="Enter a description of the new project"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.name" />

                            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Store
                            </PrimaryButton>
                        </div>
                    </form>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div>
                        <!--<input type="text" v-model="search" @input="searchHandler" placeholder="Search..." />-->
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3">Name</th>
                                    <th class="px-6 py-3">Date of creation</th>
                                    <th class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="project in projects" :key="project.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100">
                                    <td class="px-6 py-2">
                                        <TextInput
                                            id="text"
                                            type="text"
                                            placeholder="Enter a description of the project"
                                            class="mt-1 block w-full py-1"
                                            v-model="project.name"
                                            @blur="handleInput(project.id, project.name)"
                                            required
                                        />
                                    </td>
                                    <td class="px-6 py-2">{{ formatDate(project.created_at) }}</td>
                                    <td class="px-6 py-2 flex flex-row gap-2">
                                        <Link
                                            :href="route('project.show', project.id)"
                                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                                        >View tasks</Link>

                                        <DangerButton
                                            class="py-0.5"
                                            :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                            @click="deleteProject(project.id)"
                                        >Delete</DangerButton>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
