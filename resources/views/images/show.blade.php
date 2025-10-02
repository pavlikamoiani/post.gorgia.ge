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
        }
    </style>
@endsection
