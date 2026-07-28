const STORAGE_KEY = 'rhmi-theme';
const THEMES = ['system', 'light', 'dark'];

function storedTheme() {
    const value = window.localStorage.getItem(STORAGE_KEY);
    return THEMES.includes(value) ? value : 'system';
}

function resolvedTheme(preference) {
    return preference === 'system'
        ? (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light')
        : preference;
}

function updateButtons(preference) {
    const labels = { system: 'System', light: 'Light', dark: 'Dark' };
    const icons = { system: '◐', light: '☀', dark: '☾' };

    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        const icon = button.querySelector('[data-theme-icon]');
        const label = button.querySelector('[data-theme-label]');
        if (icon) icon.textContent = icons[preference];
        if (label) label.textContent = labels[preference];
        button.dataset.themeMode = preference;
        button.setAttribute('aria-label', `${labels[preference]} appearance. Click to change theme.`);
        button.setAttribute('title', `${labels[preference]} appearance — click to change`);
    });
}

function applyTheme(preference, persist = true) {
    const resolved = resolvedTheme(preference);
    document.documentElement.dataset.themePreference = preference;
    document.documentElement.dataset.theme = resolved;
    document.documentElement.style.colorScheme = resolved;

    if (persist) window.localStorage.setItem(STORAGE_KEY, preference);
    updateButtons(preference);

    const themeMeta = document.querySelector('meta[name="theme-color"]');
    if (themeMeta) themeMeta.setAttribute('content', resolved === 'dark' ? '#08111f' : '#16005f');
}

function bindToggles() {
    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        if (button.dataset.themeBound === 'true') return;
        button.dataset.themeBound = 'true';
        button.addEventListener('click', () => {
            const current = storedTheme();
            const next = THEMES[(THEMES.indexOf(current) + 1) % THEMES.length];
            applyTheme(next);
        });
    });
    updateButtons(storedTheme());
}

const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
mediaQuery.addEventListener?.('change', () => {
    if (storedTheme() === 'system') applyTheme('system', false);
});

document.addEventListener('DOMContentLoaded', bindToggles);
applyTheme(storedTheme(), false);
