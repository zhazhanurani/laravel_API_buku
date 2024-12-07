@extends('components.layout') <!-- Replace with your actual layout file path -->

@section('content')
<div class="container mt-4">
    <h1>All Reviews</h1>

    {{-- Form Filter --}}   
    <form method="GET" action="{{ route('list-review') }}" class="mb-4">
        @csrf
        <div class="form-group">
            <label for="tag">Tag:</label>
            <!-- Spinner (Dropdown) for selecting tag -->
            <select name="tag" id="tag" class="form-control">
                <option value="" disabled selected>Select a tag to filter</option>
                <option value="Petualangan" {{ request('tag') == 'Petualangan' ? 'selected' : '' }}>Petualangan</option>
                <option value="Epik" {{ request('tag') == 'Epik' ? 'selected' : '' }}>Epik</option>
                <option value="Karya klasik" {{ request('tag') == 'Karya klasik' ? 'selected' : '' }}>Karya klasik</option>
                <option value="Literatur fantasi ikonik" {{ request('tag') == 'Literatur fantasi ikonik' ? 'selected' : '' }}>Literatur fantasi ikonik</option>
            </select>
        </div>
    
        <div class="form-group">
            <label for="reviewer">Reviewer:</label>
            <input type="text" name="reviewer" id="reviewer" class="form-control" value="{{ request('reviewer') }}" placeholder="Enter reviewer name to filter">
        </div>
    
        <button type="submit" class="btn btn-primary mt-3">Filter</button>
    </form>
    


    <!-- Displaying Reviews -->
    @if($list_review->isEmpty())
        <p>No reviews have been made yet.</p>
    @else
        <div class="list-group">
            @foreach($list_review as $review)
                <div class="list-group-item mb-3">
                    <h3>{{ $review->book->title }}</h3>
                    <p><strong>Reviewer:</strong> {{ $review->user->name }}</p> <!-- Display reviewer name -->
                    <p><strong>Date Reviewed:</strong> {{ $review->created_at }}</p> <!-- Display reviewer name -->
                    <p>{{ $review->review ?? 'No review content provided.' }}</p>
                    <div>
                        <strong>Tags:</strong>
                        <ul>
                            @foreach($review->tag as $tg) <!-- Loop through tags -->
                                <li>{{ $tg }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection


