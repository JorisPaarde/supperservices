<template>
    <div class="timeline mb-10 md:mb-[100px]">
        <div class="container relative mx-auto w-full py-36">
            <div class="absolute left-1/2 top-0 h-full w-0.5 -translate-x-0.5 bg-gray-400" />
            <ul class="grid grid-cols-1 gap-24 lg:grid-cols-2">
                <li
                    v-for="(item, index) in items"
                    :key="`timeline_item_${index}`"
                    class="timeline-item"
                >
                    <div
                        :ref="
                            (el) => {
                                cards[index] = el;
                            }
                        "
                        :class="[
                            'timeline-item-inner relative flex -translate-y-24 opacity-0',
                            {
                                'bg-primary text-white': index === 0,
                                'bg-secondary ': index === 1,
                                'bg-whisper': index === 2,
                                'bg-carousel-pink': index === 3,
                                'bg-cinnabar text-white': index === 4,
                                'bg-petite-orchid text-heavy-metal': index === 5,
                            },
                        ]"
                    >
                        <div class="timeline-pointer" />
                        <div class="timeline-pointer-tail" />
                        <figure class="relative w-1/3 overflow-hidden">
                            <img
                                :src="item.image.url"
                                :width="item.image.width"
                                :height="item.image.height"
                                alt=""
                                class="absolute top-0 left-0 h-full w-full object-cover"
                            />
                        </figure>
                        <div class="w-2/3 p-12 md:p-20">
                            <p class="font-title mb-6 text-4xl">
                                {{ index + 1 }}
                            </p>
                            <h2 data-title-reveal class="mb-6 text-2xl">
                                {{ item.title }}
                            </h2>
                            <p class="text-lg md:text-2xl">
                                {{ item.content }}
                            </p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, onBeforeUpdate, onMounted, ref } from 'vue';

import { gsap } from 'gsap';
import ScrollTrigger from 'gsap/dist/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export default defineComponent({
    props: {
        items: {
            type: Array,
            required: true,
        },
    },
    setup() {
        const cards = ref([]);

        const effect = () => {
            cards.value.forEach((el) => {
                ScrollTrigger.create({
                    trigger: el,
                    start: 'top center+=30vh',
                    onEnter: () => {
                        gsap.to(el, {
                            duration: 1.2,
                            opacity: 1,
                        });
                    },
                });

                gsap.to(el, {
                    y: 0,
                    stagger: 0.1,
                    scrollTrigger: {
                        trigger: el,
                        scrub: true,
                    },
                });
            });
        };

        onBeforeUpdate(() => {
            cards.value = [];
        });

        onMounted(() => {
            effect();
        });

        return {
            cards,
        };
    },
});
</script>

<style lang="scss" scoped>
.timeline {
    background-image: url('/app/themes/supper-saves/dist/images/timeline_bg.jpg');
    background-size: cover;

    &-item {
        @apply lg:even:translate-y-[50%] lg:last-of-type:mb-[50%];

        &:nth-child(even) {
            .timeline-item-inner {
                @apply flex-row-reverse;
            }

            .timeline-pointer {
                @apply right-auto -left-[57px];

                &-tail {
                    @apply right-auto -left-12;
                }
            }
        }
    }

    &-pointer {
        @apply bg-secondary absolute -right-[57px] top-1/2 z-10 hidden h-4 w-4 -translate-y-2 rounded-full border-4 border-white lg:block;

        &-tail {
            @apply absolute -right-12 top-1/2 hidden h-0.5 w-12 -translate-y-[1px] rounded-full bg-gray-400 lg:block;
        }
    }
}
</style>
