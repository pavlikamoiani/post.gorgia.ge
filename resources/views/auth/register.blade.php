@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div  class="wrapper" style="width: 100vw; height: 100vh; display: flex; justify-content: center; align-items: center">
        <div class="container-reg">
            <img style="width: 100%; margin-bottom: 1rem" src="{{ asset('/logo.png') }}" />
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">სახელი და გვარი</label>
                    <input type="text" name="name" class="form-control" placeholder="ჩაწერე სახელი და გვარი" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">მეილი</label>
                    <input type="email" name="email" class="form-control" placeholder="ჩაწერე მეილი" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">პაროლი</label>
                    <input type="password" name="password" class="form-control" placeholder="ჩაწერე პაროლი" required>
                </div>
                <input name="role" value="waiting" type="hidden" />
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">გაიმეორე პაროლი</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="დაადასტურე პაროლი" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">დარეგისტრირება</button>
            </form>
            <p class="mt-3">უკვე გაქვს ანგარიში? <a href="{{ route('login.form') }}">შესვლა</a></p>
        </div>
    </div>
@endsection

<style>
    .container-reg {
        min-width: 300px;
        padding: 30px;
        max-width: 500px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    label {
        font-weight: bold;
    }

    @media screen and (max-width: 600px) {
        .container-reg {
            margin-bottom: 2rem;
            border-radius: 0;
        }
    }
</style>
