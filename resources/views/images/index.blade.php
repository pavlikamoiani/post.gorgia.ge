@extends('layouts.app')

@section('title', 'მთავარი')

@section('content')
    <h1 class="text-center" style="margin-top: 4rem;">ფოლდერები</h1>
    @if (Auth::user()->role !== 'waiting')
        <div style="width: 100%;">
            <div class="row main" style="margin-left: 1rem; margin-right: auto">
                @foreach($images as $image)
                    <div style="padding:0; margin-right: 1rem; box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px; position:relative; width: 300px; margin-bottom: 1.5rem; border-radius: 1rem;">
                        <a href="{{ route('images.show', $image->id) }}" class="image-card" style="border-radius: 1rem;">
                            <div class="image-container">
                                <div class="card-face card-face-front">
                                    <img class="card-img-top" src="{{ asset('storage/' . $image->main_image) }}" alt="Main Image">
                                </div>
                                <div class="card-face card-face-back">
                                    <img class="card-img-top" src="{{ asset('storage/' . $image->secondary_image) }}" alt="Secondary Image">
                                </div>
                            </div>
                        </a>
                        <h5 class="card-body" style="width: 100%; z-index: 10; text-align: center">
                            {{ $image->barcode }}
                        </h5>
                    </div>
                @endforeach
            </div>
    </div>
        @endif

    <style>
        .image-card {
            text-decoration: none;
            display: block;
            background-color: #fff;
            max-width: 100%;
            height: 400px;
            position: relative;
            overflow: hidden;
        }

        .image-container {
            position: relative;
            transition: transform 0.6s; /* Smooth transition for flipping */
            transform-style: preserve-3d; /* Preserve 3D effects for child elements */
        }

        .card-face {
            position: absolute;
            width: 100%;
            backface-visibility: hidden; /* Hide the back face when not flipped */
            top: 0;
            left: 0;
        }

        .card-face-front {
            z-index: 2; /* Place front face above back face */
        }

        .card-face-back {
            transform: rotateY(180deg); /* Rotate back face to be hidden */
        }

        .image-card:hover .image-container {
            transform: rotateY(180deg); /* Flip the image container on hover */
        }

        img.card-img-top {
            width: 100%;
            height: 350px; /* Set height for images */
            object-fit: cover; /* Ensure images cover the container */
        }

        .card-body {
            position: absolute;
            bottom: 0;
        }

        .main {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Creates a responsive grid */
            gap: 1rem; /* Space between grid items */
            margin: 0 auto; /* Center the main container */
        }

        @media screen and (max-width: 600px) {
            .wrapper {
                flex-direction: column;
            }

            .main {
                display: flex;
                justify-content: center;
            }
        }
    </style>
@endsection
