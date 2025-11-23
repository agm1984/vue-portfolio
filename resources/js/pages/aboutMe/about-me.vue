<script setup>
import { computed } from 'vue';
import { useHead } from '@unhead/vue';
import Accordion from 'primevue/accordion';
import AccordionPanel from 'primevue/accordionpanel';
import AccordionHeader from 'primevue/accordionheader';
import AccordionContent from 'primevue/accordioncontent';

useHead({
    title: 'About Me',
});

const START_YEAR = 2017;
const yearsExperience = computed(() => new Date().getFullYear() - START_YEAR);
</script>

<template>
    <div class="w-full max-w-6xl mx-auto flex flex-col p-8">
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <div class="lg:col-span-7 flex flex-col gap-4">
                <h1 class="">About <span class="text-indigo-600">Me</span></h1>
                <div class="w-20 h-1 bg-indigo-600 rounded-full"></div>

                <div class="prose text-gray-600 text-lg">
                    <p>
                        I'll keep this short. I've been programming for about
                        <span class="font-semibold text-indigo-600">{{ yearsExperience }} years</span>,
                        but I've been working with iOS, Android, and web apps since 2013.
                        I discovered my passion for coding around that time.
                    </p>

                    <p class="mt-4">
                        I'm an <span class="italic font-serif text-gray-800 dark:text-gray-200">autodidact</span>.
                        All I need is a topic and an impetus, and I can start researching it.
                        Google really is a magical thing.
                    </p>

                    <p class="mt-4">
                        My list of hobbies is short because <strong>programming is my main hobby</strong>.
                        Beyond that, I've been working out consistently for over a decade.
                        I'm currently back in the gym four times a week, and it feels great to reconnect with that discipline.
                    </p>
                </div>

                <div class="bg-gray-100 border-l-4 border-red-600 rounded-r-lg p-4 mt-2">
                    <div class="flex items-start gap-4">
                        <div class="min-w-16 max-w-16 min-h-16 max-h-16 flex items-center justify-center bg-white rounded-full shadow-sm shrink-0">
                            <i class="pi pi-car text-red-600" style="font-size: 24px;"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white text-sm uppercase tracking-wide">Car Enthusiast</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-500 mt-1">
                                I have a <strong>700 horsepower 1993 Toyota Supra</strong>. When the engine isn't broken and it's clean, 
                                you can find me out driving with friends and finding new places to visit.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center gap-4 mt-4">
                    <h3 class="text-sm font-semibold">Connect</h3>
                    <div class="flex gap-3">
                        <a-social-link network="twitter" class="hover:-translate-y-1 transition-transform duration-300" />
                        <a-social-link network="github" class="hover:-translate-y-1 transition-transform duration-300" />
                        <a-social-link network="stackoverflow" class="hover:-translate-y-1 transition-transform duration-300" />
                        <a-social-link network="medium" class="hover:-translate-y-1 transition-transform duration-300" />
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 relative group">
                <div class="absolute -inset-2 bg-linear-to-r from-gray-900 to-gray-600 rounded-xl blur-lg opacity-30 group-hover:opacity-50 transition duration-1000"></div>

                <img
                    src="/adam2.png"
                    class="relative w-full aspect-4/5 object-cover rounded-xl shadow-2xl rotate-2 group-hover:rotate-0 transition-all duration-500 ease-out border-2 border-white"
                    alt="Adam Mackintosh"
                >
            </div>
        </section>

        <section>
            <div class="flex items-center gap-4 mt-8">
                <h2>A Brief Word</h2>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-4">
                <a-card class="h-full border-t-4 border-indigo-500 p-0 overflow-hidden flex flex-col">
                    <div class="bg-gray-900 p-4 flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        <span class="ml-2 font-mono text-xs text-gray-500">message_to_devs.js</span>
                    </div>
                    <div class="flex-1 bg-gray-50 p-8">
                        <h2 class="font-mono text-xl font-semibold text-indigo-600 mb-4">&lt;ToProgrammers /&gt;</h2>
                        <div class="font-mono text-sm md:text-base text-gray-700">
                            <p>
                                I like to use <span class="text-gray-700 bg-gray-200 dark:bg-pink-900/20 px-1 rounded">finite state machines</span>, 
                                predicates, booleans, and low-arity functions.
                            </p>
                            <p class="mt-4">
                                I'm a huge advocate for <strong>immutable functional-reactive programming (FRP)</strong>. 
                                Give me a <span class="text-indigo-600 font-semibold">map</span>, <span class="text-indigo-600 font-semibold">reduce</span>, 
                                or <span class="text-indigo-600 font-semibold">filter</span> over a for-loop any day.
                            </p>
                            <p class="text-gray-600 italic border-l-2 border-gray-300 pl-3 mt-4">
                                // Push vs Pull<br>
                                Pushing is doing & triggering.<br>
                                Pulling is listening & acting.
                            </p>
                        </div>
                    </div>
                </a-card>

                <a-card class="h-full border-t-4 border-emerald-500 p-8">
                    <h3 class="text-emerald-700!">To Non-Programmers</h3>

                    <div class="w-full mt-4">
                        <Accordion :value="[]" multiple class="space-y-2">
                            <AccordionPanel value="0">
                                <AccordionHeader>
                                    <span class="font-semibold text-gray-700">Work</span>
                                </AccordionHeader>
                                <AccordionContent>
                                    <p class="leading-relaxed text-gray-600">
                                        As a developer, I aim to write not only pragmatic code but also empathetic 
                                        and thorough technical documentation. I believe software should be understandable by humans, not just machines.
                                    </p>
                                </AccordionContent>
                            </AccordionPanel>

                            <AccordionPanel value="1">
                                <AccordionHeader>
                                    <span class="font-semibold text-gray-700">Life</span>
                                </AccordionHeader>
                                <AccordionContent>
                                    <p class="leading-relaxed text-gray-600">
                                        I am introverted, creative, and known for being precise. I decompress from work by 
                                        cooking nice meals. I love the chemistry behind balancing 
                                        <span class="italic">salty, sweet, sour, and hot</span>.
                                    </p>
                                </AccordionContent>
                            </AccordionPanel>

                            <AccordionPanel value="2">
                                <AccordionHeader>
                                    <span class="font-semibold text-gray-700">Balance</span>
                                </AccordionHeader>
                                <AccordionContent>
                                    <p class="leading-relaxed text-gray-600">
                                        Fitness & nutrition have been a way of life for me since 2009. 
                                        A healthy mind and optimized thinking both start with physical health.
                                    </p>
                                </AccordionContent>
                            </AccordionPanel>
                        </Accordion>
                    </div>
                </a-card>
            </div>
        </section>

        <section class="mt-8">
            <div class="text-center">
                <h2>My Timeline</h2>
                <p class="text-gray-600 mt-2">A history of jobs</p>
            </div>

            <interactive-timeline></interactive-timeline>
        </section>

        <p class="text-lg text-center mt-8">
            Want to chat about cars or code?
            <router-link
                :to="{ name: 'contact' }"
                class="text-indigo-600 font-semibold hover:underline hover:text-indigo-700 active:text-indigo-800 transition-colors ml-1"
            >
                Drop me a message.
            </router-link>
        </p>
    </div>
</template>
