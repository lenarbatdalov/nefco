<script setup>
const props = defineProps({
    options: {
        type: Array,
        required: true,
    },
    value: {
        default: null,
    },
});

const model = defineModel({
    type: String,
    required: true,
});
</script>

<template>
    <select
        v-model="model"
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
    >
        <option
            v-for="option in props.options"
            :key="option"
        >{{ option }}</option>
    </select>
</template>

<style scoped>

</style>
