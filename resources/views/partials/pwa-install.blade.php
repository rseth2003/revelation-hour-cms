<div id="pwa-install-banner" class="pwa-install-banner" hidden role="region" aria-label="Install RHMI app">
    <div class="pwa-install-icon" aria-hidden="true">RH</div>
    <div class="pwa-install-copy">
        <strong>Install the RHMI app</strong>
        <span>Open the ministry website faster from your home screen.</span>
    </div>
    <button type="button" id="pwa-install-button" class="pwa-install-action">Install</button>
    <button type="button" id="pwa-install-dismiss" class="pwa-install-dismiss" aria-label="Dismiss install prompt">×</button>
</div>

<style>
.pwa-install-banner{position:fixed;left:50%;bottom:18px;z-index:1000;width:min(calc(100% - 28px),620px);transform:translateX(-50%);display:grid;grid-template-columns:auto 1fr auto auto;align-items:center;gap:12px;padding:12px 14px;border:1px solid rgba(255,255,255,.16);border-radius:18px;background:rgba(22,0,95,.96);color:#fff;box-shadow:0 20px 55px rgba(16,4,63,.32);backdrop-filter:blur(14px)}.pwa-install-banner[hidden]{display:none}.pwa-install-icon{width:42px;height:42px;border-radius:12px;display:grid;place-items:center;background:#7fe53d;color:#130654;font-weight:900}.pwa-install-copy{display:flex;flex-direction:column;gap:2px;min-width:0}.pwa-install-copy strong{font-size:14px}.pwa-install-copy span{font-size:12px;color:rgba(255,255,255,.78);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.pwa-install-action{border:0;border-radius:10px;padding:10px 15px;background:#7fe53d;color:#130654;font-weight:800;cursor:pointer}.pwa-install-dismiss{border:0;background:transparent;color:#fff;font-size:25px;line-height:1;cursor:pointer;padding:4px}@media(max-width:580px){.pwa-install-banner{grid-template-columns:auto 1fr auto}.pwa-install-action{grid-column:2/3;justify-self:start;padding:8px 14px}.pwa-install-dismiss{grid-column:3;grid-row:1}.pwa-install-copy span{white-space:normal}}
</style>

<script>
(() => {
    if (!('serviceWorker' in navigator)) return;

    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js').catch(() => {});
    });

    const banner = document.getElementById('pwa-install-banner');
    const installButton = document.getElementById('pwa-install-button');
    const dismissButton = document.getElementById('pwa-install-dismiss');
    let deferredPrompt = null;

    const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
    const dismissedAt = Number(localStorage.getItem('rhmi_pwa_dismissed_at') || 0);
    const dismissedRecently = Date.now() - dismissedAt < 7 * 24 * 60 * 60 * 1000;

    window.addEventListener('beforeinstallprompt', event => {
        event.preventDefault();
        deferredPrompt = event;
        if (!isStandalone && !dismissedRecently) banner.hidden = false;
    });

    installButton.addEventListener('click', async () => {
        if (!deferredPrompt) return;
        banner.hidden = true;
        deferredPrompt.prompt();
        await deferredPrompt.userChoice;
        deferredPrompt = null;
    });

    dismissButton.addEventListener('click', () => {
        banner.hidden = true;
        localStorage.setItem('rhmi_pwa_dismissed_at', String(Date.now()));
    });

    window.addEventListener('appinstalled', () => {
        banner.hidden = true;
        deferredPrompt = null;
    });
})();
</script>
