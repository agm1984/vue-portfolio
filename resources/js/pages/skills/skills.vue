<script setup>
import { onMounted } from 'vue';
import { useHead } from '@unhead/vue';
import StatCluster from './stat-cluster.vue';
import StatBar from './stat-bar.vue';
// import UserDetails from './user-details.vue';
// import Scene from './scene.vue';

useHead({
    title: 'Skills',
});

defineOptions({ name: 'skills' });
</script>

<template>
  <div class="p-8">
    <!-- <user-details></user-details> -->

    <!-- <scene></scene> -->

    <div id="skills-leftScrollZone"></div>
    <div id="skills-rightScrollZone"></div>

    <stat-cluster
      id="cluster_javascript"
      category="skill ratios"
    >
      <stat-bar label="JAVASCRIPT" :points="90"></stat-bar>
      <stat-bar label="REACT" :points="90"></stat-bar>
      <stat-bar label="NODE.JS" :points="80"></stat-bar>
      <stat-bar label="GIT" :points="60"></stat-bar>
      <stat-bar label="LINUX" :points="70"></stat-bar>
      <stat-bar label="DOCKER" :points="35"></stat-bar>
      <stat-bar label="GRAPHQL" :points="85"></stat-bar>
      <stat-bar label="NEO4J" :points="85"></stat-bar>
      <stat-bar label="MONGO DB" :points="70"></stat-bar>
      <stat-bar label="SQL" :points="60"></stat-bar>
      <stat-bar label="PHP" :points="25"></stat-bar>
      <stat-bar label="HTML" :points="75"></stat-bar>
      <stat-bar label="CSS" :points="80"></stat-bar>
      <stat-bar label="PHOTOSHOP" :points="65"></stat-bar>
      <stat-bar label="INDESIGN" :points="75"></stat-bar>
      <stat-bar label="THREE.JS" :points="30"></stat-bar>
      <stat-bar label="BLENDER" :points="25"></stat-bar>
    </stat-cluster>

    <div class="mt-4">
      <a
        class="font-semibold hover:underline"
        href="/adamMackintoshResumeApr2018.docx"
        download
      >
        Download Resume
      </a>
    </div>
  </div>
</template>

<style>
#skills {
  position: relative;
  display: flex;
  justify-content: flex-end;
  padding-top: 6.4rem;
  width: 100%;
  min-height: 100vh;
  z-index: 0;
}

#cluster_javascript {
  display: flex;
  transition: all 250ms ease-in-out;
}

.resumeButton {
  position: absolute;
  left: 3.2rem;
  bottom: 0;
}

#skills-leftScrollZone {
  display: none;
}

#skills-rightScrollZone {
  display: none;
}

@media (max-width: 1400px) {
  #skills {
    flex-direction: column;
    align-items: center;
    padding-top: 11.2rem;
  }
  #nav_left_user-container {
    position: relative;
    justify-content: center;
    margin-left: -6.4rem;
    width: 100%;
  }
  .statCluster-wrapper {
    margin: 32.0rem 0 0 0;
  }
  .resumeButton {
    position: relative;
    left: initial;
    margin-top: 6.4rem;
  }
  #skills-leftScrollZone {
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    width: 30%;
  }
  #skills-rightScrollZone {
    display: block;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    width: 30%;
  }
}

@media (max-width: 600px) {
  #skills {
    flex-direction: column;
    align-items: center;
    padding-top: 16.0rem;
  }
  .statCluster-wrapper {
    margin: 16.0rem 0 0 0;
  }
  .statCluster {
    width: 32.0rem;
  }
  .statBar_points-container {
    width: 20.0rem;
    height: 3.2rem;
  }
  .statBar_label {
    margin-top: 1.6rem;
  }
  #skills_scene {
    margin-top: 16.0rem;
  }
}
</style>