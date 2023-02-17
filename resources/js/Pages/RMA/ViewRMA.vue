<script setup>
import AppLayout from "../../Layouts/AppLayout.vue";
import Card from "../../Components/Card.vue";

defineProps({
    created_at: String,
    created_by: String,
    items: Array
});
</script>

<template>
    <AppLayout>
        <Card class="py-12">
            <h1 class="mb-4">View RMA</h1>
            <p class="pb-4"><strong>Created At</strong> {{ created_at }}</p>
            <p class="pb-4"><strong>Created By</strong> {{ created_by }}</p>
            <p class="pb-4"><strong>Items</strong></p>
            <div class="flex justify-between">
                <strong>Index</strong>
                <strong>Identifier</strong>
                <strong>Type</strong>
                <strong>Value</strong>
                <strong>Reason</strong>
            </div>
            <div class="flex justify-between mb-4" v-for="(item, i) in items" :key="i">
                <span>{{ i + 1}}</span>
                <span>{{ item.identifier }}</span>
                <span>{{ item.type }}</span>
                <span>{{ item.value }}</span>
                <span>{{ item.reason }}</span>

            </div>
        </Card>
    </AppLayout>
</template>
