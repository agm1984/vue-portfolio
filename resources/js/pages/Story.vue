<template>
    <div class="relative flex flex-col items-center justify-end flex-1">
        <button
            v-if="true"
            id="downScroller"
            @click="handleScrollDown"
            tabindex="0"
            title="Click or scroll down to see more"
        >
            ⇩
        </button>

        <div
          id="story"
          class=""
          title="Story"
          description="An approximate history and story about Adam Mackintosh"
        >
            <h1 class="timeline-title">A MACKINTOSH TREE</h1>
            <div id="timeline">
                <div class="timeline-item">
                    <div class="timeline-icon">
                    API
                    </div>
                    <div class="timeline-content">
                    <h2>backend developer</h2>
                    <p>
                        Since 2002, I have helped build, maintain, and promote products &amp; services
                        from various perspectives.
                        I have been programming off and on since before then. Since the
                        emergence of React, I have settled as a fullstack web and mobile developer.
                        I advocate Functional Programming techniques, and I prefer to use GraphQL,
                        node.js, React, and React Native.
                    </p>
                    {this.renderContactButton()}
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-icon">
                    APP
                    </div>
                    <div class="timeline-content right">
                    <h2>frontend developer</h2>
                    <p>
                        I am comfortable working in the DOM.
                        I enjoy the science behind building performant, fluid interfaces.
                        I can implement virtually anything that can be described on paper.
                    </p>
                    {this.renderContactButton()}
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-icon">
                    QA
                    </div>
                    <div class="timeline-content">
                    <h2>quality assurance</h2>
                    <p>
                        After years of hands-on QA experience helping optimize pre-production
                        software and print materials against business objectives,
                        I appreciate Test-Driven Development (TDD). I know the
                        most about affected logic and features while I am working on them.
                        Memory fades—this is also why readable code and verbose documentation
                        are valuable. I appreciate a build-measure-learn
                        feedback loop because it describes the scientific method.
                    </p>
                    {this.renderContactButton()}
                    </div>
                </div>
          </div>

          <h1 class="timeline-title timeline-bonusPadding">A TEAM</h1>

          <div id="team-container-wrapper">
            <div id="team-container">

              <div class="team_person">
                <div
                  class="team_person-avatar"
                  style="background-image: url('/adam-left.png')"
                ></div>
                <h1 class="team_person-title">adam backend</h1>
                <p class="team_person-blurb">
                    I compose functions in node.js.
                    I like polyglot microservices, graph database paired with GraphQL, and websockets.
                    I strive to make easy to maintain, extend, and test APIs.
                </p>
              </div>

              <div class="team_person">
                <div
                  class="team_person-avatar"
                  style="background-image: url('/adam-center.png')"
                ></div>
                <h1 class="team_person-title">adam qa</h1>
                <p class="team_person-blurb">
                    A good QA effort allows implementation details to change with
                    minimal to no effect on the existing test suite.
                    I prefer continuous integration and testing in multiple environments.
                </p>
                {this.renderContactButton()}
              </div>

              <div class="team_person">
                <div
                    class="team_person-avatar"
                    style="background-image: url('/adam-right.png')"
                ></div>
                <h1 class="team_person-title">adam frontend</h1>
                <p class="team_person-blurb">
                    Designing UIs can be easy.
                    Take a constraint, and use it to implement a ruleset that
                    communicates effectively in a riveting manner.
                    Maximizing UX is a different story.
                </p>
              </div>
            </div>
          </div>

          <h1 class="timeline-title timeline-bonusPadding">A BRIEF WORD</h1>
          <div id="info-wrapper">
            <div id="info-specialWrapper">
              <div id="info-container">
                <div class="info_split">
                  <h3 class="info_split-title">to non-programmers</h3>
                  <div id="info_split-container">
                    <div class="info_split-column">
                        <h4 class="info_split-heading">work</h4>
                        <p class="info_split-content">
                            As a developer, I aim to write not only pragmatic and UX-enriched
                            code but also empathetic and thorough technical documentation.
                            I am always curious to learn new tools and techniques.
                        </p>
                    </div>
                    <div class="info_split-column">
                        <h4 class="info_split-heading">life</h4>
                        <p class="info_split-content">
                            I am introverted and creative and known for being light hearted,
                            precise, and thorough. I decompress from work by going to
                            the gym and cooking nice meals for other people.
                            I like the chemistry behind balancing salty, sweet, sour, and hot.
                        </p>
                    </div>
                    <div class="info_split-column">
                        <h4 class="info_split-heading">balance</h4>
                        <p class="info_split-content">
                            Fitness &amp; nutrition has been a way of life for me for the past ten years.
                            A healthy mind and optimized metabolic processes both start with
                            optimized nutrient-intake.
                        </p>
                    </div>
                  </div>
                </div>
                <div id="info_split-divider"></div>
                <div class="info_split">
                  <h3 class="info_split-title">to programmers</h3>
                  <div id="programmers-container">
                    <p class="story_paragraph">
                        I like JavaScript (JS) because it is a language made of atomic building blocks.
                        A Function is a place to do work, like in Mathematics.
                        This is fundamentally why I am passionate about deterministic transformations;
                        they create predictable movement from point A to B like a math formula.
                        Immutable Functional Programming allows a person to compose
                        Functions together with minimized time and complexity
                        provided the person follows some strict rules.
                    </p>
                    <p class="story_paragraph">
                        The declarative-nature of Functional Programming
                        matches up well with Objects, event streams, and state;
                        immutability is important because shared state and side
                        effects are very dangerous. Understanding the event loop and garbage
                        collection helps a lot. Aiming for referential transparency helps even more.
                    </p>
                    <p class="story_paragraph">
                        Some consider JS loose, and they are correct,
                        but dynamic typing allows one to rapidly spool out logic
                        in any desired direction.
                        JS is a language of great productivity towards both APIs and apps.
                        It is an isomorphic dominator. Reach out to me on Twitter if you want
                        to pick up the conversation.
                        I'd love to hear your thoughts or provide additional context.
                    </p>
                    <p class="story_paragraph">
                        I would need more time to explain, but JS is great at managing streams
                        of concurrent, potentially-unrelated actions and events
                        while maximizing what I would call lossless IOPs (Input/Outputs per second).
                        JS has everything I need to quickly create scalable,
                        performant applications.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <h1 class="timeline-title timeline-bonusPadding">A COUPLE PATHS</h1>
          <div id="path-wrapper">
            <div id="path-container">
                <router-link
                    to="/skills"
                    class="btn"
                    title="See Adam's skills"
                >
                    SEE SKILLS
                </router-link>

                <div class="path-divider"></div>

                <router-link
                    to="/contact"
                    class="btn"
                    title="Start a conversation with Adam"
                >
                    CONTACT
                </router-link>
            </div>

            <div id="story-footer">
                <div id="story-left">
                    <div class="nav_adamLogo" />
                    <span id="Nav_brand-adam">ADAM</span>
                    <span id="Nav_brand-mackintosh">MACKINTOSH</span>
                </div>

                <div id="story-center">
                    <span id="story-conclusion">△△△</span>
                </div>

                <div id="story-right"></div>
            </div>

            <button
                id="backToTopScroller"
                @click="handleScrollBackToTop"
                title="Back to top?"
            >
                ⇧
            </button>
          </div>
        </div>

      </div>
