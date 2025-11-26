<script setup>
import { ref, reactive, computed } from 'vue';
import { useHead } from '@unhead/vue';
import { required, email, minLength } from '@vuelidate/validators';
import { useVuelidate } from '@vuelidate/core';
import { useRouter } from 'vue-router';
import InputText from 'primevue/inputtext';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import Password from 'primevue/password';
import Textarea from 'primevue/textarea';
import Checkbox from 'primevue/checkbox';
import RadioButton from 'primevue/radiobutton';
import Button from 'primevue/button';
import ToggleSwitch from 'primevue/toggleswitch';
import Select from 'primevue/select';
import Divider from 'primevue/divider';
import Tag from 'primevue/tag';

useHead({
    title: 'Design System Forms',
});

const router = useRouter();

const playground = reactive({
    text: '',
    disabled: false,
    invalid: false,
    size: null,
    icon: 'none',
});

const sizes = [
    { label: 'Small', value: 'small' },
    { label: 'Normal', value: null },
    { label: 'Large', value: 'large' },
];

const iconOptions = [
    { label: 'None', value: 'none' },
    { label: 'Left', value: 'left' },
    { label: 'Right', value: 'right' },
];

const generatedCode = computed(() => {
    const parts = [];
    const isIcon = playground.icon !== 'none';

    if (isIcon) parts.push(`<IconField iconPosition="${playground.icon}">`);
    if (isIcon && playground.icon === 'left') parts.push(`    <InputIcon class="pi pi-search" />`);

    let inputProps = `v-model="value"`;
    if (playground.size) inputProps += ` size="${playground.size}"`;
    if (playground.invalid) inputProps += ` invalid`;
    if (playground.disabled) inputProps += ` disabled`;

    parts.push(`${isIcon ? '    ' : ''}<InputText ${inputProps} />`);

    if (isIcon && playground.icon === 'right') parts.push(`    <InputIcon class="pi pi-search" />`);
    if (isIcon) parts.push(`</IconField>`);

    return parts.join('\n');
});

const form = reactive({ email: '', password: '' });
const rules = { email: { required, email }, password: { required, minLength: minLength(6) } };
const v$ = useVuelidate(rules, form);
const submitted = ref(false);

const validateForm = async () => {
    submitted.value = true;
    const valid = await v$.value.$validate();
    if (valid) {
        alert('Form is valid!');
        submitted.value = false;
        v$.value.$reset();
        form.email = ''; form.password = '';
    }
};


const checkboxValue = ref(false);
const radioValue = ref(null);
const switchValue = ref(false);
const selectedCity = ref();
const selectedTech = ref();

const cities = [
    { name: 'New York', code: 'NY' },
    { name: 'Rome', code: 'RM' },
    { name: 'London', code: 'LDN' },
    { name: 'Istanbul', code: 'IST' },
    { name: 'Paris', code: 'PRS' }
];

const technologies = [
    { name: 'Vue.js', type: 'Frontend', icon: 'pi pi-code' },
    { name: 'Laravel', type: 'Backend', icon: 'pi pi-server' },
    { name: 'Tailwind', type: 'CSS', icon: 'pi pi-palette' },
    { name: 'Docker', type: 'DevOps', icon: 'pi pi-box' },
];

const goBack = () => router.push({ name: 'design' });
</script>

