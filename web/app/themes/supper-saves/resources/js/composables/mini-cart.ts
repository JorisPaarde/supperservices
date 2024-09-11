import { ref, Ref, watch } from 'vue';

interface IReturnProps {
    addNotification: (message: string) => void;
    isMiniCartOpen: Ref<boolean>;
    notification: Ref<string>;
    toggleMiniCart: () => void;
}

const isMiniCartOpen = ref(false);
const notification = ref('');

const useMiniCart = (): IReturnProps => {
    const toggleMiniCart = () => {
        isMiniCartOpen.value = !isMiniCartOpen.value;
    };

    const addNotification = (message: string) => {
        notification.value = message;

        setTimeout(() => {
            notification.value = '';
        }, 4000);
    };

    watch(isMiniCartOpen, () => {
        if (isMiniCartOpen.value) {
            document.body.classList.add('menu-is-open');
            return;
        }

        document.body.classList.remove('menu-is-open');
    });

    return {
        addNotification,
        isMiniCartOpen,
        notification,
        toggleMiniCart,
    };
};

export default useMiniCart;
