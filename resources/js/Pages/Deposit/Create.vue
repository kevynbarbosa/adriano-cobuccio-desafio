<template>
    <Modal ref="modalRef" max-width="md" v-slot="{ close }" :close-explicitly="true">
        <Head :title="titulo" />

        <TituloCard :titulo="titulo"></TituloCard>

        <div class="my-2 text-sm italic">Preencha as informações necessárias para realizar o depósito</div>

        <form @submit.prevent="submit" autocomplete="off">
            <div class="flex flex-col gap-4">
                <FieldWrap v-model="form" field="amount" label="Valor" currency />

                <div v-if="form.amount" class="text-center">
                    <div>Seu saldo após a depósito será de:</div>
                    <div class="font-bold">R$ {{ decimalLocale(newBalance) }}</div>
                </div>
            </div>

            <div class="mt-4 flex justify-center gap-2">
                <Button label="Cancelar" severity="secondary" @click="close" />
                <Button label="Salvar" type="submit" :loading="form.processing" />
            </div>
        </form>
    </Modal>
</template>

<script setup>
import FieldWrap from "@/Components/Form/FieldWrap.vue";
import TituloCard from "@/Components/TituloCard.vue";
import { decimalLocale } from "@/Utils/decimalUtils";
import { Head, useForm } from "@inertiajs/vue3";
import { Button } from "primevue";
import { useToast } from "primevue/usetoast";
import { computed, ref } from "vue";

const toast = useToast();

const props = defineProps({
    balance: {
        type: Number,
        required: true,
    },
});

const titulo = "Realizar depósito";

const form = useForm({
    amount: null,
});

const newBalance = computed(() => {
    if (form.amount) {
        return props.balance + form.amount;
    }

    return props.balance;
});

const modalRef = ref(null);
function submit() {
    form.post(route("deposit.store"), {
        onSuccess: () => {
            toast.add({ severity: "success", summary: "Sucesso", detail: "Depósito solicitada", life: 3000 });
            modalRef.value.close();
        },
        onError: (errors) => {
            toast.add({
                severity: "error",
                summary: "Erro",
                detail: "Ocorreu um erro ao solicitar depósito",
                life: 3000,
            });
        },
    });
}
</script>