<template>
    <a-page>
        <a-page-title
            title="Forms"
            description="A comprehensive guide to input fields, selection controls, and validation patterns."
            has-back
            @on-back="goBack"
        ></a-page-title>

        <a-card class="p-8">
            <h3>Input Playground</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-normal mt-1">Configure the state and style of text inputs.</p>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mt-4">
                <div class="lg:col-span-7 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center justify-center min-h-[200px] p-8">
                    <div class="w-full max-w-xs">
                        <template v-if="playground.icon !== 'none'">
                            <IconField :iconPosition="playground.icon">
                                <InputIcon v-if="playground.icon === 'left'" class="pi pi-search" />
                                <InputText v-model="playground.text" placeholder="Type here..." class="w-full" :size="playground.size" :invalid="playground.invalid" :disabled="playground.disabled" />
                                <InputIcon v-if="playground.icon === 'right'" class="pi pi-search" />
                            </IconField>
                        </template>
                        <template v-else>
                            <InputText v-model="playground.text" placeholder="Type here..." class="w-full" :size="playground.size" :invalid="playground.invalid" :disabled="playground.disabled" />
                        </template>
                    </div>
                </div>

                <div class="lg:col-span-5 space-y-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase text-gray-400">State</label>
                        <div class="flex gap-2">
                            <Button label="Invalid" :severity="playground.invalid ? 'danger' : 'secondary'" @click="playground.invalid = !playground.invalid" size="small" />
                            <Button label="Disabled" :severity="playground.disabled ? 'contrast' : 'secondary'" @click="playground.disabled = !playground.disabled" size="small" />
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase text-gray-400">Size</label>
                        <div class="flex gap-2">
                            <Button v-for="size in sizes" :key="size.label" :label="size.label" :severity="playground.size === size.value ? 'primary' : 'secondary'" size="small" @click="playground.size = size.value" />
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase text-gray-400">Icon Position</label>
                        <div class="flex gap-2">
                            <Button v-for="opt in iconOptions" :key="opt.label" :label="opt.label" :severity="playground.icon === opt.value ? 'primary' : 'secondary'" size="small" @click="playground.icon = opt.value" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-8"><a-code language="html" :code="generatedCode" /></div>
        </a-card>

        <a-card class="border-l-4 border-indigo-500 border-y border-r dark:border-gray-700 p-8 mt-8">
            <h3 class="text-gray-900 dark:text-white">Validation Architecture</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-normal mt-1">
                Live demo of <code class="text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 px-1 rounded">a-input-field</code> + <code class="text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 px-1 rounded">a-field-errors</code> integration.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mt-4">
                <form @submit.prevent="validateForm" class="space-y-6">
                    <div>
                        <a-input-field input-id="demo-email" title="Email" required />
                        <IconField iconPosition="left">
                            <InputIcon class="pi pi-envelope" />
                            <InputText id="demo-email" v-model="v$.email.$model" :class="{'p-invalid': v$.email.$invalid && submitted}" class="w-full" placeholder="Try 'invalid-email'..." />
                        </IconField>
                        <a-field-errors v-if="v$.email.$error && submitted" :errors="v$.email.$errors" name="Email" />
                    </div>
                    <div>
                        <a-input-field input-id="demo-pass" title="Password" required />
                        <Password id="demo-pass" v-model="v$.password.$model" :invalid="v$.password.$invalid && submitted" toggleMask feedback class="w-full" inputClass="w-full" placeholder="Min 6 chars..." />
                        <a-field-errors v-if="v$.password.$error && submitted" :errors="v$.password.$errors" name="Password" />
                    </div>
                    <Button type="submit" label="Test Validation" />
                </form>
                <div class="bg-gray-50 dark:bg-gray-900 p-6 rounded-xl border border-gray-200 dark:border-gray-700 text-sm space-y-4">
                    <h4 class="font-bold text-gray-900 dark:text-white uppercase tracking-wider">How it works</h4>
                    <ol class="list-decimal list-inside space-y-2 text-gray-600 dark:text-gray-400">
                        <li><strong>State:</strong> Use <code>v$.fieldName.$model</code> for v-model binding.</li>
                        <li><strong>Style:</strong> Bind <code>:invalid</code> based on Vuelidate state.</li>
                        <li><strong>Feedback:</strong> Use <code>&lt;a-field-errors&gt;</code> for error messages.</li>
                    </ol>
                    <Divider />
                    <div class="font-mono text-xs text-indigo-600 dark:text-indigo-400">Current Status: {{ v$.$invalid ? 'INVALID' : 'VALID' }}</div>
                </div>
            </div>
        </a-card>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
            <a-card class="p-8 h-full">
                <h3>Boolean</h3>

                <div class="space-y-4 mt-4">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center">
                            <Checkbox v-model="checkboxValue" :binary="true" inputId="check1" />
                            <label for="check1" class="ml-2 cursor-pointer text-gray-700 dark:text-gray-300">Accept</label>
                        </div>
                        <div class="flex items-center">
                            <Checkbox :modelValue="true" :binary="true" disabled inputId="check2" />
                            <label for="check2" class="ml-2 text-gray-400 dark:text-gray-500">Disabled</label>
                        </div>
                    </div>
                    <Divider />
                    <div class="flex items-center gap-4">
                        <div class="flex items-center">
                            <RadioButton v-model="radioValue" inputId="opt1" name="opts" value="1" />
                            <label for="opt1" class="ml-2 cursor-pointer text-gray-700 dark:text-gray-300">Opt 1</label>
                        </div>
                        <div class="flex items-center">
                            <RadioButton v-model="radioValue" inputId="opt2" name="opts" value="2" />
                            <label for="opt2" class="ml-2 cursor-pointer text-gray-700 dark:text-gray-300">Opt 2</label>
                        </div>
                    </div>
                    <Divider />
                    <div class="flex items-center gap-4">
                        <div class="flex items-center">
                            <ToggleSwitch v-model="switchValue" inputId="switch1" />
                            <label for="switch1" class="ml-2 cursor-pointer text-gray-700 dark:text-gray-300">Notify me</label>
                        </div>
                    </div>
                </div>
            </a-card>

            <a-card class="p-8 h-full">
                <h3>Text Area</h3>

                <div class="space-y-4 mt-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Supports auto-resize.</p>
                    <Textarea placeholder="Type a long message here..." rows="5" autoResize class="w-full" />
                </div>
            </a-card>

            <a-card class="p-8 h-full">
                <h3>Select Menu</h3>

                <div class="space-y-6 mt-4">
                    <div class="flex flex-col gap-2">
                        <h6 class="text-gray-900 dark:text-white">Standard</h6>
                        <Select
                            v-model="selectedCity"
                            :options="cities"
                            optionLabel="name"
                            placeholder="Select a City"
                            class="w-full"
                        />
                    </div>

                    <Divider />

                    <div class="flex flex-col gap-2">
                        <h6 class="text-gray-900 dark:text-white">Search & Template</h6>
                        <Select
                            v-model="selectedTech"
                            :options="technologies"
                            optionLabel="name"
                            placeholder="Select Tech"
                            filter
                            class="w-full"
                        >
                            <template #value="slotProps">
                                <div v-if="slotProps.value" class="flex items-center">
                                    <i :class="slotProps.value.icon" class="mr-2 text-indigo-500"></i>
                                    <div>{{ slotProps.value.name }}</div>
                                </div>
                                <span v-else>{{ slotProps.placeholder }}</span>
                            </template>
                            <template #option="slotProps">
                                <div class="flex items-center">
                                    <i :class="slotProps.option.icon" class="mr-2 text-gray-400"></i>
                                    <div>{{ slotProps.option.name }}</div>
                                    <Tag :value="slotProps.option.type" severity="secondary" class="ml-auto !text-[10px] uppercase" />
                                </div>
                            </template>
                        </Select>
                    </div>
                </div>
            </a-card>
        </div>
    </a-page>
</template>
