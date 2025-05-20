<template>
    <div>
        <div>A nuxt single file component template</div>

        <div class="card flex justify-center">
            <Button label="Verify" />
        </div>

        <ModalLink href="#confirm-action"> Perform Action </ModalLink>

        <Modal name="confirm-action">
            <!-- ... -->
        </Modal>
    </div>

    <!-- <ModalLink href="/"> Create User </ModalLink> -->
</template>

<script setup>
import { Button } from "primevue";
import { ref } from "vue";

const variable = ref(null);
</script>
