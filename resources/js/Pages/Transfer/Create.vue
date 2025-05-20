<template>
    <Modal ref="modalRef" max-width="md" v-slot="{ close }">
        <Head title="titulo" />

        <TituloCard :titulo="titulo"></TituloCard>

        <div class="my-2 text-sm italic">Preencha as informações necessárias para realizar a transferência</div>

        <form @submit.prevent="submit" autocomplete="off">
            <div class="flex flex-col gap-4">
                <FieldWrap v-model="form" field="account" label="Conta" />

                <FieldWrap v-model="form" field="document" label="CPF/CNPJ" cpf_cnpj />

                <FieldWrap v-model="form" field="amount" label="Valor" currency />

                <div class="text-center">Novo saldo após a transferência: R$ {{ newBalance }}</div>
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
import { Head, useForm } from "@inertiajs/vue3";
import { Button } from "primevue";
import { computed, ref } from "vue";

const props = defineProps({
    balance: {
        type: Number,
        required: true,
    },
});

const titulo = "Realizar transferência";

const form = useForm({
    account: "",
    document: "",
    amount: null,
});

const variable = ref(null);

const newBalance = computed(() => {
    if (form.amount) {
        return props.balance - form.amount;
    }

    return props.balance;
});

const modalRef = ref(null);
function submit() {
    form.post(route("transfer.store"), {
        onSuccess: () => {
            modalRef.value.close();
        },
    });
}
</script>
