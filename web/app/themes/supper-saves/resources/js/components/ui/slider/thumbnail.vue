<template>
    <div>
        <swiper
            :modules="modules"
            :thumbs="{ swiper: thumbsSwiper }"
            :autoplay="{
                delay: 5000,
                disableOnInteraction: false,
            }"
            class="main"
        >
            <slot name="main" />
        </swiper>
        <swiper
            :modules="modules"
            :space-between="20"
            :slides-per-view="5"
            :free-mode="true"
            :watch-slides-progress="true"
            class="thumbs mt-4"
            @swiper="setThumbsSwiper"
        >
            <slot name="thumbs" />
        </swiper>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref, Ref } from 'vue';
import { SwiperOptions, Autoplay, FreeMode, Navigation, Thumbs } from 'swiper';

export default defineComponent({
    setup() {
        const thumbsSwiper: Ref<SwiperOptions | null> = ref(null);

        const setThumbsSwiper = (swiper: SwiperOptions) => {
            thumbsSwiper.value = swiper;
        };

        return {
            thumbsSwiper,
            setThumbsSwiper,
            modules: [Autoplay, FreeMode, Navigation, Thumbs],
        };
    },
});
</script>

<style lang="scss">
.thumbs {
    .swiper-slide-thumb-active {
        @apply border-b border-gray-400 pb-3;
    }
}
</style>
