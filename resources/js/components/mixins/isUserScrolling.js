import debounce from 'lodash.debounce';

const isUserScrolling = {
    data() {
        return {
            handleDebouncedScroll: debounce(this.handleScroll, 100),
            isUserScrolling: false,
        };
    },

    created() {
        return window.addEventListener('scroll', this.handleDebouncedScroll);
    },

    beforeDestroy() {
        return window.removeEventListener('scroll', this.handleDebouncedScroll);
    },

    methods: {
        handleScroll(e) { // eslint-disable-line no-unused-vars
            this.isUserScrolling = (window.scrollY > 0);
            console.log('calling handleScroll');
        },
    },

};

export default isUserScrolling;
