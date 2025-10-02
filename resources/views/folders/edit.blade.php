@extends('layouts.app')

@section('title', 'ატვირთვა')

@section('content')
    <div style="padding-top: 2rem; width: 100vw; height: 100vh; display: flex; justify-content: center; align-items: center">
        <div class="container-reg">
            <form action="{{ route('folders.update', ['folder' => $folder]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label"><b>სახელი:</b></label>
                    <input type="text" name="name" class="form-control" value="{{ $folder->name }}">
                </div>
                <div class="mb-3">
                    <label for="barcode" class="form-label"><b>ლოკაცია:</b></label>
                    <select name="branch" class="form-control">
                        <option value="ყველა" {{ $folder->branch == 'ყველა' ? 'selected' : ''}}>ყველა</option>
                        <option value="დიდუბე" {{ $folder->branch == 'დიდუბე' ? 'selected' : ''}}>დიდუბე</option>
                        <option value="საბურთალო" {{ $folder->branch == 'საბურთალო' ? 'selected' : ''}}>საბურთალო</option>
                        <option value="ვაკე" {{ $folder->branch == 'ვაკე' ? 'selected' : ''}}>ვაკე</option>
                        <option value="ლილო" {{ $folder->branch == 'ლილო' ? 'selected' : ''}}>ლილო</option>
                        <option value="გლდანი" {{ $folder->branch == 'გლდანი' ? 'selected' : ''}}>გლდანი</option>
                        <option value="რუსთავი." {{ $folder->branch == 'რუსთავი' ? 'selected' : ''}}>რუსთავი</option>
                        <option value="ბათუმი" {{ $folder->branch == 'ბათუმი' ? 'selected' : ''}}>ბათუმი</option>
                        <option value="ქუთაისი" {{ $folder->branch == 'ქუთაისი' ? 'selected' : ''}}>ქუთაისი</option>
                        <option value="თელავი" {{ $folder->branch == 'თელავი' ? 'selected' : ''}}>თელავი</option>
                        <option value="ზუგდიდი" {{ $folder->branch == 'ზუგდიდი' ? 'selected' : ''}}>ზუგდიდი</option>
                        <option value="მარნეული" {{ $folder->branch == 'მარნეული' ? 'selected' : ''}}>მარნეული</option>
                        <option value="გორი" {{ $folder->branch == 'გორი' ? 'selected' : ''}}>გორი</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label"><b>პოსტის თარიღი:</b></label>
                    <input type="date" name="start_date" class="form-control" value="{{ $folder->start_date }}">
                </div>
                <button type="submit" class="btn btn-primary w-100">ატვირთვა <i class="fas fa-add" style="margin-right: 5px;"></i></button>
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
