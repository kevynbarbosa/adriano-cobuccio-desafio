<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Carteira</h2>
        </template>

        <div class="pt-4">
            <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white p-4 shadow-sm sm:rounded-lg">
                    <div class="flex items-center justify-center text-2xl">
                        <div>Saldo:</div>
                        <div class="ml-2 font-semibold" :class="{ 'text-red-600': balance < 0 }">
                            R$ {{ decimalLocale(balance) }}
                        </div>
                    </div>

                    <div class="mt-4 flex justify-center gap-4">
                        <ModalLink :href="route('transfer.create')" as="div">
                            <Button label="Transferir" severity="info"></Button>
                        </ModalLink>

                        <ModalLink :href="route('deposit.create')" as="div">
                            <Button label="Depositar"></Button>
                        </ModalLink>
                    </div>
                </div>
            </div>
        </div>

        <TransactionsList :transactions="transactions" />
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { decimalLocale } from "@/Utils/decimalUtils";
import { Head, router } from "@inertiajs/vue3";
import { Button } from "primevue";
import { onMounted, onUnmounted } from "vue";
import TransactionsList from "./partials/TransactionsList.vue";

const props = defineProps({
    balance: {
        type: Number,
        required: true,
    },
    transactions: {
        type: Array,
        required: true,
    },
});

let interval = null;

onMounted(() => {
    interval = setInterval(() => {
        router.reload({ only: ["balance", "transactions"], preserveScroll: true, preserveState: true });
    }, 3000);
});

onUnmounted(() => {
    clearInterval(interval);
});
</script>
