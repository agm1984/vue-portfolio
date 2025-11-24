import { ref, onMounted } from 'vue';

export function useDarkMode() {
    const isDark = ref(false);

    const applyTheme = (dark) => {
        const root = document.documentElement;
        if (dark) {
            root.classList.add('dark');

        } else {
            root.classList.remove('dark');
        }
    };

    const toggleTheme = () => {
        isDark.value = !isDark.value;
        applyTheme(isDark.value);
        localStorage.setItem('theme', isDark.value ? 'dark' : 'light');
    };

    onMounted(() => {
        const storedTheme = localStorage.getItem('theme');
        const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        if (storedTheme === 'dark' || (!storedTheme && systemDark)) {
            isDark.value = true;
        } else {
            isDark.value = false;
        }

        applyTheme(isDark.value);
    });

    return {
        isDark,
        toggleTheme
    };
};
