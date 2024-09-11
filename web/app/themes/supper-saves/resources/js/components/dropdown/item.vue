<template>
    <a
        :href="link"
        :target="target"
        :rel="target === '_blank' ? 'nofollow noreferrer noopener' : ''"
        :class="[
            'hover:bg-primary flex items-center px-6 py-5 text-xl transition hover:text-white',
            {
                'bg-primary text-white': active,
            },
            $attrs.class,
        ]"
    >
        <slot />
    </a>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
    props: {
        active: {
            type: Boolean,
            default: false,
        },
        link: {
            type: String,
            required: true,
        },
        target: {
            type: String,
            default: '_self',
        },
    },
});
</script>
