<template>
    <div
        v-if="Object.keys(form.errors).length > 0"
        class="mt-4 flex items-center justify-center rounded bg-red-200 p-2 font-bold text-red-500"
    >
        <i class="mdi mdi-alert-box text-[22px]" v-tooltip="tooltip"></i>
        <div>Existem erros de validação</div>
    </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
});

const tooltip = computed(() => {
    return Object.values(props.form.errors).join("\n - ");
});
</script>
