const STORAGE_KEY = 'rhmi-theme';
const THEMES = ['system', 'light', 'dark'];

function storedTheme() {
    const value = window.localStorage.getItem(STORAGE_KEY);
    return THEMES.includes(value) ? value : 'system';
}

function resolvedTheme(preference) {
    if (preference === 'system') {
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    return preference;
}

function applyTheme(preference, persist = true) {
    const resolved = resolvedTheme(preference);
    document.documentElement.dataset.themePreference = preference;
    document.documentElement.dataset.theme = resolved;
    document.documentElement.style.colorScheme = resolved;

    if (persist) {
        window.localStorage.setItem(STORAGE_KEY, preference);
    }

    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        const icon = button.querySelector('[data-theme-icon]');
        const label = button.querySelector('[data-theme-label]');
        const names = { system: 'System theme', light: 'Light mode', dark: 'Dark mode' };
        const icons = { system: '◐', light: '☀', dark: '☾' };

        if (icon) icon.textContent = icons[preference];
        if (label) label.textContent = names[preference];
        button.setAttribute('aria-label', `${names[preference]}. Activate the next appearance mode.`);
        button.setAttribute('title', `${names[preference]} — click to change`);
    });

    const themeMeta = document.querySelector('meta[name="theme-color"]');
    if (themeMeta) {
        themeMeta.setAttribute('content', resolved === 'dark' ? '#08111f' : '#16005f');
    }
}

function createToggle() {
    if (document.querySelector('[data-theme-toggle]')) return;

    const button = document.createElement('button');
    button.type = 'button';
    button.className = 'rhmi-theme-toggle';
    button.dataset.themeToggle = '';
    button.innerHTML = '<span data-theme-icon aria-hidden="true">◐</span><span data-theme-label>System theme</span>';

    button.addEventListener('click', () => {
        const current = storedTheme();
        const next = THEMES[(THEMES.indexOf(current) + 1) % THEMES.length];
        applyTheme(next);
    });

    document.body.appendChild(button);
    applyTheme(storedTheme(), false);
}

const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
mediaQuery.addEventListener?.('change', () => {
    if (storedTheme() === 'system') applyTheme('system', false);
});

document.addEventListener('DOMContentLoaded', createToggle);
applyTheme(storedTheme(), false);
