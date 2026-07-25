<footer class="footer" id="contact">
    <div class="container footer-grid">
        <div class="footer-brand">
            <img src="{{ asset('images/revelation-hour-logo.jpg') }}" alt="RHMI logo">
            <p>Revelation Hour Ministries International</p>
        </div>

        <div>
            <h4>Visit Us</h4>
            <p>Valley Road, Canaansite Estate,<br>Nakwero–Gayaza, Uganda</p>
            <p><a href="{{ route('visit') }}">Plan Your Visit</a></p>
            <p>
                <a
                    href="https://maps.app.goo.gl/4zP4RCdjQYg9PoPn6?g_st=awb"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    Open location in Google Maps
                </a>
            </p>

            <h5 class="footer-contact-heading">Contact</h5>
            <div class="footer-contact-numbers">
                <a href="tel:+256774328127">+256 774 328 127</a>
                <a href="tel:+256784537003">+256 784 537 003</a>
            </div>
        </div>

        <div>
            <h4>Quick Links</h4>
            <a href="{{ route('about') }}">About RHMI</a>
            <a href="{{ route('service-times') }}">Service Times</a>
            <a href="{{ route('ministries') }}">Ministries</a>
            <a href="{{ route('events') }}">Events</a>
            <a href="{{ route('sermons') }}">Sermons</a>
            @if(Route::has('library.index'))<a href="{{ route('library.index') }}">eLibrary</a>@endif
            <a href="{{ route('contact') }}">Contact</a>
        </div>

        <div>
            <h4>Connect With Us</h4>
            <div class="social-links" aria-label="Social media links">
                <a class="social-link facebook" href="https://www.facebook.com/profile.php?id=100071484482919" target="_blank" rel="noopener" aria-label="Facebook">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13.5 22v-9h3l.5-3.5h-3.5V7.3c0-1 .3-1.8 1.8-1.8H17V2.4c-.3 0-1.4-.1-2.7-.1-2.7 0-4.6 1.7-4.6 4.8v2.4H7V13h2.7v9h3.8z"/></svg>
                </a>
                <a class="social-link instagram" href="https://www.instagram.com/revelationhourm?igsh=MXA2bTl6YWRhYjA3eg==" target="_blank" rel="noopener" aria-label="Instagram">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7.2 2h9.6A5.2 5.2 0 0 1 22 7.2v9.6a5.2 5.2 0 0 1-5.2 5.2H7.2A5.2 5.2 0 0 1 2 16.8V7.2A5.2 5.2 0 0 1 7.2 2zm0 2A3.2 3.2 0 0 0 4 7.2v9.6A3.2 3.2 0 0 0 7.2 20h9.6a3.2 3.2 0 0 0 3.2-3.2V7.2A3.2 3.2 0 0 0 16.8 4H7.2zm10.1 1.5a1.2 1.2 0 1 1 0 2.4 1.2 1.2 0 0 1 0-2.4zM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/></svg>
                </a>
                <a class="social-link telegram" href="https://t.me/revelationhourministriesintl" target="_blank" rel="noopener" aria-label="Telegram">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21.7 3.3 18.5 20c-.2 1.2-.9 1.5-1.8.9l-4.9-3.6-2.4 2.3c-.3.3-.5.5-1 .5l.4-5 9-8.1c.4-.4-.1-.6-.6-.2L6.1 13.8 1.3 12.3c-1-.3-1-1 .2-1.5L20 3.7c.9-.3 1.7.2 1.7-.4z"/></svg>
                </a>
                <a class="social-link whatsapp" href="https://whatsapp.com/channel/0029VaI0L5MKrWR3io0kPv3k" target="_blank" rel="noopener" aria-label="WhatsApp">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 3.5A11.8 11.8 0 0 0 2 17.7L.5 23.5l5.9-1.5A11.8 11.8 0 0 0 20.5 3.5zM12 21a9 9 0 0 1-4.6-1.3l-.3-.2-3.5.9.9-3.4-.2-.4A9 9 0 1 1 12 21zm5-6.7c-.3-.1-1.7-.8-2-.9-.3-.1-.5-.1-.7.2-.2.3-.8.9-1 1.1-.2.2-.4.2-.7.1-2-.9-3.4-2.2-4.3-4.2-.2-.3 0-.5.1-.6l.5-.6.3-.5c.1-.2 0-.4 0-.6L8.3 6c-.2-.5-.5-.4-.7-.4H7c-.2 0-.6.1-.9.4-.3.4-1.2 1.2-1.2 2.9s1.2 3.3 1.4 3.5c.2.2 2.4 3.7 5.9 5.2.8.4 1.5.6 2 .7.8.3 1.6.2 2.2.1.7-.1 1.7-.7 1.9-1.4.2-.7.2-1.3.1-1.4-.1-.2-.4-.3-.7-.4z"/></svg>
                </a>
                <a class="social-link x-social" href="https://x.com/i/status/2076041680076320771" target="_blank" rel="noopener" aria-label="X">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18.9 2H22l-6.8 7.8L23 22h-6.1l-4.8-6.3L6.6 22H3.5l7.1-8.1L3 2h6.3l4.3 5.7L18.9 2zm-1.1 17.9h1.7L8.3 4H6.5l11.3 15.9z"/></svg>
                </a>
                <a class="social-link youtube" href="https://youtube.com/@revelationhourm?si=gyH5QweTg4264hK-" target="_blank" rel="noopener" aria-label="YouTube">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.6 12 3.6 12 3.6s-7.5 0-9.4.5A3 3 0 0 0 .5 6.2 31 31 0 0 0 0 12a31 31 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.1c1.9.5 9.4.5 9.4.5s7.5 0 9.4-.5a3 3 0 0 0 2.1-2.1A31 31 0 0 0 24 12a31 31 0 0 0-.5-5.8zM9.6 15.6V8.4L15.8 12l-6.2 3.6z"/></svg>
                </a>
                <a class="social-link tiktok" href="https://www.tiktok.com/@revelationhourm?_r=1&_t=ZS-97O8lEN8aQ6" target="_blank" rel="noopener" aria-label="TikTok">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15.5 2c.3 2.5 1.7 4 4.5 4.2v3.1a8.5 8.5 0 0 1-4.4-1.3v7.2a6.6 6.6 0 1 1-5.7-6.5v3.2a3.4 3.4 0 1 0 2.5 3.3V2h3.1z"/></svg>
                </a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        © {{ date('Y') }} Revelation Hour Ministries International. All rights reserved.
    </div>
</footer>