</template>

<script>
export default {
    name: 'story',

    props: {},

    data() {
        return {};
    },

    computed: {},

    mounted() {},

    methods: {
        handleScrollDown() {
            return window.scrollTo({
                top: window.innerHeight / 2,
                behavior: 'smooth',
            });
        },

        handleScrollBackToTop() {
            return window.scrollTo({
                top: 0,
                behavior: 'smooth',
            });
        },

    },

};
</script>

<style>
#story {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-top: 12.8rem;
  width: 100%;
  max-width: 1100px;
  height: 100%;
  margin: 0 auto; }

.timeline-title {
  position: relative;
  font-family: 'Oswald', sans-serif;
  font-size: 1.6rem;
  line-height: 1.6rem;
  font-weight: 200;
  letter-spacing: 0.2em;
  margin: 0;
  margin-bottom: 3.2rem; }

.timeline-title:after {
  border-bottom: 1px solid #618396;
  display: block;
  height: 1px;
  margin: 0.625em auto 1.375em;
  max-width: 80px; }

.timeline-bonusPadding {
  padding: 3.2rem 0 0 0; }

#story-wrapper {
  position: relative;
  width: 100%;
  height: 100vh; }

#timeline .timeline-item:after,
#timeline .timeline-item:before {
  content: '';
  display: block;
  width: 100%;
  clear: both; }

#timeline {
  width: 100%;
  position: relative;
  -webkit-transition: all 0.4s ease;
  -moz-transition: all 0.4s ease;
  -ms-transition: all 0.4s ease;
  transition: all 0.4s ease; }

#timeline:before {
  content: '';
  position: absolute;
  width: 0.2rem;
  height: 100%;
  background: #8B4513;
  left: 50%;
  top: 0; }

#timeline:after {
  content: '';
  clear: both;
  display: table;
  width: 100%; }

#timeline .timeline-item {
  position: relative; }

