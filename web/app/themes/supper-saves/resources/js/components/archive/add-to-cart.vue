<template>
    <div class="flex flex-col items-center gap-4">
        <UiQuantity
            :id="productId"
            v-model="quantity"
            name="qty"
            :min="min"
            :max="max"
            :step="step"
            full-width
        />
        <a
            :href="addToCartLink"
            aria-label="product"
            :data-quantity="quantity"
            :data-product_id="productId"
            :data-product_sku="productSku"
            :class="[
                `
                    wp-block-button__link 
                    add_to_cart_button 
                    product__button
                    button 
                    lg:!text-primary
                    lg:hover:!bg-secondary
                    w-full
                    justify-center
                    text-center
                    lg:!bg-white
                    lg:hover:!text-white
                `,
                { ajax_add_to_cart: ajaxAddToCart },
            ]"
            rel="nofollow"
            @click="openCart"
        >
            <slot />
        </a>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import useMiniCart from '@/composables/mini-cart';
import UiQuantity from '@/components/ui/quantity.vue';

export default defineComponent({
    components: {
        UiQuantity,
    },
    props: {
        addToCartLink: {
            type: String,
            required: true,
        },
        addToCartMessage: {
            type: String,
            default: '',
        },
        ajaxAddToCart: {
            type: Boolean,
            default: false,
        },
        max: {
            type: Number,
            required: true,
        },
        min: {
            type: Number,
            required: true,
        },
        productDescription: {
            type: String,
            required: true,
        },
        productId: {
            type: Number,
            required: true,
        },
        productSku: {
            type: String,
            required: true,
        },
        step: {
            type: Number,
            default: 1,
        },
    },
    setup(props) {
        const quantity = ref(1);
        const { toggleMiniCart, addNotification } = useMiniCart();

        const openCart = () => {
            if (props.ajaxAddToCart) {
                addNotification(props.addToCartMessage);
                toggleMiniCart();
            }
        };

        return {
            openCart,
            quantity,
        };
    },
});
</script>
