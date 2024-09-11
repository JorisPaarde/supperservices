<template>
    <div
        :class="[
            `
                border-secondary 
                text-secondary 
                flex 
                h-10 
                items-center 
                rounded-full 
                border-2
            `,
            { 'w-full': fullWidth },
        ]"
    >
        <button
            class="pl-3.5 text-xs disabled:opacity-25"
            type="button"
            :disabled="inputValue <= min"
            @click="subtract"
        >
            <icon icon="minus" />
        </button>
        <input
            :id="id"
            v-model.number="inputValue"
            type="text"
            :name="name"
            :min="min"
            :max="max"
            v-bind="$attrs"
            :class="[
                `
                    qty 
                    qty-input__field 
                    appearance-none 
                    bg-transparent 
                    text-center 
                    text-xl 
                    focus:outline-none
                `,
                fullWidth ? 'w-full' : 'w-16',
            ]"
        />
        <button
            class="pr-3.5 text-xs disabled:opacity-25"
            type="button"
            :disabled="max > 0 && inputValue >= max"
            @click="add"
        >
            <icon icon="plus" />
        </button>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref, watch, onMounted } from 'vue';
import Icon from '@/components/icon.vue';

export default defineComponent({
    name: 'UiQuantityInput',
    components: {
        Icon,
    },
    props: {
        fullWidth: {
            type: Boolean,
            default: false,
        },
        id: {
            type: [String, Number],
            required: true,
        },
        max: {
            type: Number,
            required: false,
            default: null,
        },
        min: {
            type: Number,
            required: false,
            default: 1,
        },
        modelValue: {
            type: Number,
            default: null,
        },
        name: {
            type: String,
            required: true,
        },
        step: {
            type: Number,
            required: false,
            default: 1,
        },
        value: {
            type: Number,
            default: null,
        },
    },
    emits: ['update:modelValue'],
    setup(props, { emit }) {
        const inputValue = ref(1);

        const add = () => {
            inputValue.value += props.step;
        };

        const subtract = () => {
            inputValue.value -= props.step;
        };

        onMounted(() => {
            if (props.modelValue) {
                inputValue.value = props.modelValue;
            } else if (props.value) {
                inputValue.value = props.value;
            } else {
                inputValue.value = props.min;
            }
        });

        watch(inputValue, (value) => {
            emit('update:modelValue', value);
        });

        return {
            add,
            subtract,
            inputValue,
        };
    },
});
</script>
