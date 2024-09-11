<template>
    <div>
        <slot :showContent="showContent" :toggleContent="toggleContent" />
    </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';

export default defineComponent({
    name: 'UiToggle',
    setup() {
        const showContent = ref(false);

        const toggleContent = () => {
            showContent.value = !showContent.value;
        };

        return {
            showContent,
            toggleContent,
        };
    },
});
</script>
