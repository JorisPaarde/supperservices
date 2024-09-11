import { ref, Ref, watch } from 'vue';

interface IReturnProps {
    isMenuOpen: Ref<boolean>;
    toggleMenu: () => void;
}

const isMenuOpen = ref(false);

const useNavigation = (): IReturnProps => {
    const toggleMenu = () => {
        isMenuOpen.value = !isMenuOpen.value;
    };

    watch(isMenuOpen, () => {
        if (isMenuOpen.value) {
            document.body.classList.add('menu-is-open');
            return;
        }

        document.body.classList.remove('menu-is-open');
    });

    return {
        isMenuOpen,
        toggleMenu,
    };
};

export default useNavigation;
