{{-- This partial view receives a $lectures variable from the controller --}}
{{-- ⚠️ IMPORTANT: DO NOT include <script> or <style> tags here. They must be in the main index.blade.php ⚠️ --}}

@if(isset($lectures) && $lectures->count())
    <div class="table-responsive">
        <table class="table modern-table" style="width: 100%; border-collapse: collapse;">
            <caption
                style="text-align: left; font-size: 1.2rem; font-weight: 600; margin-bottom: 15px; color: var(--primary);">
                Total Lectures : {{ $lectures->count() }}</caption>
            <thead>
                <tr>
                    {{-- Updated: Replaced '#' with 'Lecture No' (Order) --}}
                    <th style="width: 10%;">Lecture No</th>
                    <th style="width: 35%;">Title</th>
                    <th style="width: 15%;">Type</th>
                    <th style="width: 25%;">Scheduled Time</th>
                    <th style="width: 20%; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lectures as $lecture)
                    <tr style="border-bottom: 1px solid #eee;">
                        {{-- Displaying the lecture's order/sequence value --}}
                        <td data-label="Order" style="font-weight: 700;"> {{ $lecture->order }} </td>
                        <td data-label="Title" style="font-weight: 500;">{{ $lecture->title }}</td>
                        <td data-label="Type">
                            @php
                                $badgeColor = $lecture->type === 'live' ? '#EF5350' : '#66BB6A'; 
                            @endphp
                            <span
                                style="padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600; color: #fff; background: {{ $badgeColor }};">
                                {{ ucfirst(str_replace('_', ' ', $lecture->type)) }}
                            </span>
                        </td>
                        <td data-label="Scheduled Time">
                            @if($lecture->live_scheduled_at)
                                {{ \Carbon\Carbon::parse($lecture->live_scheduled_at)->format('d M, Y h:i A') }}
                            @else
                                <span class="muted">N/A</span>
                            @endif
                        </td>
                        <td data-label="Actions" style="text-align: right;">
                            <div style="display: inline-flex; gap: 5px;">
                                <a href="{{ route('admin.lectures.edit', $lecture) }}" title="Edit Lecture"
                                    class="btn btn-icon btn-primary" style="padding: 6px 10px; border-radius: 4px;">
                                    <i class="fa fa-edit"></i>
                                </a>
                                {{-- Clean Delete Form: Relies entirely on global JS event delegation --}}
                                <form action="{{ route('admin.lectures.destroy', $lecture) }}" method="POST" class="deleteForm"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-icon btn-danger" type="submit" title="Delete Lecture"
                                        style="padding: 6px 10px; border-radius: 4px; cursor: pointer;">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <p class="alert info" style="text-align: center; border-left: 5px solid #2196F3; padding: 15px; margin-top: 20px;">
        <i class="fa fa-info-circle"></i> No lectures found for the selected course.
    </p>
@endif