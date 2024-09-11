<template>
    <swiper
        :autoplay="{
            delay: 5000,
            disableOnInteraction: false,
        }"
        :pagination="pagination"
        :modules="modules"
        class="relative"
    >
        <slot />
        <div
            class="pagination absolute left-0 bottom-6 z-30 flex w-full items-center justify-center gap-4"
        ></div>
    </swiper>
</template>

<script lang="ts">
import { Pagination, Autoplay } from 'swiper';
import { defineComponent } from 'vue';

export default defineComponent({
    setup() {
        return {
            pagination: {
                el: '.pagination',
                clickable: true,
            },
            modules: [Pagination, Autoplay],
        };
    },
});
</script>

<style lang="scss">
.swiper-pagination-bullet {
    @apply block h-[3px] w-[50px] bg-black opacity-30;

    &-active {
        @apply bg-secondary opacity-100;
    }
}
</style>
