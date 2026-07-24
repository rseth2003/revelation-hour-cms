@extends('layouts.app')

@section('title', 'Register for '.$event->title.' | Revelation Hour Ministries International')

@section('content')
<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Event Registration</p>
        <h1>{{ $event->title }}</h1>
        <p>
            @if($event->event_date)
                {{ $event->event_date->format('D, j M Y • g:i A') }}
            @endif
            @if($event->location)
                @if($event->event_date) · @endif {{ $event->location }}
            @endif
        </p>
    </div>
</section>

<section class="section">
    <div class="container" style="max-width:1050px;">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:2rem;align-items:start;">
            @if($event->poster_url)
                <aside style="background:#fff;border:1px solid #e2e8f0;border-radius:1.25rem;overflow:hidden;box-shadow:0 12px 30px rgba(15,23,42,.06);">
                    <img src="{{ $event->poster_url }}"
                         alt="{{ $event->title }}"
                         style="display:block;width:100%;height:auto;object-fit:cover;">
                    <div style="padding:1.25rem;">
                        <h2 style="margin:0 0 .5rem;">{{ $event->title }}</h2>
                        @if($event->description)
                            <p style="margin:0;">{{ $event->description }}</p>
                        @endif
                    </div>
                </aside>
            @endif

            <div style="background:#fff;border:1px solid #e2e8f0;border-radius:1.25rem;padding:clamp(1.25rem,4vw,2.5rem);box-shadow:0 12px 30px rgba(15,23,42,.06);">
                <h2 style="margin-top:0;">Reserve your place</h2>
                <p>Your registration will be sent to the RHMI team for confirmation.</p>

                @if($errors->any())
                    <div style="margin:1rem 0;border:1px solid #fecaca;background:#fef2f2;color:#991b1b;border-radius:.75rem;padding:1rem;">
                        <strong>Please correct the highlighted information.</strong>
                        <ul style="margin:.5rem 0 0 1.25rem;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('event-registration.store', $event) }}" style="margin-top:1.5rem;">
                    @csrf

                    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem;">
                        <div>
                            <label for="full_name" style="display:block;font-weight:700;margin-bottom:.4rem;">Full name *</label>
                            <input id="full_name" name="full_name" type="text" required value="{{ old('full_name') }}"
                                   style="width:100%;border:1px solid #cbd5e1;border-radius:.75rem;padding:.85rem;">
                        </div>

                        <div>
                            <label for="phone" style="display:block;font-weight:700;margin-bottom:.4rem;">Phone number *</label>
                            <input id="phone" name="phone" type="tel" required value="{{ old('phone') }}"
                                   style="width:100%;border:1px solid #cbd5e1;border-radius:.75rem;padding:.85rem;">
                        </div>

                        <div>
                            <label for="email" style="display:block;font-weight:700;margin-bottom:.4rem;">Email address</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}"
                                   style="width:100%;border:1px solid #cbd5e1;border-radius:.75rem;padding:.85rem;">
                        </div>

                        <div>
                            <label for="registration_type" style="display:block;font-weight:700;margin-bottom:.4rem;">I am a *</label>
                            <select id="registration_type" name="registration_type" required
                                    style="width:100%;border:1px solid #cbd5e1;border-radius:.75rem;padding:.85rem;background:#fff;">
                                <option value="visitor" @selected(old('registration_type', 'visitor') === 'visitor')>Visitor</option>
                                <option value="member" @selected(old('registration_type') === 'member')>RHMI Member</option>
                            </select>
                        </div>

                        <div>
                            <label for="campus_id" style="display:block;font-weight:700;margin-bottom:.4rem;">Campus</label>
                            <select id="campus_id" name="campus_id"
                                    style="width:100%;border:1px solid #cbd5e1;border-radius:.75rem;padding:.85rem;background:#fff;">
                                <option value="">Select campus (optional)</option>
                                @foreach($campuses as $campus)
                                    <option value="{{ $campus->id }}" @selected((string) old('campus_id') === (string) $campus->id)>
                                        {{ $campus->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div style="margin-top:1rem;">
                        <label for="notes" style="display:block;font-weight:700;margin-bottom:.4rem;">Notes</label>
                        <textarea id="notes" name="notes" rows="4"
                                  placeholder="Optional accessibility needs or other information"
                                  style="width:100%;border:1px solid #cbd5e1;border-radius:.75rem;padding:.85rem;">{{ old('notes') }}</textarea>
                    </div>

                    <div style="display:flex;flex-wrap:wrap;gap:.75rem;margin-top:1.5rem;">
                        <button type="submit" class="btn btn-primary">Submit Registration</button>
                        <a href="{{ route('events') }}" class="btn btn-outline">Back to Events</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
