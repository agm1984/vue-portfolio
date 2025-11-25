<script setup>
import Accordion from 'primevue/accordion';
import AccordionPanel from 'primevue/accordionpanel';
import AccordionHeader from 'primevue/accordionheader';
import AccordionContent from 'primevue/accordioncontent';
</script>

<template>
    <div class="h-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 border-t-4 border-t-emerald-500 p-8 rounded-xl shadow-sm transition-colors duration-300">
        
        <h2 class="text-2xl font-bold text-emerald-700 dark:text-emerald-400 mb-4 transition-colors">
            To Non-Programmers
        </h2>

        <div class="w-full mt-4">
            <Accordion :value="[]" multiple class="space-y-2">
                <AccordionPanel value="0">
                    <AccordionHeader>
                        <span class="font-semibold text-gray-700 dark:text-gray-200 transition-colors">Work</span>
                    </AccordionHeader>
                    <AccordionContent>
                        <p class="leading-relaxed text-gray-600 dark:text-gray-300 transition-colors">
                            As a developer, I aim to write not only pragmatic code but also empathetic
                            and thorough technical documentation. I believe software should be understandable by humans, not just machines.
                        </p>
                    </AccordionContent>
                </AccordionPanel>

                <AccordionPanel value="1">
                    <AccordionHeader>
                        <span class="font-semibold text-gray-700 dark:text-gray-200 transition-colors">Life</span>
                    </AccordionHeader>
                    <AccordionContent>
                        <p class="leading-relaxed text-gray-600 dark:text-gray-300 transition-colors">
                            I am introverted, creative, and known for being precise. I decompress from work by
                            cooking nice meals. I love the chemistry behind balancing
                            <span class="italic text-emerald-600 dark:text-emerald-400 font-medium">salty, sweet, sour, and hot</span>.
                        </p>
                    </AccordionContent>
                </AccordionPanel>

                <AccordionPanel value="2">
                    <AccordionHeader>
                        <span class="font-semibold text-gray-700 dark:text-gray-200 transition-colors">Balance</span>
                    </AccordionHeader>
                    <AccordionContent>
                        <p class="leading-relaxed text-gray-600 dark:text-gray-300 transition-colors">
                            Fitness & nutrition have been a way of life for me since 2009.
                            A healthy mind and optimized thinking both start with physical health.
                        </p>
                    </AccordionContent>
                </AccordionPanel>
            </Accordion>
        </div>
    </div>
</template>