#timeline .timeline-item .timeline-icon {
  position: absolute;
  top: 0;
  left: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 6.4rem;
  height: 6.4rem;
  overflow: hidden;
  font-family: 'Oswald', sans-serif;
  font-size: 1.6rem;
  line-height: 1.6rem;
  font-weight: 400;
  letter-spacing: 0.2em;
  color: #fff;
  background: #014420;
  margin-left: -3.0rem;
  border-radius: 50%; }

#timeline .timeline-item .timeline-content {
  width: 45%;
  font-family: 'Roboto', sans-serif;
  font-weight: 300;
  font-size: 1.6rem;
  line-height: 2.4rem;
  letter-spacing: 0.1em;
  text-align: center;
  background: none;
  padding: 3.2rem;
  box-shadow: 0 3px 0 rgba(0, 0, 0, 0.1);
  transition: all 250ms ease; }

#timeline .timeline-item .timeline-content h2 {
  font-family: 'AROLY', sans-serif;
  font-size: 2.8rem;
  line-height: 2.8rem;
  letter-spacing: 0.1em;
  text-align: center;
  padding: 1.6rem;
  margin: -3.2rem -2.0rem 0 -1.6rem;
  color: #CCCCCC;
  background-color: rgba(51, 51, 51, 0.8);
  border: 0.1rem solid green; }

#timeline .timeline-item .timeline-content:before {
  content: '';
  position: absolute;
  left: calc(45% - 1.2rem);
  top: 3.0rem;
  width: 4.0rem;
  height: 0;
  border-bottom: 0.4rem solid #8B4513;
  z-index: -1; }

#timeline .timeline-item .timeline-content.right {
  float: right; }

#timeline .timeline-item .timeline-content.right:before {
  content: '';
  right: calc(45% - 1.6rem);
  left: inherit;
  top: 3.0rem;
  width: 3.6rem;
  height: 0;
  border-bottom: 0.4rem solid #8B4513; }

.btn {
  display: inline-block;
  font-family: 'Oswald', sans-serif;
  font-size: 1.6rem;
  line-height: 1.6rem;
  font-weight: 200;
  letter-spacing: 0.2em;
  text-decoration: none;
  text-align: center;
  color: #fff;
  background: none;
  margin-bottom: 3.2rem;
  padding: 1.6rem;
  border: 0.1rem solid #fff;
  transition: all 250ms ease-in-out; }

.btn:hover {
  color: #66FCF1;
  border: 0.1rem solid #66FCF1;
  transition: all 250ms ease-in-out; }

.btn:active {
  color: #FF5043;
  border: 0.1rem solid #FF5043;
  transition: all 125ms ease-in-out; }

@media (max-width: 768px) {
  #timeline {
    margin: 3.2rem;
    padding: 0px;
    width: 90%; }
  #timeline:before {
    left: 0; }
  #timeline .timeline-item .timeline-content {
    width: 90%;
    float: right; }
  #timeline .timeline-item .timeline-content:before,
  #timeline .timeline-item .timeline-content.right:before {
    left: -1.6rem;
    margin-left: 4.0rem;
    width: 6.0rem;
    border-left: 0; }
  #timeline .timeline-item .timeline-icon {
    left: 0; } }

@media (max-width: 668px) {
  #timeline .timeline-item .timeline-content:before,
  #timeline .timeline-item .timeline-content.right:before {
    margin-left: 3.2rem; } }

@media (max-width: 568px) {
  #timeline .timeline-item .timeline-content:before,
  #timeline .timeline-item .timeline-content.right:before {
    margin-left: 2.2rem; } }

@media (max-width: 468px) {
  #timeline .timeline-item .timeline-content:before,
  #timeline .timeline-item .timeline-content.right:before {
    margin-left: 1.6rem; } }

@media (max-width: 368px) {
  #timeline .timeline-item .timeline-content:before,
  #timeline .timeline-item .timeline-content.right:before {
    margin-left: 0.4rem; } }

.story_paragraph {
  font-family: 'Roboto', sans-serif;
  letter-spacing: 0.1rem;
  font-weight: 300;
  font-size: 1.6rem;
  line-height: 2.4rem; }

#team-intro {
  max-width: 80.0rem;
  height: 80rem;
  font-family: 'Roboto', sans-serif;
  letter-spacing: 0.1rem;
  font-weight: 300;
  font-size: 1.6rem;
  line-height: 2.4rem;
  text-align: center; }

#team-container-wrapper {
  width: 140.0rem; }

#team-container {
  display: flex;
  flex-direction: row;
  width: 100%;
  height: 100%;
  padding-top: 3.2rem; }

.team_person {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 33.333%; }

.team_person-avatar {
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center center;
  width: 9.6rem;
  height: 9.6rem;
  border: 0.1rem solid #000;
  border-radius: 50%;
  box-shadow: -8px 14px 40px 0px black;
  margin-bottom: 3.2rem;
  opacity: 0.9; }

