@extends('layouts.app')

@section('title', 'ატვირთვა')

@section('content')
    <div style="padding-top: 2rem; width: 100vw; height: 100vh; display: flex; justify-content: center; align-items: center">
        <div class="container-reg" style="position:relative;">
            <a href="{{ route('images.show', $image->id) }}" class="btn btn-dark mob-hidden" style="position:absolute; top: 2px; left: -80px;"><i class="fas fa-arrow-left"></i></a>
            <form action="{{ route('images.update', ['id' => $image->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label"><b>ფოლდერი:</b></label>
                    <input type="text" class="form-control" disabled value="{{ $folder->name }}"  />
                </div>
                <div class="mb-3">
                    <label for="main_image" class="form-label"><b>შეცვალე მთავარი ფოტო:</b></label>
                    <img src="{{ asset('storage/' . $image->main_image) }}" class="img-fluid mb-3" style="max-width: 140px; max-height: 140px;" alt="Main Image">
                    <input type="file" name="main_image" class="form-control" >
                </div>
                <div class="mb-3">
                    <label for="secondary_image" class="form-label"><b>შეცვალე საფასურის ფოტო:</b></label>
                    <img src="{{ asset('storage/' . $image->secondary_image) }}" class="img-fluid mb-3" style="max-width: 140px; max-height: 140px;" alt="Main Image">
                    <input type="file" name="secondary_image" class="form-control" >
                </div>
                <div class="mb-3">
                    <label for="barcode" class="form-label"><b>შეცვალე ბარკოდი</b></label>
                    <input type="text" name="barcode" class="form-control" value="{{ $image->barcode }}">
                </div>
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-upload" style="margin-right: 5px;"></i>ატვირთვა</button>
            </form>
        </div>
    </div>

    <style>
        .container-reg {
            min-width: 300px;
            padding: 20px;
            max-width: 500px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
    </style>
@endsection
