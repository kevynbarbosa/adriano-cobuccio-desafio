<template>
    <div>A nuxt single file component template</div>

    <div class="card flex justify-center">
        <Button label="Verify" />
    </div>
</template>

<script setup>
import { Button } from "primevue";
import { ref } from "vue";

const variable = ref(null);
</script>
