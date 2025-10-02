@extends('layouts.app')

@section('title', 'ატვირთვა')

@section('content')
    <div style="width: 100vw; height: 100vh; display: flex; justify-content: center; align-items: center">
        <div class="container-reg">
            <h1>დაამატე ახალი</h1>
            <form action="{{ route('images.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{ $folder->id }}" name="folder_id"/>
                <div class="mb-3">
                    <label class="form-label"><b>ფოლდერი:</b></label>
                    <input type="text" class="form-control" disabled value="{{ $folder->name }}"  />
                </div>
                <div class="mb-3">
                    <label for="main_image" class="form-label"><b>ფოტოები:</b></label>
                    <input type="file" name="images[]" class="form-control" multiple required>
                </div>
{{--                <div class="mb-3">--}}
{{--                    <label for="secondary_image" class="form-label"><b>საფასურის ფოტო:</b></label>--}}
{{--                    <input type="file" name="secondary_image" class="form-control" required>--}}
{{--                </div>--}}
{{--                <div class="mb-3">--}}
{{--                    <label for="barcode" class="form-label"><b>ბარკოდი</b></label>--}}
{{--                    <input type="text" name="barcode" class="form-control" placeholder="123456789">--}}
{{--                </div>--}}
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
