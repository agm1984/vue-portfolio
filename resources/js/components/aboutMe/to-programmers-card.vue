<script setup>
</script>

<template>
    <a-card class="h-full bg-indigo-50! border-t-4 border-indigo-500 p-0 overflow-hidden flex flex-col">
        <div class="bg-gray-900 p-4 flex items-center gap-2">
            <div class="w-3 h-3 rounded-full bg-red-500"></div>
            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
            <div class="w-3 h-3 rounded-full bg-green-500"></div>
            <span class="ml-2 font-mono text-xs text-gray-500">message_to_devs.js</span>
        </div>
        <div class="flex-1 p-8">
            <h2 class="font-mono text-indigo-600! mb-4">&lt;ToProgrammers /&gt;</h2>
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
</template>
