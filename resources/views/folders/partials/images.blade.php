@foreach($images as $image)
    <div style="padding:0; margin-right: 1rem; box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px; position:relative; width: 300px; margin-bottom: 1.5rem; border-radius: 1rem;">
        <a href="{{ route('images.show', ['id' => $image->id]) }}" class="image-card" style="border-radius: 1rem;">
            <div class="image-container">
                <div class="card-face card-face-front">
                    <img class="card-img-top" src="{{ asset('storage/' . $image->main_image) }}" alt="Main Image">
                </div>
                <div class="card-face card-face-back">
                    <img class="card-img-top lazy-back" data-src="{{ asset('storage/' . $image->secondary_image) }}" alt="Secondary Image">
                </div>
            </div>
        </a>
        <h5 class="card-body" style="width: 100%; z-index: 10; text-align: center">
            {{ $image->barcode }}
        </h5>
    </div>
@endforeach
