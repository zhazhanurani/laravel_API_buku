@extends('components.layout') <!-- Replace with your actual layout file path -->

@section('content')
<div class="container mt-4">
    <h1>All Reviews</h1>

    @if($list_review->isEmpty())
        <p>No reviews have been made yet.</p>
    @else
        <div class="list-group">
            @foreach($list_review as $review)
                <div class="list-group-item mb-3">
                    <h3>{{ $review->book->title }}</h3>
                    <p>{{ $review->review ?? 'No review content provided.' }}</p>
                    <div>
                        <strong>Tags:</strong>
                        <ul>
                            @foreach($review->tag as $tg)
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


