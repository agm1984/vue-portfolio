const csrfToken = {
    data() {
        return {
            csrf: document.head.querySelector('meta[name="csrf-token"]').content,
        };
    },
};

export default csrfToken;
