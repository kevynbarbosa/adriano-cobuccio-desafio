<template>
    <div
        class="my-2 flex gap-4 rounded-lg p-4 transition duration-200 ease-in-out hover:bg-gray-100"
        :class="{ 'line-through': transaction.status == 'REFUNDED' }"
    >
        <div
            class="flex h-12 w-12 items-center justify-center rounded"
            :class="{ 'bg-green-300': transaction.subtype == 'RECEIVED', 'bg-red-200': transaction.subtype == 'SENT' }"
        >
            <i v-if="transaction.subtype == 'RECEIVED'" class="mdi mdi-arrow-down"></i>
            <i v-if="transaction.subtype == 'SENT'" class="mdi mdi-arrow-up"></i>
        </div>

        <div class="flex grow flex-col justify-between">
            <div class="text-sm font-semibold">{{ transaction.name }}</div>
            <div class="text-sm text-gray-500">R$ {{ decimalLocale(transaction.amount) }}</div>
            <div class="text-xs">{{ transaction.type }} {{ transaction.status }}</div>
            <div class="text-xs text-gray-500">{{ dateTimeLocale(transaction.date) }}</div>
        </div>

        <div class="shrink" v-if="undoAvailable">
            <ModalLink :href="undoRoute" as="div">
                <Button label="Desfazer" icon="mdi mdi-undo" severity="danger" size="small" />
            </ModalLink>
        </div>
    </div>
</template>

<script setup>
import { dateTimeLocale } from "@/Utils/dateUtils";
import { decimalLocale } from "@/Utils/decimalUtils";
import { Button } from "primevue";
import { computed, ref } from "vue";

const props = defineProps({
    transaction: {
        type: Object,
        required: true,
    },
});

const variable = ref(null);

const undoAvailable = computed(() => {
    if (props.transaction.status == "REFUNDED" || props.transaction.status == "FAILED") {
        return false;
    }

    if (props.transaction.type == "DEPOSIT") {
        return true;
    }

    if (props.transaction.type == "TRANSFER" && props.transaction.subtype == "SENT") {
        return true;
    }

    return false;
});

const undoRoute = computed(() => {
    if (props.transaction.type == "DEPOSIT") {
        return route("deposit.undo", props.transaction.id);
    }

    if (props.transaction.type == "TRANSFER") {
        return route("transfer.undo", props.transaction.id);
    }

    return null;
});
</script>
