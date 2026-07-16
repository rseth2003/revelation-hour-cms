@extends('layouts.app')

@section('title', 'Revelation Hour Ministries International')

@section('content')
<section class="hero" id="home">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <p class="eyebrow">Word · Worth · Wonder</p>
        <h1>Welcome to Revelation Hour Ministries International</h1>
        <p>A place of worship, transformation, fellowship and the life-changing Word of God.</p>
        <div class="hero-actions">
            <a class="btn btn-primary" href="#services">View Service Times</a>
            <a class="btn btn-outline" href="#live-events">See Live Events</a>
        </div>
    </div>
</section>

<section class="section" id="services">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">Join Us</p>
            <h2>Weekly Service Schedule</h2>
            <p>There is a place for you in every gathering.</p>
        </div>
        <div class="service-grid">
            <article class="card"><span>Tuesday</span><h3>Bible Study Service</h3><p>6:00 PM – 8:00 PM</p></article>
            <article class="card"><span>Thursday</span><h3>MCS</h3><p>7:30 PM</p></article>
            <article class="card"><span>Friday</span><h3>Camp Meeting</h3><p>6:00 PM – 10:00 PM</p></article>
            <article class="card"><span>Sunday</span><h3>Business Service</h3><p>9:00 AM – 11:00 AM</p></article>
            <article class="card"><span>Sunday</span><h3>Sunday Service</h3><p>11:00 AM – 1:00 PM</p></article>
        </div>
    </div>
</section>

<section class="section section-soft" id="about">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">About Our Church</p>
            <h2>Revealing Christ, restoring lives</h2>
            <p>Revelation Hour Ministries International is a Christ-centred ministry committed to the Word of God, spiritual growth, prayer, worship and service to people.</p>
        </div>
        <div class="about-grid">
            <article class="about-card">
                <span class="about-number">01</span>
                <h3>Our Vision</h3>
                <p>To raise a transformed people who know Christ, live by His Word and reveal His glory in every sphere of life.</p>
            </article>
            <article class="about-card">
                <span class="about-number">02</span>
                <h3>Our Mission</h3>
                <p>To preach the Gospel, disciple believers, strengthen families and serve communities through the power and love of Jesus Christ.</p>
            </article>
            <article class="about-card">
                <span class="about-number">03</span>
                <h3>Our Foundation</h3>
                <p>We are built on prayer, biblical teaching, worship, fellowship, compassion and faithful Christian service.</p>
            </article>
        </div>
    </div>
</section>

<section class="section" id="welcome">
    <div class="container two-column welcome-grid">
        <div>
            <p class="eyebrow">Welcome Center</p>
            <h2>Come as you are and encounter God</h2>
            <p>Whether you are visiting for the first time, looking for a church family or seeking spiritual renewal, you are welcome at Revelation Hour Ministries International.</p>
            <p>Our desire is to help every person discover purpose, grow in faith and become firmly established in God’s Word.</p>
            <a class="text-link" href="#contact">Plan your visit →</a>
        </div>
        <div class="logo-panel">
            <img src="{{ asset('images/revelation-hour-logo.jpg') }}" alt="Revelation Hour Ministries International">
        </div>
    </div>
</section>

<section class="section section-blue" id="ministries">
    <div class="container">
        <div class="section-heading light">
            <p class="eyebrow">Ministries</p>
            <h2>Grow, serve and belong</h2>
            <p>Our ministry areas help people connect, mature spiritually and use their gifts in service.</p>
        </div>
        <div class="ministry-grid">
            <article class="feature-card"><div class="feature-icon">✦</div><h3>Prayer Ministry</h3><p>Standing in faith through intercession, prayer meetings and spiritual support.</p></article>
            <article class="feature-card"><div class="feature-icon">♫</div><h3>Worship Ministry</h3><p>Leading the church into heartfelt worship and a deeper encounter with God.</p></article>
            <article class="feature-card"><div class="feature-icon">✝</div><h3>Evangelism</h3><p>Sharing the Gospel and reaching people with the message of salvation.</p></article>
            <article class="feature-card"><div class="feature-icon">◎</div><h3>Youth Ministry</h3><p>Equipping young people to grow in faith, leadership and purpose.</p></article>
            <article class="feature-card"><div class="feature-icon">❤</div><h3>Women & Families</h3><p>Building strong homes and encouraging women in faith, fellowship and service.</p></article>
            <article class="feature-card"><div class="feature-icon">☀</div><h3>Community Outreach</h3><p>Demonstrating Christ’s love through compassion, practical help and outreach.</p></article>
        </div>
    </div>
</section>

<section class="section section-soft" id="live-events">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">What Is Happening Now</p>
            <h2>Live Events & Church Updates</h2>
            <p>View current event posters, ministry activities and special service announcements.</p>
        </div>

        <div class="event-carousel" data-event-carousel>
            <button class="carousel-control previous" type="button" aria-label="Previous event" data-carousel-previous>‹</button>
            <div class="event-track" data-event-track>
                <article class="event-slide active">
                    <img src="{{ asset('images/revelation-hour-logo.jpg') }}" alt="Revelation Hour Ministries International announcement">
                    <div class="event-caption"><strong>Welcome to Revelation Hour</strong><span>Official ministry updates will appear here.</span></div>
                </article>
                <article class="event-slide">
                    <div class="event-placeholder"><span>Upcoming Event Poster</span><small>Uploaded by an approved administrator</small></div>
                    <div class="event-caption"><strong>Special Services</strong><span>Stay connected for new announcements.</span></div>
                </article>
                <article class="event-slide">
                    <div class="event-placeholder"><span>Church Activity Gallery</span><small>Photos from services and outreach</small></div>
                    <div class="event-caption"><strong>Ministry in Action</strong><span>See what God is doing through the church.</span></div>
                </article>
            </div>
            <button class="carousel-control next" type="button" aria-label="Next event" data-carousel-next>›</button>
        </div>

        <div class="carousel-dots" data-carousel-dots></div>

        <aside class="local-admin-panel" data-local-admin-panel hidden>
            <h3>Local Admin Preview: Add an Event Image</h3>
            <p>This temporary local uploader is only shown when the page is opened with <code>?admin-preview=1</code>. The secure CMS uploader will replace it.</p>
            <form data-event-upload-form>
                <label>Event title<input type="text" name="title" maxlength="90" required></label>
                <label>Short description<input type="text" name="description" maxlength="140"></label>
                <label>Choose poster or photo<input type="file" name="image" accept="image/*" required></label>
                <button class="btn btn-primary" type="submit">Add To Local Preview</button>
            </form>
            <button class="clear-local-events" type="button" data-clear-local-events>Clear local uploads</button>
        </aside>
    </div>
</section>

<section class="section" id="word">
    <div class="container two-column word-section">
        <div>
            <p class="eyebrow">Daily Encouragement</p>
            <h2>Word of the Day</h2>
            <p>Approved administrators will publish a scripture, typed message, poster or audio devotion from the private CMS dashboard.</p>
            <p class="scripture">“Your word is a lamp to my feet and a light to my path.” — Psalm 119:105</p>
        </div>
        <div class="upload-preview">
            <div class="preview-icon">✦</div>
            <h3>Daily poster, message or audio</h3>
            <p>Managed securely from the private administration dashboard.</p>
        </div>
    </div>
</section>
@endsection
