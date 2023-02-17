<template>
    <Head title="Create RMA"/>
    <AppLayout>
        <Card class="py-12">
            <h1 class="mb-4">Create RMA</h1>

            <form @submit.prevent="submit">
                <div class="flex justify-between mb-4" v-for="(item) in form.items" :key="item.id">
                    <SelectInput class="mr-2" v-model="item.type" :options="formattedTypes"/>
                    <SelectInput class="mr-2" v-model="item.value" :options="getItems(item.type)"/>
                    <TextInput class="px-2" placeholder="Identifier" v-model="item.identifier"/>
                    <TextInput class="px-2" placeholder="Reason" v-model="item.reason"/>
                    <DangerButton v-if="form.items.length > 1" @click="removeItem(item.id)">X</DangerButton>
                </div>
                <InputError class="mb-2" v-for="(error, i) in form.errors" :message="error" />
                <div class="mt-4 flex justify-end">
                    <SecondaryButton @click="addItem">Add Item</SecondaryButton>
                </div>
                <div class="mt-4 flex justify-end">
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        {{ form.processing ? 'Processing...' : 'Create RMA' }}
                    </PrimaryButton>
                </div>
            </form>

        </Card>
    </AppLayout>
</template>

<script setup>
import {computed} from "vue";
import {useForm, Head} from "@inertiajs/vue3";
import AppLayout from "../../Layouts/AppLayout.vue";
import Card from "../../Components/Card.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import SecondaryButton from "../../Components/SecondaryButton.vue";
import SelectInput from "../../Components/SelectInput.vue";
import TextInput from "../../Components/TextInput.vue";
import DangerButton from "../../Components/DangerButton.vue";
import InputError from "../../Components/InputError.vue";

const props = defineProps({
    types: {
        type: Array,
        default: () => []
    }
});

const randomId = () => {
    return Math.random().toString(36).substr(2, 9);
}

const form = useForm({
    items: [
        {
            id: randomId(),
            type: '',
            value: '',
            identifier: '',
            reason: '',
        }
    ]
});

const submit = () => {
    form.transform(data => ({
        items: data.items.map(item => ({
            type: item.type,
            value: item.value,
            identifier: item.identifier,
            reason: item.reason,
        }))
    })).post(route('rma.store'));
};

const formattedTypes = computed(() => {
    return [
        {
            text: 'Select Type',
            value: ''
        },
        ...props.types.map(type => {
            return {
                text: type.text,
                value: type.value
            }
        })
    ]
});

const getItems = (type) => {
    const item = props.types.find(t => t.value === type);

    return [{
        text: 'Select Item',
        value: ''
    }, ...(item ? item.items : [])];
}

const addItem = () => {
    form.items.push({
        id: randomId(),
        type: '',
        value: '',
        identifier: '',
        reason: '',
    });
}

const removeItem = (id) => {
    form.items = form.items.filter(item => item.id !== id);
}

</script>
