<script setup>
import { useHead } from '@unhead/vue';

useHead({
    title: 'Design System Colours',
});
</script>

<template>
    <a-card class="p-8">
        <h2>Colours</h2>

        <p class="mt-4">This site uses Tailwind to manage colours.</p>

        <h2 class="mt-8">Palettes</h2>

        <p class="max-w-lg mt-2">
            For each background colour, there is an appropriate foreground colour.
            Below are the available colours and their corresponding foreground colours
            for optimal contrast ratio for accessibility reasons.
        </p>

        <div class="w-full grid grid-cols-5 gap-4 mt-8">
            <div class="w-full flex flex-col">
                <h3>Grayscale</h3>
                <div class="flex items-center justify-between p-4 bg-gray-50"><span>50</span></div>
                <div class="flex items-center justify-between p-4 bg-gray-100"><span>100</span></div>
                <div class="flex items-center justify-between p-4 bg-gray-200"><span>200</span></div>
                <div class="flex items-center justify-between p-4 bg-gray-300"><span>300</span></div>
                <div class="flex items-center justify-between p-4 bg-gray-400"><span>400</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-gray-500"><span>500</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-gray-600"><span>600</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-gray-700"><span>700</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-gray-800"><span>800</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-gray-900"><span>900</span></div>
            </div>

            <div class="w-full flex flex-col">
                <h3>Red</h3>
                <div class="flex items-center justify-between p-4 bg-red-50"><span>50</span></div>
                <div class="flex items-center justify-between p-4 bg-red-100"><span>100</span></div>
                <div class="flex items-center justify-between p-4 bg-red-200"><span>200</span></div>
                <div class="flex items-center justify-between p-4 bg-red-300"><span>300</span></div>
                <div class="flex items-center justify-between p-4 bg-red-400"><span>400</span></div>
                <div class="flex items-center justify-between p-4 bg-red-500"><span>500</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-red-600"><span>600</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-red-700"><span>700</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-red-800"><span>800</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-red-900"><span>900</span></div>
            </div>

            <div class="w-full flex flex-col">
                <h3>Orange</h3>
                <div class="flex items-center justify-between p-4 bg-orange-50"><span>50</span></div>
                <div class="flex items-center justify-between p-4 bg-orange-100"><span>100</span></div>
                <div class="flex items-center justify-between p-4 bg-orange-200"><span>200</span></div>
                <div class="flex items-center justify-between p-4 bg-orange-300"><span>300</span></div>
                <div class="flex items-center justify-between p-4 bg-orange-400"><span>400</span></div>
                <div class="flex items-center justify-between p-4 bg-orange-500"><span>500</span></div>
                <div class="flex items-center justify-between p-4 bg-orange-600"><span>600</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-orange-700"><span>700</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-orange-800"><span>800</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-orange-900"><span>900</span></div>
            </div>

            <div class="w-full flex flex-col">
                <h3>Yellow</h3>
                <div class="flex items-center justify-between p-4 bg-yellow-50"><span>50</span></div>
                <div class="flex items-center justify-between p-4 bg-yellow-100"><span>100</span></div>
                <div class="flex items-center justify-between p-4 bg-yellow-200"><span>200</span></div>
                <div class="flex items-center justify-between p-4 bg-yellow-300"><span>300</span></div>
                <div class="flex items-center justify-between p-4 bg-yellow-400"><span>400</span></div>
                <div class="flex items-center justify-between p-4 bg-yellow-500"><span>500</span></div>
                <div class="flex items-center justify-between p-4 bg-yellow-600"><span>600</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-yellow-700"><span>700</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-yellow-800"><span>800</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-yellow-900"><span>900</span></div>
            </div>

            <div class="w-full flex flex-col">
                <h3>Green</h3>
                <div class="flex items-center justify-between p-4 bg-green-50"><span>50</span></div>
                <div class="flex items-center justify-between p-4 bg-green-100"><span>100</span></div>
                <div class="flex items-center justify-between p-4 bg-green-200"><span>200</span></div>
                <div class="flex items-center justify-between p-4 bg-green-300"><span>300</span></div>
                <div class="flex items-center justify-between p-4 bg-green-400"><span>400</span></div>
                <div class="flex items-center justify-between p-4 bg-green-500"><span>500</span></div>
                <div class="flex items-center justify-between p-4 bg-green-600"><span>600</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-green-700"><span>700</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-green-800"><span>800</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-green-900"><span>900</span></div>
            </div>

            <div class="w-full flex flex-col">
                <h3>Teal</h3>
                <div class="flex items-center justify-between p-4 bg-teal-50"><span>50</span></div>
                <div class="flex items-center justify-between p-4 bg-teal-100"><span>100</span></div>
                <div class="flex items-center justify-between p-4 bg-teal-200"><span>200</span></div>
                <div class="flex items-center justify-between p-4 bg-teal-300"><span>300</span></div>
                <div class="flex items-center justify-between p-4 bg-teal-400"><span>400</span></div>
                <div class="flex items-center justify-between p-4 bg-teal-500"><span>500</span></div>
                <div class="flex items-center justify-between p-4 bg-teal-600"><span>600</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-teal-700"><span>700</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-teal-800"><span>800</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-teal-900"><span>900</span></div>
            </div>

            <div class="w-full flex flex-col">
                <h3>Blue</h3>
                <div class="flex items-center justify-between p-4 bg-blue-50"><span>50</span></div>
                <div class="flex items-center justify-between p-4 bg-blue-100"><span>100</span></div>
                <div class="flex items-center justify-between p-4 bg-blue-200"><span>200</span></div>
                <div class="flex items-center justify-between p-4 bg-blue-300"><span>300</span></div>
                <div class="flex items-center justify-between p-4 bg-blue-400"><span>400</span></div>
                <div class="flex items-center justify-between p-4 bg-blue-500"><span>500</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-blue-600"><span>600</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-blue-700"><span>700</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-blue-800"><span>800</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-blue-900"><span>900</span></div>
            </div>

            <div class="w-full flex flex-col">
                <h3>Indigo</h3>
                <div class="flex items-center justify-between p-4 bg-indigo-50"><span>50</span></div>
                <div class="flex items-center justify-between p-4 bg-indigo-100"><span>100</span></div>
                <div class="flex items-center justify-between p-4 bg-indigo-200"><span>200</span></div>
                <div class="flex items-center justify-between p-4 bg-indigo-300"><span>300</span></div>
                <div class="flex items-center justify-between p-4 bg-indigo-400"><span>400</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-indigo-500"><span>500</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-indigo-600"><span>600</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-indigo-700"><span>700</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-indigo-800"><span>800</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-indigo-900"><span>900</span></div>
            </div>

            <div class="w-full flex flex-col">
                <h3>Purple</h3>
                <div class="flex items-center justify-between p-4 bg-purple-50"><span>50</span></div>
                <div class="flex items-center justify-between p-4 bg-purple-100"><span>100</span></div>
                <div class="flex items-center justify-between p-4 bg-purple-200"><span>200</span></div>
                <div class="flex items-center justify-between p-4 bg-purple-300"><span>300</span></div>
                <div class="flex items-center justify-between p-4 bg-purple-400"><span>400</span></div>
                <div class="flex items-center justify-between p-4 bg-purple-500"><span>500</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-purple-600"><span>600</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-purple-700"><span>700</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-purple-800"><span>800</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-purple-900"><span>900</span></div>
            </div>

            <div class="w-full flex flex-col">
                <h3>Pink</h3>
                <div class="flex items-center justify-between p-4 bg-pink-50"><span>50</span></div>
                <div class="flex items-center justify-between p-4 bg-pink-100"><span>100</span></div>
                <div class="flex items-center justify-between p-4 bg-pink-200"><span>200</span></div>
                <div class="flex items-center justify-between p-4 bg-pink-300"><span>300</span></div>
                <div class="flex items-center justify-between p-4 bg-pink-400"><span>400</span></div>
                <div class="flex items-center justify-between p-4 bg-pink-500"><span>500</span></div>
                <div class="flex items-center justify-between p-4 bg-pink-600"><span>600</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-pink-700"><span>700</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-pink-800"><span>800</span></div>
                <div class="flex items-center justify-between p-4 text-white bg-pink-900"><span>900</span></div>
            </div>
        </div>
    </a-card>
</template>
