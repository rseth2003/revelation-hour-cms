@if(session('prayer_success') || session('success'))
    <div class="rhmi-toast-wrap" data-rhmi-toast>
        <div class="rhmi-toast" role="status" aria-live="polite">
            <div class="rhmi-toast-icon">✓</div>

            <div class="rhmi-toast-copy">
                <strong>{{ session('prayer_success') ? 'Prayer request received' : 'Success' }}</strong>
                <p>{{ session('prayer_success') ?? session('success') }}</p>
            </div>

            <button type="button" class="rhmi-toast-close" data-rhmi-toast-close aria-label="Close notification">×</button>
        </div>
    </div>
@endif
