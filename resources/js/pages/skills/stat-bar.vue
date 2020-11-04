<template>
    <div class="statBar">
        <div class="statBar_label">
            {{ label }}
        </div>

        <div class="statBar_points-container">
            <div
                class="statBar_points"
                :style="{
                    width: `${points}%`,
                }"
            ></div>
            <div
                v-for="d in dividers"
                :key="`divider-${d}`"
                class="statBar_points-divider"
                :style="{
                    left: `calc(${d}% - 0.8rem)`
                }"
            ></div>
        </div>

    </div>
</template>

<script>
export default {
    name: 'stat-bar',

    props: {
        label: {
            type: String,
            required: true,
        },

        points: {
            type: Number,
            required: true,
        },
    },

    data() {
        return {
            dividers: [10, 20, 30, 40, 50, 60, 70, 80, 90, 100],
        };
    },

    computed: {},

    mounted() {},

    methods: {},

};
</script>

<style>
.statBar {
  display: flex;
  flex-direction: row;
  align-items: center;
  padding: 0.4rem; }

.statBar_label {
  font-family: 'Oswald', sans-serif;
  font-size: 1.6rem;
  line-height: 1.6rem;
  font-weight: 200;
  letter-spacing: 0.2em;
  flex: 1; }

.statBar_points-container {
  position: relative;
  display: flex;
  width: 32.36rem;
  background-color: #000;
  border: 0.4rem solid #000; }

.statBar_points {
  height: 2.4rem;
  background-color: #339999; }

.statBar_points-divider {
  position: absolute;
  width: 0.8rem;
  height: 2.4rem;
  background-color: #000; }
</style>
