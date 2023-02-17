<script setup>
import { ref } from 'vue';
import PrimaryLink from "./PrimaryLink.vue";

defineProps({
    data: {
        type: Array,
        default: () => [],
    }
});

const getIdentifier = (item) => {
    return item.map((item) => {
        return item.identifier;
    }).join(', ');
}

//perhaps this should be a prop
const headers = ref (['Created By', 'Items', 'Created At', 'Actions']);

</script>

<template>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
        <tr>
            <th v-for="(header, i) in headers" :key="i" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ header }}
            </th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        <tr v-for="(item, i) in data" :key="item">
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ item.created_by }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-500">{{ getIdentifier(item.item_identifiers) }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-500">{{ item.created_at }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <PrimaryLink class="mb-4" :href="route('rma.show', item.id)">View RMA</PrimaryLink>
            </td>
        </tr>
        </tbody>
    </table>
</template>
