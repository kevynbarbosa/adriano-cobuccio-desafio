<template>
    <div class="pt-4">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            <div class="card">
                <TransactionCard v-for="transaction in transactions" :key="transaction.id" :transaction="transaction" />
            </div>
        </div>
    </div>
</template>

<script setup>
import TransactionCard from "@/Components/Transaction/TransactionCard.vue";
import { ref } from "vue";

const props = defineProps({
    transactions: {
        type: Array,
        required: true,
    },
});
const variable = ref(null);
</script>
