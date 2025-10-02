<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My App')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" crossorigin="anonymous">
    <style>
        @font-face {
            font-family: 'FiraGO';
            src: url('{{ asset('fonts/FiraGO-Regular.otf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: 'FiraGO', Arial, sans-serif;
            background-color: #ededed; /* Gradient background */
            height: 100vh;
        }
        header {
            position: absolute;
            width: 100%;
            top:0;
        }

        nav {
            background-color: rgba(255, 255, 255, 0.97); /* Semi-transparent background */
        }
        nav a {
            color: #007bff;
        }
        nav a:hover {
            text-decoration: underline;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #fff; /* Background color for the footer */
            color: #707070; /* Text color */
            text-align: center; /* Center the text */
            padding-top: 10px; /* Add some padding to the top and bottom */
        }

        footer h5 {
            margin: 0;
            font-weight: normal; /* Adjust the weight of the text if needed */
        }

        footer i {
            background-color: #480000;
            border-radius: 50%;
            color: yellow; /* Color for the smile icon */
        }

    </style>
</head>
<body>
    @auth
        <header style="z-index: 10">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid" >
                    <a class="navbar-brand" href="{{ route('dashboard') }}">აქციები</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto">
                            @if (Auth::user()->role !== 'waiting')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">მთავარი</a>
                            </li>
                            @if (Auth::user()->role !== 'viewer')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('folders.create') }}">ფოლდერის დამატება</a>
                                </li>
                            @endif
                            @if (Auth::user()->role === 'admin')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.index') }}">ადმინი</a>
                                </li>
                            @endif
                        </ul>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-dark"><i class="fas fa-sign-out-alt" style="margin-right: "></i>გამოსვლა</button>
                        </form>
                    </div>
                </div>
            </nav>
        </header>
    @endauth

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <footer>
        <h6>© 2024 GORGIA. Powered BY: <i class="fas fa-smile"></i> Saba Dumbadze</h6>
    </footer>
    @yield('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
    <script>
        var dateInputs = document.querySelectorAll('input[type="date"]');
        dateInputs.forEach(function(dateInput) {
            dateInput.addEventListener('click', function() {
                this.showPicker();
            });
        });
    </script>
</body>
</html>
