<template>
    <transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="transform opacity-0"
        enter-to-class="transform opacity-100"
        leave-active-class="transition ease-in duration-300 delay-150"
        leave-from-class="transform opacity-100"
        leave-to-class="transform opacity-0"
    >
        <div
            v-show="isMiniCartOpen"
            class="bg-primary fixed top-0 left-0 z-[100] h-screen w-full bg-opacity-90 transition"
        >
            <div class="flex h-full w-full">
                <transition
                    enter-active-class="transition ease-out duration-300 delay-150"
                    enter-from-class="transform translate-x-3/4 opacity-0"
                    enter-to-class="transform translate-x-0 opacity-100"
                    leave-active-class="transition ease-in duration-300"
                    leave-from-class="transform translate-x-0 opacity-100"
                    leave-to-class="transform translate-x-3/4 opacity-0"
                >
                    <div
                        v-show="isMiniCartOpen"
                        class="relative ml-auto h-screen w-full max-w-[600px] bg-white p-[50px]"
                    >
                        <button
                            class="hover:bg-secondary border-secondary text-secondary absolute top-11 right-11 flex h-10 w-10 items-center justify-center rounded-full border-2 text-sm transition hover:text-white"
                            @click="toggleMiniCart"
                        >
                            <icon icon="x"></icon>
                        </button>
                        <slot />
                    </div>
                </transition>
            </div>
        </div>
    </transition>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import Icon from '@/components/icon.vue';
import useMiniCart from '@/composables/mini-cart';

export default defineComponent({
    components: {
        Icon,
    },
    setup() {
        const { isMiniCartOpen, toggleMiniCart } = useMiniCart();

        return {
            isMiniCartOpen,
            toggleMiniCart,
        };
    },
});
</script>
