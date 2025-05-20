<template>
    <div>
        <FloatLabel variant="in">
            <InputText
                v-if="mask"
                :id="field"
                class="w-full"
                size="small"
                v-model="model[field]"
                variant="filled"
                v-mask="mask"
                v-bind="$attrs"
            />

            <InputNumber
                v-else-if="props.currency"
                v-model="model[field]"
                :id="field"
                inputId="currency-br"
                mode="currency"
                currency="BRL"
                locale="pt-BR"
                :minFractionDigits="2"
                :maxFractionDigits="2"
                fluid
                v-bind="$attrs"
            />

            <Select
                v-else-if="props.select"
                :id="field"
                class="w-full"
                size="small"
                v-model="model[field]"
                :options="props.selectOptions"
                variant="filled"
                v-bind="$attrs"
            />

            <DatePicker
                v-else-if="props.datepicker"
                :id="field"
                class="w-full"
                size="small"
                v-model="model[field]"
                variant="filled"
                show-time
                hourFormat="24"
                :stepMinute="5"
                v-bind="$attrs"
            />

            <InputText
                v-else
                :id="field"
                class="w-full"
                size="small"
                v-model="model[field]"
                variant="filled"
                v-bind="$attrs"
            />

            <label :for="field">{{ label }}</label>
        </FloatLabel>
        <div class="text-red-500" v-if="model.errors[field]">{{ model.errors[field] }}</div>
    </div>
</template>

<script setup>
import { DatePicker, FloatLabel, InputNumber, InputText } from "primevue";
import Select from "primevue/select";
import { computed } from "vue";

const model = defineModel(); // Form Object
const props = defineProps({
    field: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    cpf: {
        type: Boolean,
        default: false,
    },
    cnpj: {
        type: Boolean,
        default: false,
    },
    cpf_cnpj: {
        type: Boolean,
        default: false,
    },
    cep: {
        type: Boolean,
        default: false,
    },
    phone: {
        type: Boolean,
        default: false,
    },
    currency: {
        type: Boolean,
        default: false,
    },
    datepicker: {
        type: Boolean,
        default: false,
    },

    select: {
        type: Boolean,
        default: false,
    },

    selectOptions: {
        type: Array,
        default: () => [],
    },
});

const mask = computed(() => {
    if (props.cep) return "#####-###";
    if (props.cpf) return "###.###.###-##";
    if (props.cnpj) return "##.###.###/####-##";
    if (props.cpf_cnpj) return ["###.###.###-##", "##.###.###/####-##"];
    if (props.phone) return ["(##) #####-####", "(##) ####-####"];

    return null;
});
</script>
