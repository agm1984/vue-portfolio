<script setup>
import { useHead } from '@unhead/vue';
import Accordion from 'primevue/accordion';
import AccordionPanel from 'primevue/accordionpanel';
import AccordionHeader from 'primevue/accordionheader';
import AccordionContent from 'primevue/accordioncontent';

useHead({
    title: 'About Me',
});
</script>

<template>
    <div class="w-full max-w-5xl mx-auto flex flex-col p-8">
        <h1>About Me</h1>

        <a-card class="p-8 mt-4">
            <div class="flex flex-col">
                <div class="w-full">
                    <img src="adam-center.png" class="md:float-right aspect-square rounded-md md:ml-8 mb-4" alt="Image of Adam Mackintosh">
                    <p>
                        I'll keep this short. I've been programming for about four years (calc: current year minus 2017),
                        but I've been working with iOS, Android, and web apps since 2013. I would say I discovered my passion
                        for coding around that time. I'm an autodidact-type person. All I need is a topic and an impetus, and
                        I can start researching it. Google really is a magical thing.
                    </p>

                    <p class="mt-4">
                        My list of hobbies is quite short because my main hobby is programming. Beyond that,
                        I enjoy working out. I've been working out for the past 10 years. I didn't go to the gym much in 2019,
                        but I've been going again four times a week, and it feels great.
                    </p>

                    <p class="mt-4">
                        I have a 700 horsepower 1993 Toyota Supra, so when the engine isn't broken and it's clean,
                        you can find me out driving with my friends, listening to music, and finding new places to visit.
                    </p>

                    <p class="mt-4">
                        Check out my <router-link class="font-semibold hover:underline" :to="{ name: 'contact' }">Contact</router-link> page.
                    </p>
                </div>
            </div>
        </a-card>

        <div class="flex flex-col items-end mt-8">
            <h3 class="text-sm font-bold mb-4">Find me on</h3>
            <div class="flex gap-4">
                <a-social-link network="twitter" class="hover:translate-x-1 transition-transform" />
                <a-social-link network="github" class="hover:translate-x-1 transition-transform" />
                <a-social-link network="stackoverflow" class="hover:translate-x-1 transition-transform" />
                <a-social-link network="medium" class="hover:translate-x-1 transition-transform" />
            </div>
        </div>

        <div class="w-full mt-8">
            <h2>A Brief Word</h2>

            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-8 mt-4">
                <a-card class="self-start p-8">
                    <h2>To programmers</h2>

                    <p class="mt-4">
                        What can I say? I like to use Mealy finite state machines, predicates and booleans,
                        and immutable functional-reactive programming (FRP) styles (ie: map, reduce, filter, etc).
                    </p>

                    <p class="mt-4">
                        I often think in two modes: push and pull. Pushing is like doing & triggering.
                        Pulling is like listening & acting. In my opinion, this is much of where the
                        "functional-reactive" comes from in FRP. Functional can be pushing, and reactive can be pulling.
                    </p>
                </a-card>

                <a-card class="self-start p-8">
                    <h2>To non-programmers</h2>

                    <div class="flex flex-col w-full mt-4">
                        <Accordion :value="[]" multiple>
                            <AccordionPanel value="0">
                                <AccordionHeader>Work</AccordionHeader>
                                <AccordionContent>
                                    <p>
                                        As a developer, I aim to write not only pragmatic and UX-enriched code but also empathetic and
                                        thorough technical documentation. I am always curious to learn new tools and techniques.
                                    </p>
                                </AccordionContent>
                            </AccordionPanel>

                            <AccordionPanel value="1">
                                <AccordionHeader>Life</AccordionHeader>
                                <AccordionContent>
                                    <p>
                                        I am introverted and creative and known for being light hearted, precise, and thorough. I decompress
                                        from work by going to the gym and cooking nice meals for other people. I like the chemistry behind
                                        balancing salty, sweet, sour, and hot.
                                    </p>
                                </AccordionContent>
                            </AccordionPanel>

                            <AccordionPanel value="2">
                                <AccordionHeader>Balance</AccordionHeader>
                                <AccordionContent>
                                    <p>
                                        Fitness & nutrition has been a way of life for me since 2009. A healthy mind and
                                        optimized metabolic processes both start with optimized nutrient-intake.
                                    </p>
                                </AccordionContent>
                            </AccordionPanel>
                        </Accordion>
                    </div>
                </a-card>
            </div>
        </div>

        <interactive-timeline></interactive-timeline>
    </div>
</template>
