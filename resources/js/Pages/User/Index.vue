<script setup>

import {Head, Link, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DangerButton from "@/Components/DangerButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {onMounted} from "vue";

const props = defineProps({
    users: Object,
});

function blockUser(user_id, value) {
    useForm({ value })
        .patch(route('user.block', user_id));
}

function deleteUser(user_id) {
    useForm({}).delete(route('user.destroy', user_id));
}
</script>

<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Users</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div>
                        <!--<input type="text" v-model="search" @input="searchHandler" placeholder="Search..." />-->
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3">Name</th>
                                    <th class="px-6 py-3">Email</th>
                                    <th class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" :key="user.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100">
                                    <td class="px-6 py-2">
                                        {{ user.name }}
                                    </td>
                                    <td class="px-6 py-2">
                                        {{ user.email }}
                                    </td>
                                    <td class="px-6 py-2 flex flex-row gap-2">
                                        <PrimaryButton
                                            class="py-0.5 w-[100px] justify-center"
                                            :class="{ 'bg-red-600': !user.is_blocked, 'bg-green-600': !!user.is_blocked }"
                                            @click="blockUser(user.id, !user.is_blocked)"
                                        >{{ !!user.is_blocked ? 'Unlock' : 'Block' }}</PrimaryButton>

                                        <DangerButton
                                            class="py-0.5 justify-center"
                                            @click="deleteUser(user.id)"
                                        >Force delete</DangerButton>
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
