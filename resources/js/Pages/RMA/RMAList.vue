<script setup>
import AppLayout from "../../Layouts/AppLayout.vue";
import Card from "../../Components/Card.vue";
import RMATable from "../../Components/RMATable.vue";
import PrimaryLink from "../../Components/PrimaryLink.vue";

defineProps({
    data: Array
});

</script>

<template>
    <AppLayout>
        <Card class="py-12">
            <div class="flex justify-between">
                <h1 class="pb-4">RMAs</h1>
                    <PrimaryLink class="mb-4" :href="route('rma.create')">Create RMA</PrimaryLink>
            </div>
            <RMATable :data="data" />
        </Card>
    </AppLayout>
</template>


