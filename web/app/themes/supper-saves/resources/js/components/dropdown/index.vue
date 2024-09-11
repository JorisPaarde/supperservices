<template>
    <div class="md:relative">
        <div @click="toggleDropdown">
            <slot name="trigger" :showDropdown="showDropdown" />
        </div>
        <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
        >
            <div
                v-show="showDropdown"
                class="bg-secondary absolute right-0 z-[52] mt-[25px] min-w-[224px] origin-top-right overflow-hidden text-white focus:outline-none md:mt-4"
            >
                <slot name="items" />
            </div>
        </transition>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';

export default defineComponent({
    setup() {
        const showDropdown = ref(false);

        const toggleDropdown = () => {
            showDropdown.value = !showDropdown.value;
        };

        return {
            showDropdown,
            toggleDropdown,
        };
    },
});
</script>
