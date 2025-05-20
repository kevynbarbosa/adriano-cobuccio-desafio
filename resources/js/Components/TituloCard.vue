<template>
    <div class="mb-4 flex">
        <div class="flex-1 text-lg font-bold">
            <i v-if="icon" :class="icon" />
            {{ titulo }}
        </div>
        <slot></slot>
    </div>
</template>

<script setup>
const props = defineProps({
    titulo: {
        type: String,
        required: true,
    },

    icon: {
        type: String,
        required: false,
    },

    icon: {
        type: String,
        required: false,
    },
});
</script>
