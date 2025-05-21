<template>
    <Modal class="bg-grey-900" ref="modalRef" max-width="md" v-slot="{ close }" :close-explicitly="true">
        <Head :title="titulo" />

        <TituloCard :titulo="titulo"></TituloCard>

        <div>Deseja reverter a depósito?</div>

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
import { Button, useToast } from "primevue";
import { ref } from "vue";

const props = defineProps({
    transaction: {
        type: Object,
        required: true,
    },
});

const toast = useToast();

const titulo = "Reverter depósito";

const form = useForm({});

const modalRef = ref(null);
function submit() {
    form.post(route("deposit.undoStore", { transaction: props.transaction.id }), {
        onSuccess: () => {
            toast.add({ severity: "success", summary: "Sucesso", detail: "Reversão solicitada", life: 3000 });
            modalRef.value.close();
        },
        onError: (errors) => {
            toast.add({
                severity: "error",
                summary: "Erro",
                detail: "Ocorreu um erro ao solicitar reversão da depósito",
                life: 3000,
            });
        },
    });
}
</script>
