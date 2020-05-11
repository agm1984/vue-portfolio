<template>
    <a-page v-title="'Home'">
        <div id="home_avatar" style="background-image: url('/adam.png')"></div>

        <h2 id="home_leadIn">THE PORTFOLIO OF</h2>

        <h1 class="home_name">adam</h1>

        <h1 class="home_name">mackintosh</h1>

    </a-page>
</template>

<script>
export default {
    name: 'home',

    props: {},

    data() {
        return {};
    },

    computed: {},

    mounted() {},

    methods: {},

};
</script>

<style>
    #home_cover {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        width: 100%;
        min-height: 100vh;
        padding-bottom: 3.2rem; }

    #home_avatar {
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
        width: 9.6rem;
        height: 9.6rem;
        border-radius: 50%;
        margin-bottom: 3.2rem;
        opacity: 0.9; }

    #home_leadIn {
        font-family: 'Oswald', sans-serif;
        font-size: 1.618rem;
        line-height: 1.618rem;
        font-weight: 200;
        letter-spacing: 0.2em;
        margin: 0;
        padding: 3.2rem; }

    .home_name {
        color: #66FCF1;
        font-family: 'AROLY', sans-serif;
        font-size: 12.8rem;
        line-height: 12.8rem;
        font-weight: 400;
        letter-spacing: 0.01em;
        margin: 3.2rem 0 3.2rem 0;
        padding: 0; }

    @media (max-width: 1024px) {
        #home_cover {
            justify-content: initial;
            padding-top: 22.4rem; }
        #home_avatar {
            width: 8.0rem;
            height: 8.0rem; }
        .home_name {
            font-size: 9.6rem;
            line-height: 9.6rem; }
    }

    @media (max-width: 900px) {
        #home_avatar {
            width: 6.4rem;
            height: 6.4rem; }
        .home_name {
            font-size: 6.4rem;
            line-height: 6.4rem; }
    }

    @media (max-width: 600px) {
        #home_cover {
            padding-top: 25.6rem; }
        #home_avatar {
            width: 6.4rem;
            height: 6.4rem; }
        #home_leadIn {
            text-align: center; }
        .home_name {
            font-size: 4.8rem;
            line-height: 4.8rem; }
    }
</style>