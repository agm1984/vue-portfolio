<template>
    <div class="app-img">
        <slot></slot>

        <div v-if="dataUrl" :style="{ background }" class="app-img__placeholder">
            <img :src="placeholder || dataUrl" alt v-bind="$attrs">
        </div>

        <img :src="dataUrl" :alt="$attrs.alt || ''" v-bind="$attrs" class="app-img__img">

    </div>
</template>

<script>
// derived from: https://austingil.com/create-lazy-loading-image-component-faster-vue-js-apps/

export default {
    inheritAttrs: false,

    props: {
        src: {
            type: String,
            required: true,
        },
        placeholder: String,
        background: String,
    },

    computed: {
        dataUrl() {
            const { width, height } = this.$attrs;
            if (!width || !height) return '';

            // create a tiny png with matching aspect ratio as img
            const w = 100;
            const canvas = document.createElement('canvas');
            canvas.width = w;
            canvas.height = (height / width) * w;

            return canvas.toDataURL();
        },
    },

    mounted() {
        const { src, srcset, $el } = this;
        let timeOut;

        const observer = new IntersectionObserver(([entry]) => {
            const img = $el.querySelector('.app-img__img');
            const placeholder = $el.querySelector('.app-img__placeholder');

            img.onload = () => {
                delete img.onload;
                $el.classList.add('app-img--loaded');
                if (placeholder) {
                    timeOut = setTimeout(() => {
                        placeholder.remove();
                    }, 300);
                }
            };
            if (entry.isIntersecting) {
                // element is in viewport
                if (!!srcset) { // eslint-disable-line no-extra-boolean-cast
                    img.srcset = srcset;
                }
                img.src = src;
                observer.disconnect();
            }
        });
        observer.observe($el);

        this.$once('hook:beforeDestroy', () => {
            observer.disconnect();
            if (timeOut) {
                clearTimeout(timeOut);
            }
        });
    },
};
</script>

<style>
    .app-img {
        display: inline-block;
        position: relative;
    }

    .app-img__placeholder {
        position: absolute;
        overflow: hidden;
    }

    .app-img__placeholder img {
        transform: scale(1.05);
        filter: blur(10px);
    }

    .app-img__img {
        opacity: 0;
        transition: opacity 300ms ease;
    }

    .app-img--loaded .app-img__img {
        opacity: 1;
    }
</style>
