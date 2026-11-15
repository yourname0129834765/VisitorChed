@extends('layouts.app')
@section('title', 'Register Visitor | VisitorCHED - Visitor Management System')
@section('content')
<section class="heading">
    <div>
        <p class="eyebrow">VISITOR MANAGEMENT</p>
        <h1>Register New Visitor</h1>
        <p class="muted">Enter the visitor's information below. Fields marked * are required.</p>
    </div>
</section>
<section class="card">
    <form action="{{ route('visitors.store') }}" method="POST">
        @csrf
        @include('visitors._form', ['visitor' => null])
        <div class="formactions">
            <button class="button" type="submit">Save Visitor</button>
            <a class="button secondary" href="{{ route('visitors.index') }}">Cancel</a>
        </div>
    </form>
</section>
@endsection
