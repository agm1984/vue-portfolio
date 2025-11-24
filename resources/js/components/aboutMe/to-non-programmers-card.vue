<script setup>
import Accordion from 'primevue/accordion';
import AccordionPanel from 'primevue/accordionpanel';
import AccordionHeader from 'primevue/accordionheader';
import AccordionContent from 'primevue/accordioncontent';
</script>

<template>
    <a-card class="h-full border-t-4 border-emerald-500 p-8">
        <h2 class="text-emerald-700!">To Non-Programmers</h2>

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
</template>
