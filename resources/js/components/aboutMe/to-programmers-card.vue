<script setup>
</script>

<template>
    <a-card class="h-full bg-indigo-50! dark:bg-gray-800! border-t-4 border-indigo-500 p-0 overflow-hidden flex flex-col transition-colors duration-300">
        <div class="bg-gray-900 p-4 flex items-center gap-2 border-b border-transparent dark:border-gray-700">
            <div class="w-3 h-3 rounded-full bg-red-500"></div>
            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
            <div class="w-3 h-3 rounded-full bg-green-500"></div>
            <span class="ml-2 font-mono text-xs text-gray-500 dark:text-gray-400">message_to_devs.js</span>
        </div>

        <div class="flex-1 p-8">
            <h2 class="font-mono text-indigo-600! dark:text-indigo-400! mb-4 transition-colors">&lt;ToProgrammers /&gt;</h2>

            <div class="font-mono text-sm md:text-base text-gray-700 dark:text-gray-300 transition-colors">
                <p>
                    I like to use 
                    <span class="text-gray-700 dark:text-gray-200 bg-gray-200 dark:bg-gray-700 px-1 rounded transition-colors">finite state machines</span>, 
                    predicates, booleans, and low-arity functions.
                </p>

                <p class="mt-4">
                    I'm a huge advocate for <strong class="text-gray-900 dark:text-white">immutable functional-reactive programming (FRP)</strong>. 
                    Give me a 
                    <span class="text-indigo-600 dark:text-indigo-400 font-semibold transition-colors">map</span>,
                    <span class="text-indigo-600 dark:text-indigo-400 font-semibold transition-colors">reduce</span>,
                    or
                    <span class="text-indigo-600 dark:text-indigo-400 font-semibold transition-colors">filter</span>
                    over a for-loop any day.
                </p>

                <p class="italic border-l-2 border-gray-300 dark:border-gray-600 pl-3 mt-4 text-gray-600 dark:text-gray-400 transition-colors">
                    // Push vs Pull<br>
                    Pushing is doing & triggering.<br>
                    Pulling is listening & acting.
                </p>
            </div>
        </div>
    </a-card>
</template>
