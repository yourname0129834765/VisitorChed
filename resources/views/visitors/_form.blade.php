<div class="form-grid">
    <div class="form-group">
        <label for="visitor_number">Visitor Number <span aria-hidden="true">*</span></label>
        <input class="form-control" id="visitor_number" name="visitor_number" value="{{ old('visitor_number', $visitor?->visitor_number) }}" maxlength="50" required>
        @error('visitor_number') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="form-group">
        <label for="status">Status <span aria-hidden="true">*</span></label>
        <select class="form-control" id="status" name="status" required>
            <option value="Checked In" @selected(old('status', $visitor?->status ?? 'Checked In') === 'Checked In')>Checked In</option>
            <option value="Checked Out" @selected(old('status', $visitor?->status ?? 'Checked In') === 'Checked Out')>Checked Out</option>
        </select>
        @error('status') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="form-group">
        <label for="first_name">First Name <span aria-hidden="true">*</span></label>
        <input class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $visitor?->first_name) }}" maxlength="100" autocomplete="given-name" required>
        @error('first_name') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="form-group">
        <label for="last_name">Last Name <span aria-hidden="true">*</span></label>
        <input class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $visitor?->last_name) }}" maxlength="100" autocomplete="family-name" required>
        @error('last_name') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="form-group">
        <label for="contact_number">Contact Number</label>
        <input class="form-control" type="tel" id="contact_number" name="contact_number" value="{{ old('contact_number', $visitor?->contact_number) }}" maxlength="30" autocomplete="tel">
        @error('contact_number') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="form-group">
        <label for="department">Department <span aria-hidden="true">*</span></label>
        <input class="form-control" id="department" name="department" value="{{ old('department', $visitor?->department) }}" maxlength="150" required>
        @error('department') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="form-group">
        <label for="person_to_visit">Person to Visit <span aria-hidden="true">*</span></label>
        <input class="form-control" id="person_to_visit" name="person_to_visit" value="{{ old('person_to_visit', $visitor?->person_to_visit) }}" maxlength="150" required>
        @error('person_to_visit') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="form-group">
        <label for="visit_date">Visit Date <span aria-hidden="true">*</span></label>
        <input class="form-control" type="date" id="visit_date" name="visit_date" value="{{ old('visit_date', $visitor?->visit_date?->format('Y-m-d') ?? now()->toDateString()) }}" required>
        @error('visit_date') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="form-group">
        <label for="time_in">Time In <span aria-hidden="true">*</span></label>
        <input class="form-control" type="time" id="time_in" name="time_in" value="{{ old('time_in', $visitor?->time_in ? substr($visitor->time_in, 0, 5) : now()->format('H:i')) }}" required>
        @error('time_in') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="form-group">
        <label for="time_out">Time Out</label>
        <input class="form-control" type="time" id="time_out" name="time_out" value="{{ old('time_out', $visitor?->time_out ? substr($visitor->time_out, 0, 5) : '') }}">
        @error('time_out') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="form-group full">
        <label for="purpose_of_visit">Purpose of Visit <span aria-hidden="true">*</span></label>
        <textarea class="form-control" id="purpose_of_visit" name="purpose_of_visit" rows="3" maxlength="2000" required>{{ old('purpose_of_visit', $visitor?->purpose_of_visit) }}</textarea>
        @error('purpose_of_visit') <span class="field-error">{{ $message }}</span> @enderror
    </div>
    <div class="form-group full">
        <label for="address">Address</label>
        <textarea class="form-control" id="address" name="address" rows="3" maxlength="2000" autocomplete="street-address">{{ old('address', $visitor?->address) }}</textarea>
        @error('address') <span class="field-error">{{ $message }}</span> @enderror
    </div>
</div>
