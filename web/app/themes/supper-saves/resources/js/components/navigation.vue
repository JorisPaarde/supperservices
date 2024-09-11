<template>
    <nav :class="['navbar', { open: isMenuOpen }]">
        <slot />
    </nav>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import useNavigation from '@/composables/navigation';

export default defineComponent({
    setup() {
        const { isMenuOpen } = useNavigation();

        return {
            isMenuOpen,
        };
    },
});
</script>
