import { gsap } from 'gsap';
import SplitType from 'split-type';

const titleReveal = (): void => {
    const titles = document.querySelectorAll<HTMLElement>('[data-title-reveal]');

    titles.forEach((item: HTMLElement) => {
        const parent = new SplitType(item, {
            types: 'lines',
            lineClass: 'split-parent',
        });

        if (parent.lines) {
            const text = new SplitType(parent.lines, {
                types: 'lines',
                lineClass: 'split-child',
            });

            gsap.to(item, {
                opacity: 1,
            });

            gsap.from(text.lines, {
                duration: 1.5,
                yPercent: 200,
                skewY: 7,
                ease: 'power4',
                stagger: 0.1,
                scrollTrigger: {
                    trigger: item,
                    start: 'top 90%',
                },
            });
        }
    });
};

const floatingBlock = (): void => {
    const blocks = document.querySelectorAll<HTMLElement>('[data-floating-block]');

    blocks.forEach((item: HTMLElement) => {
        gsap.to(item, {
            scale: 1,
            x: 0,
            y: 0,
            scrollTrigger: {
                trigger: item,
                start: 'top bottom',
                end: 'bottom 10%',
                scrub: true,
            },
        });
    });
};

const listFadeIn = (): void => {
    const lists = document.querySelectorAll<HTMLElement>('[data-list-fade-in]');

    lists.forEach((list: HTMLElement) => {
        const ListItems = list.querySelectorAll('li');

        gsap.from(ListItems, {
            delay: 0.5,
            scale: 0.8,
            y: 20,
            opacity: 0,
            stagger: 0.25,
            scrollTrigger: {
                trigger: list,
                start: 'top bottom',
            },
        });
    });
};

const useAnimations = (): void => {
    titleReveal();
    floatingBlock();
    listFadeIn();
};

export default useAnimations;
