import { createApp, onMounted, onBeforeUpdate, ref } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { gsap } from 'gsap';

import * as components from '@/components/index';

import useMiniCart from '@/composables/mini-cart';
import useAnimation from '@/helpers/animations';

const App = createApp({
    components,
    setup() {
        const { toggleMiniCart, notification } = useMiniCart();
        const productItems = ref([] as HTMLDivElement[]);

        const animateProducts = () => {
            if (productItems.value.length) {
                gsap.to(productItems.value, {
                    duration: 0.3,
                    opacity: 1,
                    y: 0,
                    stagger: 0.15,
                });
            }
        };

        onBeforeUpdate(() => {
            productItems.value = [];
        });

        onMounted(() => {
            animateProducts();
            useAnimation();
        });

        return {
            notification,
            productItems,
            toggleMiniCart,
        };
    },
});

App.config.globalProperties.blankImage =
    'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';

App.component('Swiper', Swiper);
App.component('SwiperSlide', SwiperSlide);

App.mount('#app');
