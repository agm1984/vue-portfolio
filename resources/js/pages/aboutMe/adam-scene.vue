<template>
    <div class="relative w-256 h-256 xl:w-512 xl:h-512">
        <div id="skills_scene" class="absolute inset-0 overflow-hidden"></div>
    </div>
</template>

<script>
import * as THREE from 'three';

const OrbitControls = require('three-orbit-controls')(THREE);

const LOADING = 'is-loading';
const LOADED = 'is-loaded';

export default {
    name: 'adam-scene',

    props: {},

    data() {
        return {
            state: LOADING,
            mount: undefined,
            clock: undefined,
            width: undefined,
            height: undefined,
            camera: undefined,
            scene: undefined,
            ambient: undefined,
            adam: undefined,
            adamAction: {},
            adamLoader: undefined,
            adamCharacter: undefined,
            renderer: undefined,
            from: undefined,
            to: undefined,
            activeActionName: 'idle',
            animations: ['idle', 'walk', 'run', 'hello'],
            currentAnimation: 0,
        };
    },

    computed: {
        isLoading() {
            return (this.state === LOADING);
        },

        isLoaded() {
            return (this.state === LOADED);
        },

    },

    mounted() {
        this.$root.$on('animate-it', () => this.handleDoubleClick());
        this.initialize();
        return this.animate();
    },

    methods: {
        renderScene() {
            if (!this.adam) return null;

            this.delta = this.clock.getDelta();

            this.adam.update(this.delta);

            // rotation test
            // this.adamCharacter.rotation.x += 0.01;
            // this.adamCharacter.rotation.y += 0.01;
            // this.adamCharacter.rotation.z += 0.01;

            // position test
            // this.adamCharacter.position.x += 0.01;
            // this.adamCharacter.position.y += 0.01;
            // this.adamCharacter.position.z += 0.01;

            // make the character walk around randomly, and add a wave button

            return this.renderer.render(this.scene, this.camera);
        },

        animate() {
            this.frameId = window.requestAnimationFrame(this.animate);

            this.controls.update();

            return this.renderScene();
        },

        initialize() {
            // setup
            this.mount = document.querySelector('#skills_scene');
            this.clock = new THREE.Clock();
            // this.width = this.mount.clientWidth;
            // this.height = this.mount.clientHeight;
            this.width = document.querySelector('#skills_scene').offsetWidth;
            this.height = document.querySelector('#skills_scene').offsetHeight;

            // camera
            this.camera = new THREE.PerspectiveCamera(85, this.width / this.height, 1, 4000);
            this.camera.position.x = 5;
            this.camera.position.y = 5;
            this.camera.position.z = 5;

            this.camera.fov *= 4.8;
            this.camera.updateProjectionMatrix();

            // scene
            this.scene = new THREE.Scene();
            this.ambient = new THREE.AmbientLight(0xffffff, 1.0);
            this.scene.add(this.ambient);

            // adam model
            this.adamLoader = new THREE.JSONLoader();
            this.adamLoader.load('./adam.json', (geometry, materials) => {
                materials.forEach((material) => {
                    material.skinning = true; // eslint-disable-line no-param-reassign
                });
                this.adamCharacter = new THREE.SkinnedMesh(geometry, materials);
                this.adamCharacter.scale.set(2, 2, 2);
                this.adam = new THREE.AnimationMixer(this.adamCharacter);

                this.adamAction.hello = this.adam.clipAction(geometry.animations[0]);
                this.adamAction.idle = this.adam.clipAction(geometry.animations[1]);
                this.adamAction.run = this.adam.clipAction(geometry.animations[3]);
                this.adamAction.walk = this.adam.clipAction(geometry.animations[4]);

                this.adamAction.hello.setEffectiveWeight(1);
                this.adamAction.idle.setEffectiveWeight(1);
                this.adamAction.run.setEffectiveWeight(1);
                this.adamAction.walk.setEffectiveWeight(1);

                this.adamAction.hello.setLoop(THREE.LoopOnce, 0);
                this.adamAction.hello.clampWhenFinished = true;

                this.adamAction.hello.enabled = true;
                this.adamAction.idle.enabled = true;
                this.adamAction.run.enabled = true;
                this.adamAction.walk.enabled = true;

                this.scene.add(this.adamCharacter);
                window.addEventListener('resize', this.handleResize, false);

                this.animate();
                this.state = LOADED;
                this.adamAction.idle.play();
            });

            // render
            this.renderer = new THREE.WebGLRenderer({ alpha: true });
            this.renderer.setPixelRatio(window.devicePixelRatio);
            this.renderer.setSize(this.width, this.height);
            this.mount.appendChild(this.renderer.domElement);

            this.controls = new OrbitControls(this.camera, this.renderer.domElement);
            this.controls.target.set(0, 0, 0);
            this.controls.addEventListener('change', this.renderScene);
            this.controls.enableZoom = false;

            window.scene = this.scene;
            window.THREE = THREE;
            this.start();
        },

        start() {
            if (!this.frameId) {
                this.frameId = requestAnimationFrame(this.animate);
            }
        },

        stop() {
            return cancelAnimationFrame(this.frameId);
        },

        handleResize() {
            console.log('alsdjaklsd');
            this.camera.aspect = this.width / this.height;
            this.camera.updateProjectionMatrix();
            this.renderer.setSize(this.width, this.height);
            this.stop();
            return this.start();
        },

        handleDoubleClick() {
            this.currentAnimation += 1;
            if (this.currentAnimation === this.animations.length) {
                this.currentAnimation = 1;
            }
            return this.fadeAction(this.animations[this.currentAnimation]);
        },

        fadeAction(name) {
            this.from = this.adamAction[this.activeActionName].play();
            this.to = this.adamAction[name].play();

            this.from.enabled = true;
            this.to.enabled = true;

            if (this.to.loop === THREE.LoopOnce) {
                this.to.reset();
            }

            this.from.crossFadeTo(this.to, 0.3);
            this.activeActionName = name;
        },

    },
};
</script>

<style>
    /* #skills_scene {
        overflow: hidden;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    } */
</style>
