<template>
    <svg :class="`icon icon-${icon}`">
        <use :href="svgUrl" :xlink:href="svgUrl" />
    </svg>
</template>

<script lang="ts">
import { defineComponent, computed } from 'vue';

export default defineComponent({
    props: {
        icon: {
            required: true,
            type: String,
        },
    },
    setup(props) {
        const svgUrl = computed(
            () => `/app/themes/supper-saves/dist/svg/sprite.symbol.svg#${props.icon}`,
        );

        return {
            svgUrl,
        };
    },
});
</script>

<style lang="scss">
.icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 1em;
    height: 1em;
    vertical-align: middle;
    fill: currentColor;
}
</style>
