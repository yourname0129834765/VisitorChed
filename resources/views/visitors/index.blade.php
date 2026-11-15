@extends('layouts.app')
@section('title', 'Visitor Records | VisitorCHED - Visitor Management System')
@section('content')
<section class="heading">
    <div>
        <p class="eyebrow">VISITOR MANAGEMENT</p>
        <h1>Visitor Records</h1>
        <p class="muted">Manage registered visitors and their visits.</p>
    </div>
    <a class="button" href="{{ route('visitors.create') }}">+ Register New Visitor</a>
</section>

<section class="stats">
    <div class="card">
        <span class="muted">Total Registered Visitors</span>
        <strong class="total">{{ number_format($totalVisitors) }}</strong>
    </div>
</section>

<section class="card">
    <div class="sectionhead">
        <div>
            <h2>All Visitors</h2>
            <p class="muted">Search by visitor number, name, contact, visit purpose, or department.</p>
        </div>
    </div>
    <form class="search-form" method="GET" action="{{ route('visitors.index') }}">
        <input type="search" name="search" value="{{ $search }}" placeholder="Search visitor number, name, contact, purpose, or department..." aria-label="Search visitors">
        <button class="button" type="submit">Search</button>
        @if ($search !== '')
            <a class="button secondary" href="{{ route('visitors.index') }}">Clear</a>
        @endif
    </form>

    <div class="tablewrap">
        <table>
            <thead>
                <tr>
                    <th>Visitor No.</th>
                    <th>Full Name</th>
                    <th>Purpose of Visit</th>
                    <th>Person to Visit</th>
                    <th>Department</th>
                    <th>Visit Date</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($visitors as $visitor)
                    <tr>
                        <td><b>{{ $visitor->visitor_number }}</b></td>
                        <td>{{ $visitor->last_name }}, {{ $visitor->first_name }}</td>
                        <td>{{ $visitor->purpose_of_visit ?: '—' }}</td>
                        <td>{{ $visitor->person_to_visit ?: '—' }}</td>
                        <td>{{ $visitor->department ?: '—' }}</td>
                        <td>{{ $visitor->visit_date?->format('M d, Y') ?? '—' }}</td>
                        <td>{{ $visitor->time_in ? substr($visitor->time_in, 0, 5) : '—' }}</td>
                        <td>{{ $visitor->time_out ? substr($visitor->time_out, 0, 5) : '—' }}</td>
                        <td>{{ $visitor->status }}</td>
                        <td>
                            <div class="actions">
                                <a class="action-btn view-btn" href="{{ route('visitors.show', $visitor) }}">View</a>
                                <a class="action-btn edit-btn" href="{{ route('visitors.edit', $visitor) }}">Edit</a>
                                <form class="inline-form" action="{{ route('visitors.destroy', $visitor) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this visitor record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="action-btn delete-btn" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="10" class="empty-state">
                        {{ $search !== '' ? 'No visitor records match your search.' : 'No visitor records yet. Select “Register New Visitor” to add one.' }}
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="tablefooter">
        <span>
            @if ($visitors->total() > 0)
                Showing {{ $visitors->firstItem() }}–{{ $visitors->lastItem() }} of {{ $visitors->total() }} matching records
            @else
                Showing 0 records
            @endif
        </span>
        <div class="pagination">{{ $visitors->links() }}</div>
    </div>
</section>
@endsection
