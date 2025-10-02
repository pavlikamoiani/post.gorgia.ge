@extends('layouts.app')

@section('title', 'შესვლა')

@section('content')
    <div style="width: 100vw; height: 100vh; display: flex; justify-content: center; align-items: center">
        <div class="container-reg">
            <img style="width: 100%; margin-bottom: 1rem" src="{{ asset('/logo.png') }}" />
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">მეილი:</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="შეიყვანე მეილი" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">პაროლი:</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="შეიყვანე პაროლი" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">შესვლა</button>
            </form>
            <p class="mt-3 text-center">არ გაქვს ანგარიში? <a href="{{ route('register.form') }}" class="text-primary">რეგისტრაცია</a></p>
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
            border-radius: 0;
        }
    }
</style>