.team_person-title {
  font-family: 'AROLY', sans-serif;
  font-size: 2.0rem;
  line-height: 2.0rem;
  font-weight: 200;
  letter-spacing: 0.1em;
  color: #FF5043;
  margin: 0; }

.team_person-blurb {
  text-align: center;
  font-family: 'Roboto', sans-serif;
  letter-spacing: 0.1rem;
  font-weight: 300;
  font-size: 1.6rem;
  line-height: 2.4rem;
  margin-top: 0.8rem;
  margin-bottom: 6.4rem;
  padding: 0 3.2rem 0 3.2rem; }

#info-wrapper {
  display: block;
  padding: 0 3.2rem 3.2rem 3.2rem;
  overflow: none; }

#info-specialWrapper {
  width: 160.0rem; }

#info-container {
  display: flex; }

#info_split-container {
  display: flex;
  background-color: #004040;
  box-shadow: -8px 14px 40px 0px black;
  padding-bottom: 1.6rem; }

.info_split {
  width: 50%;
  padding: 0; }

#info_split-divider {
  width: 6.4rem;
  height: 1.6rem; }

.info_split-title {
  text-align: center;
  font-family: 'AROLY', sans-serif;
  font-size: 2.0rem;
  line-height: 2.0rem;
  font-weight: 200;
  letter-spacing: 0.1em;
  color: #fff;
  background-color: rgba(51, 51, 51, 0.8);
  border: 0.1rem solid green;
  margin: 3.2rem 0 0 0;
  padding: 1.6rem; }

.info_split-column {
  display: flex;
  flex-direction: column;
  text-align: center;
  padding: 1.6rem; }

.info_split-heading {
  font-family: 'AROLY', sans-serif;
  font-size: 2.0rem;
  line-height: 2.8rem;
  font-weight: 200;
  letter-spacing: 0.1em;
  color: #45A29E;
  margin: 0;
  padding: 0; }

.info_split-content {
  font-family: 'Roboto', sans-serif;
  letter-spacing: 0.1rem;
  font-weight: 300;
  font-size: 1.6rem;
  line-height: 2.4rem;
  margin: 0; }

#programmers-container {
  padding: 0 0 0 0.4rem; }

#path-wrapper {
  position: relative;
  display: block;
  width: calc(100vw - 3.2rem); }

/*
  1.9rem is needed to maintain horizontal alignment
  with adjacent elements.
*/
#path-container {
  display: flex;
  justify-content: center;
  padding: 3.2rem 1.9rem 3.2rem 0; }

.path-divider {
  width: 6.4rem;
  height: 6.4rem; }

#story-footer {
  position: relative;
  display: flex;
  width: 100%;
  white-space: nowrap;
  padding: 3.2rem 0 3.2rem 0;
  user-select: none;
  z-index: 9999; }

#story-left {
  position: relative;
  display: flex;
  align-items: center;
  width: 19.2rem;
  padding-left: 3.2rem;
  z-index: 9999; }

#story-center {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center; }

#story-conclusion {
  font-family: 'Oswald', sans-serif;
  font-weight: 400;
  font-size: 1.6rem;
  line-height: 2.2rem;
  letter-spacing: 0.2em;
  color: #8B4513; }

#story-right {
  width: 19.2rem;
  height: 100%; }

@media (max-width: 1664px) {
  #info-specialWrapper {
    width: 128.0rem; } }

@media (max-width: 1400px) {
  #team-container-wrapper {
    width: 100%; }
  #team-container {
    flex-direction: column;
    align-items: center; }
  .team_person {
    width: 100%;
    max-width: 450px; }
  .btn {
    margin-bottom: 6.4rem; }
  #info-specialWrapper {
    width: 96.0rem; }
  #info_split-container {
    flex-direction: column; } }

@media (max-width: 1024px) {
  #story {
    padding-top: 22.4rem;
    align-items: initial; }
  .timeline-title {
    text-align: center; }
  #info-specialWrapper {
    width: 100%; }
  #info-container {
    flex-direction: column;
    align-items: center; }
  .info_split {
    width: 100%;
    padding: 0 1.6rem 0 1.6rem; }
  #info_split-container {
    margin-bottom: 1.6rem; }
  #path-container {
    padding: 3.2rem 0 3.2rem 0; }
  .story_paragraph {
    text-align: center; } }

@media (max-width: 600px) {
  #story {
    padding-top: 25.6rem; }
  .team_person {
    padding: 0 3.2rem 0 3.2rem; }
  #info-wrapper {
    padding: 0; }
  #story-conclusion {
    display: none; } }
</style>
