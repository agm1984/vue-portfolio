<template>
    <a-card id="design-system-colour" class="p-32" with-geometry>

        <h2 level="2" dark>Colours</h2>

        <a-paragraph>
            This site uses Tailwind to manage colours.
        </a-paragraph>

        <h2 level="2" dark>Palettes</h2>

        <h2 level="3" primary nunito>Brand</h2>
        <div class="flex flex-col w-full h-64 p-8 text-white bg-primary">
            <span>Primary</span>
            <span>#006666</span>
        </div>
        <div class="flex flex-col w-full h-64 p-8 mt-16 text-white bg-secondary">
            <span>Secondary</span>
            <span>#006699</span>
        </div>

        <div class="flex flex-col mt-32 w-192">
            <h2 level="3" primary nunito>Greyscale</h2>
            <div class="flex items-center justify-between p-8 bg-grey-100"><span>100</span><span>#f7fafc</span></div>
            <div class="flex items-center justify-between p-8 bg-grey-200"><span>200</span><span>#edf2f7</span></div>
            <div class="flex items-center justify-between p-8 bg-grey-300"><span>300</span><span>#e2e8f0</span></div>
            <div class="flex items-center justify-between p-8 bg-grey-400"><span>400</span><span>#cbd5e0</span></div>
            <div class="flex items-center justify-between p-8 bg-grey-500"><span>500</span><span>#a0aec0</span></div>
            <div class="flex items-center justify-between p-8 text-white bg-grey-600"><span>600</span><span>#718096</span></div>
            <div class="flex items-center justify-between p-8 text-white bg-grey-700"><span>700</span><span>#4a5568</span></div>
            <div class="flex items-center justify-between p-8 text-white bg-grey-800"><span>800</span><span>#2d3748</span></div>
            <div class="flex items-center justify-between p-8 text-white bg-grey-900"><span>900</span><span>#1a202c</span></div>
        </div>

        <div class="flex flex-wrap mt-32">
            <div class="flex flex-col w-192">
                <h2 level="3" primary nunito>Red</h2>
                <div class="flex items-center justify-between p-8 bg-red-100"><span>100</span><span>#fff5f5</span></div>
                <div class="flex items-center justify-between p-8 bg-red-200"><span>200</span><span>#fed7d7</span></div>
                <div class="flex items-center justify-between p-8 bg-red-300"><span>300</span><span>#feb2b2</span></div>
                <div class="flex items-center justify-between p-8 bg-red-400"><span>400</span><span>#fc8181</span></div>
                <div class="flex items-center justify-between p-8 bg-red-500"><span>500</span><span>#f56565</span></div>
                <div class="flex items-center justify-between p-8 bg-red-600"><span>600</span><span>#e53e3e</span></div>
                <div class="flex items-center justify-between p-8 bg-red-700"><span>700</span><span>#c53030</span></div>
                <div class="flex items-center justify-between p-8 bg-red-800"><span>800</span><span>#9b2c2c</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-red-900"><span>900</span><span>#742a2a</span></div>
            </div>

            <div class="flex flex-col mx-16 w-192">
                <h2 level="3" primary nunito>Orange</h2>
                <div class="flex items-center justify-between p-8 bg-orange-100"><span>100</span><span>#fffaf0</span></div>
                <div class="flex items-center justify-between p-8 bg-orange-200"><span>200</span><span>#feebc8</span></div>
                <div class="flex items-center justify-between p-8 bg-orange-300"><span>300</span><span>#fbd38d</span></div>
                <div class="flex items-center justify-between p-8 bg-orange-400"><span>400</span><span>#f6ad55</span></div>
                <div class="flex items-center justify-between p-8 bg-orange-500"><span>500</span><span>#ed8936</span></div>
                <div class="flex items-center justify-between p-8 bg-orange-600"><span>600</span><span>#dd6b20</span></div>
                <div class="flex items-center justify-between p-8 bg-orange-700"><span>700</span><span>#c05621</span></div>
                <div class="flex items-center justify-between p-8 bg-orange-800"><span>800</span><span>#9c4221</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-orange-900"><span>900</span><span>#7b341e</span></div>
            </div>

            <div class="flex flex-col w-192">
                <h2 level="3" primary nunito>Yellow</h2>
                <div class="flex items-center justify-between p-8 bg-yellow-100"><span>100</span><span>#fffff0</span></div>
                <div class="flex items-center justify-between p-8 bg-yellow-200"><span>200</span><span>#fefcbf</span></div>
                <div class="flex items-center justify-between p-8 bg-yellow-300"><span>300</span><span>#faf089</span></div>
                <div class="flex items-center justify-between p-8 bg-yellow-400"><span>400</span><span>#f6e05e</span></div>
                <div class="flex items-center justify-between p-8 bg-yellow-500"><span>500</span><span>#ecc94b</span></div>
                <div class="flex items-center justify-between p-8 bg-yellow-600"><span>600</span><span>#d69e2e</span></div>
                <div class="flex items-center justify-between p-8 bg-yellow-700"><span>700</span><span>#b7791f</span></div>
                <div class="flex items-center justify-between p-8 bg-yellow-800"><span>800</span><span>#975a16</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-yellow-900"><span>900</span><span>#744210</span></div>
            </div>
        </div>

        <div class="flex flex-wrap mt-32">
            <div class="flex flex-col w-192">
                <h2 level="3" primary nunito>Green</h2>
                <div class="flex items-center justify-between p-8 bg-green-100"><span>100</span><span>#f0fff4</span></div>
                <div class="flex items-center justify-between p-8 bg-green-200"><span>200</span><span>#c6f6d5</span></div>
                <div class="flex items-center justify-between p-8 bg-green-300"><span>300</span><span>#9ae6b4</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-green-400"><span>400</span><span>#68d391</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-green-500"><span>500</span><span>#48bb78</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-green-600"><span>600</span><span>#38a169</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-green-700"><span>700</span><span>#2f855a</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-green-800"><span>800</span><span>#276749</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-green-900"><span>900</span><span>#22543d</span></div>
            </div>

            <div class="flex flex-col mx-16 w-192">
                <h2 level="3" primary nunito>Teal</h2>
                <div class="flex items-center justify-between p-8 bg-teal-100"><span>100</span><span>#e6fffa</span></div>
                <div class="flex items-center justify-between p-8 bg-teal-200"><span>200</span><span>#b2f5ea</span></div>
                <div class="flex items-center justify-between p-8 bg-teal-300"><span>300</span><span>#81e6d9</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-teal-400"><span>400</span><span>#4fd1c5</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-teal-500"><span>500</span><span>#38b2ac</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-teal-600"><span>600</span><span>#319795</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-teal-700"><span>700</span><span>#2c7a7b</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-teal-800"><span>800</span><span>#285e61</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-teal-900"><span>900</span><span>#234e52</span></div>
            </div>

            <div class="flex flex-col w-192">
                <h2 level="3" primary nunito>Blue</h2>
                <div class="flex items-center justify-between p-8 bg-blue-100"><span>100</span><span>#ebf8ff</span></div>
                <div class="flex items-center justify-between p-8 bg-blue-200"><span>200</span><span>#bee3f8</span></div>
                <div class="flex items-center justify-between p-8 bg-blue-300"><span>300</span><span>#90cdf4</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-blue-400"><span>400</span><span>#63b3ed</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-blue-500"><span>500</span><span>#4299e1</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-blue-600"><span>600</span><span>#3182ce</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-blue-700"><span>700</span><span>#2b6cb0</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-blue-800"><span>800</span><span>#2c5282</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-blue-900"><span>900</span><span>#2a4365</span></div>
            </div>
        </div>

        <div class="flex flex-wrap mt-32">
            <div class="flex flex-col w-192">
                <h2 level="3" primary nunito>Indigo</h2>
                <div class="flex items-center justify-between p-8 bg-indigo-100"><span>100</span><span>#ebf4ff</span></div>
                <div class="flex items-center justify-between p-8 bg-indigo-200"><span>200</span><span>#c3dafe</span></div>
                <div class="flex items-center justify-between p-8 bg-indigo-300"><span>300</span><span>#a3bffa</span></div>
                <div class="flex items-center justify-between p-8 bg-indigo-400"><span>400</span><span>#7f9cf5</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-indigo-500"><span>500</span><span>#667eea</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-indigo-600"><span>600</span><span>#5a67d8</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-indigo-700"><span>700</span><span>#4c51bf</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-indigo-800"><span>800</span><span>#434190</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-indigo-900"><span>900</span><span>#3c366b</span></div>
            </div>

            <div class="flex flex-col mx-16 w-192">
                <h2 level="3" primary nunito>Purple</h2>
                <div class="flex items-center justify-between p-8 bg-purple-100"><span>100</span><span>#faf5ff</span></div>
                <div class="flex items-center justify-between p-8 bg-purple-200"><span>200</span><span>#e9d8fd</span></div>
                <div class="flex items-center justify-between p-8 bg-purple-300"><span>300</span><span>#d6bcfa</span></div>
                <div class="flex items-center justify-between p-8 bg-purple-400"><span>400</span><span>#b794f4</span></div>
                <div class="flex items-center justify-between p-8 bg-purple-500"><span>500</span><span>#9f7aea</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-purple-600"><span>600</span><span>#805ad5</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-purple-700"><span>700</span><span>#6b46c1</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-purple-800"><span>800</span><span>#553c9a</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-purple-900"><span>900</span><span>#44337a</span></div>
            </div>

            <div class="flex flex-col w-192">
                <h2 level="3" primary nunito>Pink</h2>
                <div class="flex items-center justify-between p-8 bg-pink-100"><span>100</span><span>#fff5f7</span></div>
                <div class="flex items-center justify-between p-8 bg-pink-200"><span>200</span><span>#fed7e2</span></div>
                <div class="flex items-center justify-between p-8 bg-pink-300"><span>300</span><span>#fbb6ce</span></div>
                <div class="flex items-center justify-between p-8 bg-pink-400"><span>400</span><span>#f687b3</span></div>
                <div class="flex items-center justify-between p-8 bg-pink-500"><span>500</span><span>#ed64a6</span></div>
                <div class="flex items-center justify-between p-8 bg-pink-600"><span>600</span><span>#d53f8c</span></div>
                <div class="flex items-center justify-between p-8 bg-pink-700"><span>700</span><span>#b83280</span></div>
                <div class="flex items-center justify-between p-8 bg-pink-800"><span>800</span><span>#97266d</span></div>
                <div class="flex items-center justify-between p-8 text-white bg-pink-900"><span>900</span><span>#702459</span></div>
            </div>
        </div>
    </a-card>
</template>

<script>
export default {
    name: 'colour',

    data() {
        return {};
    },

    computed: {},

    methods: {},

};
</script>
