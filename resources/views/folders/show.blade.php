@extends('layouts.app')

@section('title', 'მთავარი')

@section('content')
    @if (Auth::user()->role !== 'waiting')

    <div  style="margin-top: 5rem; position:relative;">
        <h3 class="main-text text-center">{{ $folder->name }} | {{ $folder->branch }} | {{ $folder->start_date }} | შექმნილია {{ $folder->user->name }}-ს მიერ - {{ $folder->user->email }} <a href="{{ route("images.upload", ['folderId' => $folder->id]) }}" class="btn btn-outline-primary" style="margin-left: 5px;">ფოტო <i class="fas fa-add"></i></a></h3>
        <a href="{{ route('dashboard') }}" class="btn btn-dark mob-hidden" style="position:absolute; top: 0; left: 10px;"><i class="fas fa-arrow-left"></i></a>
    </div>
    <div style="width: 100%; margin-top: 1.5rem;">

        <div  style="margin-left: 1rem; margin-right: auto">
            <div style="width: 100%; margin-top: 1.5rem;">
                <div class="row main" style="margin-left: 1rem; margin-right: auto">
                    @include('folders.partials.images', ['images' => $images])
                </div>
                <div class="loader" style="text-align: center; display: none;">
                    <p>Loading...</p>
                </div>
            </div>
        </div>
    </div>
        @endif

        {{-- Folder Comments Section --}}
<div class="container mt-4 mb-5" style="padding-bottom: 5rem;">
    <h5 class="mb-4" style="font-weight: bold; color: #333;">ფოლდერის კომენტარები</h5>
    @auth
    <form action="{{ route('comments.store', ['type' => 'folders', 'id' => $folder->id]) }}" method="POST" class="mb-4 comment-form">
        @csrf
        <div class="d-flex align-items-start">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff" class="rounded-circle me-2" width="40" height="40" alt="avatar">
            <textarea name="body" class="form-control" rows="2" placeholder="დაწერეთ კომენტარი..." required style="resize:none;"></textarea>
        </div>
        <button class="btn btn-primary mt-2 float-start" type="submit" style="padding: 0.4rem 1.5rem; margin-left: 4%;">დამატება</button>
        <div class="clearfix"></div>
    </form>
    @endauth

    <div>
        @foreach($folder->comments as $comment)
            <div class="comment-card mb-3 p-3 rounded shadow-sm" style="background: #f9f9fb;">
                <div class="d-flex align-items-center mb-2">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background=6c757d&color=fff" class="rounded-circle me-2" width="36" height="36" alt="avatar">
                    <div>
                        <strong style="color:#2c3e50;">{{ $comment->user->name }}</strong>
                        <small class="text-muted ms-2">{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                <div class="ps-1" style="font-size: 1.05rem;">{{ $comment->body }}</div>
                <div class="mt-2">
                    @auth
                    <a href="#" class="reply-link" onclick="event.preventDefault(); document.getElementById('reply-form-folder-{{ $comment->id }}').style.display='block';" style="text-decoration: none;">პასუხი</a>
                    <form id="reply-form-folder-{{ $comment->id }}" action="{{ route('comments.store', ['type' => 'folders', 'id' => $folder->id]) }}" method="POST" class="mt-2" style="display:none;">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <div class="d-flex align-items-start">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff" class="rounded-circle me-2" width="32" height="32" alt="avatar">
                            <textarea name="body" class="form-control" rows="1" placeholder="პასუხი..." required style="resize:none;"></textarea>
                        </div>
                        <button class="btn btn-sm btn-outline-primary mt-2 float-end" type="submit">პასუხი</button>
                        <div class="clearfix"></div>
                    </form>
                    @endauth
                </div>
                {{-- Replies --}}
                @foreach($comment->replies as $reply)
                    <div class="reply-card mt-3 ms-4 p-2 rounded" style="background:#eef2f7;">
                        <div class="d-flex align-items-center mb-1">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->user->name) }}&background=adb5bd&color=fff" class="rounded-circle me-2" width="30" height="30" alt="avatar">
                            <div>
                                <strong style="color:#495057;">{{ $reply->user->name }}</strong>
                                <small class="text-muted ms-2">{{ $reply->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <div class="ps-1" style="font-size: 0.98rem;">{{ $reply->body }}</div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>




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

            .btn-dark {
                display: none;
            }

            .main-text {

            }
        }
    </style>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let page = 1;

    $(window).on('scroll', function () {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
            page++;
            loadMoreImages(page);
        }
    });

    function loadMoreImages(page) {
        $.ajax({
            url: '?page=' + page,
            type: 'get',
            beforeSend: function () {
                $('.loader').show(); // Show a loader if needed
            }
        })
            .done(function (data) {
                if (data.html === "") {
                    return;
                }
                $('.main').append(data);
            })
            .fail(function () {
                alert('Failed to load images.');
            });
    }

    function initializeLazyLoad() {
        const imageCards = document.querySelectorAll('.image-card');
        imageCards.forEach(card => {
            card.addEventListener('mouseenter', function () {
                const backImage = this.querySelector('.lazy-back');
                if (backImage && !backImage.src) {
                    backImage.src = backImage.dataset.src;
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', initializeLazyLoad);

    document.addEventListener('scroll', function () {
        initializeLazyLoad();
    });


</script>

