@extends('layouts.app')

@section('title', 'Image Details')

@section('content')
    <div class="" style="margin-top: 5rem; padding-bottom: 3rem;">
        <div class="breadcrumbs" style="display: flex; justify-content: center; margin-bottom: 1rem;">
            <a href="{{ route('folders.show', $folder->id) }}" class="btn btn-dark mob-hidden" style="position:absolute; left: 10px;"><i class="fas fa-arrow-left"></i></a>
            <div>
                <a href="{{ asset('storage/' . $image->main_image) }}" class="btn btn-success download-main" style="margin-right: 20px;" download><i class="fas fa-download" style="margin-right: 5px"></i>მთავარი</a>
            </div>

            <div style="margin-top: 5px">
                დამატებულია {{ $image->user->name }}-ს მიერ - {{ $image->user->email }}
            </div>

            <div>
                <a href="{{ asset('storage/' . $image->secondary_image) }}" class="btn btn-success download-secondary" style="margin-left: 20px;" download><i class="fas fa-download" style="margin-right: 5px"></i>საფასური</a>
            </div>
            <div class="actions">
                @if (Auth::user()->role !== 'viewer')
                    <a href="{{ route('images.edit', ['id' => $image->id, 'folderId' => $folder->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                @endif
                @if (Auth::user()->role === 'admin')
                    <form action="{{ route('images.destroy', $image->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this image?');" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                @endif
            </div>
        </div>

        <div class="wrapper" style="display: flex; justify-content: space-between;">
            <div class="image-div">
                <h5>მთავარი ფოტო:</h5>
                <img src="{{ asset('storage/' . $image->main_image) }}" class="img-fluid mb-3" alt="Main Image">
            </div>
            <div class="image-div">
                <h5>საფასურის ფოტო:</h5>
                <img src="{{ asset('storage/' . $image->secondary_image) }}" class="img-fluid" alt="Secondary Image">
                <form class="form" action="{{ route('images.barcode', ['id' => $image->id]) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <div style="display: flex; margin-top: 1rem">
                            <input type="text" class="form-control" style="margin-right: 5px;" name="barcode" autocomplete="off" placeholder="ბარკოდი" value="{{ $image->barcode }}"  />
                            <button class="btn btn-outline-primary" type="submit"><i class="fas fa-save"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Comments Section --}}
    <div class="container mt-4 mb-5" style="padding-bottom: 5rem;">
        <h5 class="mb-4" style="font-weight: bold; color: #333;">კომენტარები</h5>
        @auth
        <form action="{{ route('comments.store', $image->id) }}" method="POST" class="mb-4 comment-form">
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
            @foreach($image->comments as $comment)
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
                        <a href="#" class="reply-link" onclick="event.preventDefault(); document.getElementById('reply-form-{{ $comment->id }}').style.display='block';">პასუხი</a>
                        <form id="reply-form-{{ $comment->id }}" action="{{ route('comments.store', $image->id) }}" method="POST" class="mt-2" style="display:none;">
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
    .image-div {
        width: 49%;
    }

    .wrapper {
        padding: 10px;
    }

    .actions {
        position: absolute;
        right: 15px;
    }

    .ml-4 { margin-left: 1.5rem; }

    .comment-card {
        transition: box-shadow 0.2s;
        border: 1px solid #ececec;
    }
    .comment-card:hover {
        box-shadow: 0 2px 12px 0 rgba(44,62,80,0.08);
        border-color: #d1e7fd;
    }
    .reply-card {
        border-left: 3px solid #0d6efd;
        background: #f4f8fb !important;
    }
    .reply-link {
        color: #0d6efd;
        font-size: 0.97rem;
        text-decoration: none;
        cursor: pointer;
        transition: color 0.2s;
    }
    .reply-link:hover {
        color: #084298;
        text-decoration: underline;
    }
    .comment-form textarea:focus,
    .comment-card textarea:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13,110,253,.15);
    }

    @media screen and (max-width: 600px) {
        .wrapper {
            flex-direction: column;
        }

        .breadcrumbs {
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .breadcrumbs h4 {
            transform: translateX(-10%);
        }

        .download-main, .download-secondary {
            margin: 10px 10px !important;
        }

        .actions {
            right: 10px;
            top: 10px;
        }

        .image-div {
            width: 100%;
        }

        .form {
            margin-left: 10px;
            margin-right: 10px;
            max-height: 40px;
        }

        .mob-hidden {
            display: none;
        }

        .comment-card, .reply-card {
            padding: 1rem 0.5rem !important;
        }
        .reply-card {
            margin-left: 0.5rem !important;
        }
    }
</style>
@endsection
