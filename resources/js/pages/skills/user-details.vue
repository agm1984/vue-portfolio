<template>
    <div id="nav_left_user-container">
        <div id="nav_left_user_leftSide">
            <div
                id="nav_left_user-avatar"
                :style="{
                    backgroundRepeat: 'no-repeat',
                    backgroundImage: `url(${avatar})`,
                    backgroundSize: 'cover',
                    backgroundPosition: 'center center',
                }"
            ></div>

            <div id="nav_left_user-level">
                {{ level }}
            </div>
        </div>

        <div id="nav_left_user_rightSide">
            <div id="nav_left_user-name">
                {{ name }}
            </div>
            <div id="nav_left_user-xpFill">
                <div
                    id="nav_left_user-xp"
                    :style="{
                        width: `${(+currentXp / +requiredXp) * 100}%`,
                        transition: 'width 500ms ease-in-out',
                    }"
                ></div>
            </div>
            <div id="nav_left_user-xpNum">
                <div id="nav_left_user-xpNumerator">
                    {{ `${currentXpWithCommas}\u00a0` }}
                </div>
                <div id="nav_left_user-xpDenominator">
                    / {{ requiredXpWithCommas }}
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: 'user-details',

    props: {},

    data() {
        return {
            name: 'adam',
            avatar: '/adam.png',
            level: this.getCurrentAge('08/14/1984', '04/05/2018'),
            currentXp: 0,
            requiredXp: 1337,
            timers: {},
        };
    },

    computed: {
        currentXpWithCommas() {
            return Number(this.currentXp).toLocaleString();
        },

        requiredXpWithCommas() {
            return Number(this.requiredXp).toLocaleString();
        },

    },

    mounted() {
        const vm = this;
        for (let i = 0; i < 20; i += 1) {
            this.timers[i] = setTimeout(() => vm.updateXP(), i * 100);
        }
    },

    methods: {
        getCurrentAge(birthDate, currentDate) {
            const birth = new Date(birthDate);
            const current = new Date(currentDate);

            let years = (current.getFullYear() - birth.getFullYear());

            if (((current.getMonth() < birth.getMonth()) || (current.getMonth() === birth.getMonth()))
                && current.getDate() < birth.getDate()) {
                years -= 1;
            }

            return years;
        },

        getRandomXP() {
            this.currentXp = Math.floor((Math.random() * 5000) + 1);
        },

        updateXP() {
            if (!this) {
                console.log('CLOSED PREMATURELY');
            }

            if (this.currentXp > this.requiredXp) {
                return;
            }

            const num = this.currentXp + 90;
            if (num >= 1337) {
                this.currentXp = 1337;
            }

            this.currentXp += Math.floor((Math.random() * 100) + 1);
        },
    },

};
</script>

<style>
#nav_left_user-container {
  position: absolute;
  top: -4.8rem;
  left: 1.2rem;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 8.0rem 0 0 2.1rem;
  z-index: 1; }

#nav_left_user_leftSide {
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center; }

#nav_left_user-avatar {
  width: 6.4rem;
  height: 6.4rem;
  border-radius: 50%;
  box-shadow: -2px 4px 10px 0px rgba(0, 0, 0, 0.5);
  margin-top: -3.2rem; }

#nav_left_user-level {
  position: absolute;
  display: flex;
  justify-content: center;
  align-items: center;
  right: -0.8rem;
  bottom: -0.4rem;
  height: 3.2rem;
  width: 3.2rem;
  font-family: 'Oswald', sans-serif;
  font-size: 1.4rem;
  line-height: 1.4rem;
  font-weight: 400;
  letter-spacing: 0.2em;
  color: #fff;
  background-color: #000;
  border: 0.2rem solid #339999;
  border-radius: 50%; }

#nav_left_user_rightSide {
  display: flex;
  flex-direction: column;
  height: 9.6rem;
  padding-left: 1.6rem; }

#nav_left_user-name {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 12.8rem;
  height: 100%;
  font-family: 'AROLY', sans-serif;
  font-size: 1.6rem;
  line-height: 1.4rem;
  font-weight: 200;
  letter-spacing: 0.2em;
  color: #fff;
  background-color: #383838;
  border: 0.1rem solid green;
  padding: 0.8rem; }

#nav_left_user-xpFill {
  position: relative;
  width: 100%;
  height: 100%;
  background-color: #000; }

#nav_left_user-xp {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  background-color: #339999;
  border-top: 0.4rem solid #000;
  box-shadow: -2px 4px 10px 0px rgba(0, 0, 0, 0.5); }

#nav_left_user-xpNum {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
  font-size: 1.4rem;
  line-height: 1.4rem;
  white-space: nowrap;
  padding-top: 0.4rem; }

#nav_left_user-xpNumerator {
  color: white;
  font-family: 'Oswald', sans-serif;
  font-size: 1.6rem;
  line-height: 1.6rem;
  font-weight: 200;
  letter-spacing: 0.2em; }

#nav_left_user-xpDenominator {
  color: #CCCCCC;
  font-family: 'Oswald', sans-serif;
  font-size: 1.6rem;
  line-height: 1.6rem;
  font-weight: 200;
  letter-spacing: 0.2em;
  font-weight: 700; }
</style>
