<template>
    <div
        id="notfound"
        title="Page Not Found"
        noCrawl
    >
        <h1 id="notfound_heading">
            404
        </h1>

        <h2 id="notfound_subheading">
            {{ attemptedPath }} is not correct...
        </h2>

        <router-link id="notfound_button" to="/examples">
            VIEW EXAMPLES
        </router-link>
    </div>
</template>

<script>
export default {
    name: 'a-404',

    props: {},

    data() {
        return {};
    },

    computed: {
        attemptedPath() {
            return this.$route.params.pathMatch;
        },
    },

    mounted() {},

    methods: {},

};
</script>

<style>
#notfound {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
}

#notfound_heading {
    color: #66FCF1;
    font-family: 'AROLY', sans-serif;
    font-size: 12.8rem;
    line-height: 12.8rem;
    font-weight: 400;
    letter-spacing: 0.01em;
    margin: 0;
    padding: 0;
}

#notfound_subheading {
    font-family: 'Oswald', sans-serif;
    font-size: 3.2rem;
    line-height: 3.2rem;
    font-weight: 200;
    letter-spacing: 0.2em;
    margin: 0 0 3.2rem 0;
    padding: 0;
}

#notfound_button {
    font-family: 'Oswald', sans-serif;
    font-size: 1.6rem;
    line-height: 1.6rem;
    font-weight: 200;
    letter-spacing: 0.2em;
    text-align: center;
    text-decoration: none;
    background: none;
    color: #fff;
    border: 0.1rem solid #fff;
    padding: 1.6rem;
    margin: 0 0.8rem 1.6rem 0.8rem;
    transition: all 200ms ease-in-out;
}

#notfound_button:hover {
    color: #212121;
    background-color: #66FCF1;
    border: 0.1rem solid #66FCF1;
    transition: all 200ms ease-in-out;
}

#notfound_button:active {
    background-color: #45A29E;
    border: 0.1rem solid #45A29E;
}
</style>
