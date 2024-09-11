<template>
    <button
        :class="[
            `
                menu-button
                flex
                items-center
                justify-center
                outline-none
                focus:outline-none
            `,
            {
                open: isMenuOpen,
            },
        ]"
        aria-label="Toggle mobile menu"
        @click="toggleMenu"
    >
        <div class="menu-button-inner">
            <span />
            <span />
            <span />
            <span />
        </div>
    </button>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import useNavigation from '@/composables/navigation';

export default defineComponent({
    name: 'MenuButton',
    props: {
        isOpen: {
            type: Boolean,
            default: false,
        },
    },
    setup() {
        const { isMenuOpen, toggleMenu } = useNavigation();

        return {
            isMenuOpen,
            toggleMenu,
        };
    },
});
</script>

<style lang="scss" scoped>
.menu-button {
    @apply z-[60] h-10 w-10 transition duration-[50ms] ease-in-out;

    @screen xl {
        @apply hidden;
    }

    &-inner {
        @apply relative h-4 w-6;
    }
    span {
        @apply bg-primary absolute left-0 block h-0.5 w-full rounded-sm;
        transition: 0.25s ease-in-out;

        &:nth-child(1) {
            @apply top-0;
        }

        &:nth-child(2),
        &:nth-child(3) {
            @apply top-[7px];
        }

        &:nth-child(4) {
            @apply top-[14px];
        }
    }

    &.open span {
        @apply bg-white;

        &:nth-child(1),
        &:nth-child(4) {
            @apply top-[7px] left-1/2 w-0;
        }

        &:nth-child(2) {
            @apply rotate-45;
        }

        &:nth-child(3) {
            @apply -rotate-45;
        }
    }
}
</style>
