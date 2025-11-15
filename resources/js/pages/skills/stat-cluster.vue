<template>
    <div class="">
        <div class="w-full">
            <h2 class="">{{ category }}</h2>

            <div class="grid grid-cols-[200px_1fr] items-center">

              <slot></slot>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: 'stat-cluster',

    props: {
        category: {
            type: String,
            required: true,
        },
    },

    data() {
        return {};
    },

    computed: {},

    mounted() {},

    methods: {},

};
</script>

<style>
.statCluster-wrapper {
  position: relative;
  margin: 6.4rem 3.2rem 6.4rem 6.4rem; }

.statCluster {
  position: relative;
  display: flex;
  flex-direction: column;
  right: 0;
  top: 0;
  width: 48.0rem;
  height: 100%; }

.statCluster-line {
  position: absolute;
  top: 2.9rem;
  left: -3.2rem;
  width: 6.4rem;
  height: 0.4rem;
  border-bottom: 0.4rem solid #fff;
  z-index: 9999; }

.statHeading {
  height: 6.4rem;
  font-family: 'AROLY', sans-serif;
  font-size: 2.8rem;
  line-height: 2.8rem;
  letter-spacing: 0.1em;
  text-align: center;
  color: #fff;
  background-color: #383838;
  border: 0.1rem solid green;
  margin: 0;
  padding: 2.0rem; }
</style>
