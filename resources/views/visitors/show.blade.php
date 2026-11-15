@extends('layouts.app')
@section('title', 'Visitor Details | VisitorCHED - Visitor Management System')
@section('content')
<section class="heading">
    <div>
        <p class="eyebrow">VISITOR MANAGEMENT</p>
        <h1>Visitor Details</h1>
        <p class="muted">Visitor No. {{ $visitor->visitor_number }}</p>
    </div>
    <a class="button secondary" href="{{ route('visitors.index') }}">Back to Visitor Records</a>
</section>
<section class="card">
    <div class="sectionhead"><h2>Visitor Information</h2></div>
    <dl class="details">
        <div><dt>Visitor Number</dt><dd>{{ $visitor->visitor_number }}</dd></div>
        <div><dt>Full Name</dt><dd>{{ $visitor->last_name }}, {{ $visitor->first_name }}</dd></div>
        <div><dt>Contact Number</dt><dd>{{ $visitor->contact_number ?: 'Not provided' }}</dd></div>
        <div><dt>Address</dt><dd>{{ $visitor->address ?: 'Not provided' }}</dd></div>
        <div><dt>Purpose of Visit</dt><dd>{{ $visitor->purpose_of_visit ?: 'Not provided' }}</dd></div>
        <div><dt>Person to Visit</dt><dd>{{ $visitor->person_to_visit ?: 'Not provided' }}</dd></div>
        <div><dt>Department</dt><dd>{{ $visitor->department ?: 'Not provided' }}</dd></div>
        <div><dt>Visit Date</dt><dd>{{ $visitor->visit_date?->format('F d, Y') ?? '—' }}</dd></div>
        <div><dt>Time In</dt><dd>{{ $visitor->time_in ? substr($visitor->time_in, 0, 5) : '—' }}</dd></div>
        <div><dt>Time Out</dt><dd>{{ $visitor->time_out ? substr($visitor->time_out, 0, 5) : '—' }}</dd></div>
        <div><dt>Status</dt><dd>{{ $visitor->status ?: '—' }}</dd></div>
        <div><dt>Date Registered</dt><dd>{{ $visitor->created_at?->format('F d, Y h:i A') ?? '—' }}</dd></div>
        <div><dt>Last Updated</dt><dd>{{ $visitor->updated_at?->format('F d, Y h:i A') ?? '—' }}</dd></div>
    </dl>
    <div class="formactions">
        <a class="button" href="{{ route('visitors.edit', $visitor) }}">Edit Visitor</a>
        <form class="inline-form" action="{{ route('visitors.destroy', $visitor) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this visitor record?');">
            @csrf
            @method('DELETE')
            <button class="button danger" type="submit">Delete Visitor</button>
        </form>
        <a class="button secondary" href="{{ route('visitors.index') }}">Back to Records</a>
    </div>
</section>
@endsection
