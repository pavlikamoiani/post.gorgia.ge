@extends('layouts.app')

@section('title', 'ატვირთვა')

@section('content')
    <div style="padding-top: 2rem; width: 100vw; height: 100vh; display: flex; justify-content: center; align-items: center">
        <div class="container-reg">
            <form action="{{ route('folders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label"><b>სახელი:</b></label>
                    <input type="text" name="name" class="form-control" placeholder="">
                </div>
                <div class="mb-3">
                    <label for="branch" class="form-label"><b>ლოკაცია:</b></label>
                    <select name="branch" class="form-control">
                        <option value="ყველა">ყველა</option>
                        <option value="დიდუბე">დიდუბე</option>
                        <option value="საბურთალო">საბურთალო</option>
                        <option value="გლდანი">გლდანი</option>
                        <option value="ვაკე">ვაკე</option>
                        <option value="ლილო">ლილო</option>
                        <option value="რუსთავი">რუსთავი</option>
                        <option value="ბათუმი">ბათუმი</option>
                        <option value="ქუთაისი">ქუთაისი</option>
                        <option value="თელავი">თელავი</option>
                        <option value="ზუგდიდი">ზუგდიდი</option>
                        <option value="მარნეული">მარნეული</option>
                        <option value="გორი">გორი</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label"><b>პოსტის თარიღი:</b></label>
                    <input type="date" name="start_date" class="form-control" placeholder="">
                </div>
                <button type="submit" class="btn btn-primary w-100">დამატება <i class="fas fa-add" style="margin-right: 5px;"></i></button>
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
