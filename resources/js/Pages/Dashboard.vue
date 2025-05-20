<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { decimalLocale } from "@/Utils/decimalUtils";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    balance: {
        type: Number,
        required: true,
    },
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Carteira</h2>
        </template>

        <div class="pt-8">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <b>Saldo:</b>
                        R$ {{ decimalLocale(balance) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-4">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="flex gap-4 p-6 text-gray-900">
                        <ModalLink class="rounded bg-indigo-300 p-2" :href="route('transfer.create')">
                            Transferir
                        </ModalLink>

                        <ModalLink class="rounded bg-indigo-300 p-2" :href="route('transfer.create')">
                            Depositar
                        </ModalLink>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
