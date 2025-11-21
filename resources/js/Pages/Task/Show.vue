<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Dropdown from "@/Components/Dropdown.vue";
import Select from "@/Components/Select.vue";

const props = defineProps({
    task: Object,
});

const form = useForm({
    text: props.task.text,
    project_id: props.task.project_id,
    status: props.task.status
});

const submit = () => {
    form.patch(route('task.update', props.task.id), {
        onSuccess: () => form.reset('text')
    });
};
</script>

<template>
    <Head title="Task" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Task</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="flex flex-col">
                            <InputLabel for="text" value="Current task description" />
                            <TextInput
                                id="text"
                                type="text"
                                placeholder="Enter a description for the task"
                                class="mt-1 block w-full"
                                v-model="form.text"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.text" />
                        </div>

                        <div class="flex flex-col pt-5">
                            <InputLabel for="state" value="Current task state" />
                            <Select
                                id="state"
                                v-model="form.status"
                                :options="['pending', 'in_development', 'in_testing', 'in_review', 'completed']"
                                required
                            ></Select>
                        </div>

                        <div class="p-4 pl-0">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Store
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
