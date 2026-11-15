@extends('layouts.app')
@section('title', 'Edit Visitor | VisitorCHED - Visitor Management System')
@section('content')
<section class="heading">
    <div>
        <p class="eyebrow">VISITOR MANAGEMENT</p>
        <h1>Edit Visitor</h1>
        <p class="muted">Update the information for {{ $visitor->first_name }} {{ $visitor->last_name }}.</p>
    </div>
</section>
<section class="card">
    <form action="{{ route('visitors.update', $visitor) }}" method="POST">
        @csrf
        @method('PUT')
        @include('visitors._form', ['visitor' => $visitor])
        <div class="formactions">
            <button class="button" type="submit">Save Changes</button>
            <a class="button secondary" href="{{ route('visitors.show', $visitor) }}">Cancel</a>
        </div>
    </form>
</section>
@endsection
