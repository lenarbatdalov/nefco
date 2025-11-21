<script setup>
import {Head, Link, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Checkbox from "@/Components/Checkbox.vue";
import {onMounted} from "vue";

const props = defineProps({
    project: Object,
    tasks: Object,
    currentState: String,
});

const form = useForm({
    text: '',
    project_id: props.project.id
});

const submit = () => {
    form.post(route('task.store'), {
        onSuccess: () => form.reset('text')
    });
};

function formatDate(dateString, format = 'YYYY-MM-DD') {
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('default', { dateStyle: 'long' }).format(date);
}

const deleteTask = (id) => {
    useForm({})
        .delete(route('task.destroy', id), {
            preserveScroll: true,
        });
};

function checkHandle(event) {
    useForm({
        is_completed: event.target.checked
    }).patch(route('task.update', event.target.id));
}

function handleClick(status) {
    useForm({state: status})
        .get(route('project.show', props.project.id));
}
</script>

<template>
    <Head title="Project" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Project tasks</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="flex flex-row gap-2">
                            <TextInput
                                id="text"
                                type="text"
                                placeholder="Enter a description for the new task"
                                class="mt-1 block w-full"
                                v-model="form.text"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.text" />

                            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Store
                            </PrimaryButton>
                        </div>
                    </form>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div>
                        <!--<input type="text" v-model="search" @input="searchHandler" placeholder="Search..." />-->
                        <div class="flex flex-row gap-2 py-2">
                            <SecondaryButton
                                :class="{ 'bg-blue-200': props.currentState == 'all' }"
                                @click="handleClick('all')"
                            >All</SecondaryButton>

                            <SecondaryButton
                                :class="{ 'bg-blue-200': props.currentState == 'active' }"
                                @click="handleClick('active')"
                            >Active</SecondaryButton>

                            <SecondaryButton
                                :class="{ 'bg-blue-200': props.currentState == 'completed' }"
                                @click="handleClick('completed')"
                            >Completed</SecondaryButton>
                        </div>
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3"></th>
                                    <th class="px-6 py-3">Text</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3">Date of creation</th>
                                    <th class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr
                                    v-for="task in tasks" :key="task.id"
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100"
                                    :class="{ 'line-through': !!task.is_completed }"
                                >
                                    <td class="px-6 py-4">
                                        <Checkbox
                                            :checked="!!task.is_completed"
                                            :id="task.id"
                                            @click="checkHandle"
                                        ></Checkbox>
                                    </td>
                                    <td class="px-6 py-4">
                                        <Link
                                            v-if="!task.is_completed"
                                            :href="route('task.show', task.id)"
                                            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                                        >{{ task.text }}</Link>
                                        <span v-else>{{ task.text }}</span>
                                    </td>
                                    <td class="px-6 py-4">{{ task.status }}</td>
                                    <td class="px-6 py-4">{{ formatDate(task.created_at) }}</td>
                                    <td class="px-6 py-4">
                                        <DangerButton
                                            class="py-0.5"
                                            :class="{ 'opacity-25': form.processing }"
                                            :style="{ 'display': task.deleted_at == null ? '' : 'none' }"
                                            :disabled="form.processing"
                                            @click="deleteTask(task.id)"
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
