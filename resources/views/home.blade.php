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
            <a class="btn btn-outline" href="#contact">Connect With Us</a>
        </div>
    </div>
</section>

<section class="section" id="services">
    <div class="container">
        <div class="section-heading">
            <p class="eyebrow">Join Us</p>
            <h2>Weekly Service Schedule</h2>
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

<section class="section section-soft" id="welcome">
    <div class="container two-column">
        <div>
            <p class="eyebrow">Welcome Center</p>
            <h2>Come as you are and encounter God</h2>
            <p>Revelation Hour Ministries International is committed to sharing the Word, restoring worth and revealing the wonder of God through worship, prayer, discipleship and service.</p>
            <a class="text-link" href="#contact">Plan your visit →</a>
        </div>
        <div class="logo-panel">
            <img src="{{ asset('images/revelation-hour-logo.jpg') }}" alt="Revelation Hour Ministries International">
        </div>
    </div>
</section>

<section class="section" id="word">
    <div class="container two-column word-section">
        <div>
            <p class="eyebrow">Daily Encouragement</p>
            <h2>Word of the Day</h2>
            <p>This section will soon be connected to the CMS so approved administrators can publish a typed message, poster, scripture or audio devotion.</p>
            <p class="scripture">“Your word is a lamp to my feet and a light to my path.” — Psalm 119:105</p>
        </div>
        <div class="upload-preview">
            <div class="preview-icon">✦</div>
            <h3>Daily poster, message or audio</h3>
            <p>Managed securely from the private administration dashboard.</p>
        </div>
    </div>
</section>

<section class="section section-blue" id="ministries">
    <div class="container">
        <div class="section-heading light">
            <p class="eyebrow">Get Involved</p>
            <h2>Grow, serve and belong</h2>
        </div>
        <div class="three-grid">
            <article class="feature-card"><h3>Prayer & Worship</h3><p>Gather with us in prayer, praise and spiritual renewal.</p></article>
            <article class="feature-card"><h3>Discipleship</h3><p>Grow in Scripture through Bible study and meaningful fellowship.</p></article>
            <article class="feature-card"><h3>Community Outreach</h3><p>Share Christ’s love through practical service and compassion.</p></article>
        </div>
    </div>
</section>
@endsection
