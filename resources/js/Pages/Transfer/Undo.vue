<template>
    <Modal class="bg-grey-900" ref="modalRef" max-width="md" v-slot="{ close }" :close-explicitly="true">
        <Head :title="titulo" />

        <TituloCard :titulo="titulo"></TituloCard>

        <div>Deseja reverter a transferência?</div>

        <form @submit.prevent="submit" autocomplete="off">
            <div class="mt-4 flex justify-center gap-2">
                <Button label="Cancelar" severity="secondary" @click="close" />
                <Button label="Reverter" type="submit" severity="danger" :loading="form.processing" />
            </div>
        </form>
    </Modal>
</template>

<script setup>
import TituloCard from "@/Components/TituloCard.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { Button } from "primevue";
import { ref } from "vue";

const props = defineProps({
    transaction: {
        type: Object,
        required: true,
    },
});

const titulo = "Reverter transferência";

const form = useForm({
    transaction_id: props.transaction.id,
});

const modalRef = ref(null);
function submit() {
    form.transform((data) => ({
        ...data,
        document: data.document.replace(/\D/g, ""), // Removendo pontuação da máscara
    })).post(route("transfer.store"), {
        onSuccess: () => {
            toast.add({ severity: "success", summary: "Sucesso", detail: "Transferência solicitada", life: 3000 });
            modalRef.value.close();
        },
        onError: (errors) => {
            toast.add({
                severity: "error",
                summary: "Erro",
                detail: "Ocorreu um erro ao solicitar transferência",
                life: 3000,
            });
        },
    });
}
</script>
