@extends('layouts.app')

@section('title', 'მთავარი')

@section('content')
    @if (Auth::user()->role !== 'waiting')
        <h4 class="text-center" style="margin-top: 4rem;">ფოლდერები</h4>
    <form method="GET" action="{{ route('dashboard') }}" class="filter-form">
        <div class="filters">
            <div class="flex-col" style="margin-right: 1rem;">
                <label for="name">სათაური:</label>
                <input type="text" placeholder="ფოლდერის სახელი" id="name" name="name" class="form-control" value="{{ request('name') }}">
            </div>
            <div class="flex-col" style="margin-right: 1rem;">
                <label for="date">თარიღი:</label>
                <input type="date" id="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div style="margin-right: 1rem">
                <label>ფილიალი:</label>
                <select name="branch" class="form-control">
                    <option value="">აირჩიე ფილიალი</option>
                    <option value="ყველა">ყველა</option>
                    <option value="დიდუბე" {{ request('branch') === 'დიდუბე' ? 'selected' : '' }}>დიდუბე</option>
                    <option value="საბურთალო" {{ request('branch') === 'საბურთალო' ? 'selected' : '' }}>საბურთალო</option>
                    <option value="ვაკე" {{ request('branch') === 'ვაკე' ? 'selected' : '' }}>ვაკე</option>
                    <option value="ლილო" {{ request('branch') === 'ლილო' ? 'selected' : '' }}>ლილო</option>
                    <option value="გლდანი" {{ request('branch') === 'გლდანი' ? 'selected' : '' }}>გლდანი</option>
                    <option value="რუსთავი" {{ request('branch') === 'რუსთავი' ? 'selected' : '' }}>რუსთავი</option>
                    <option value="ბათუმი" {{ request('branch') === 'ბათუმი' ? 'selected' : '' }}>ბათუმი</option>
                    <option value="ქუთაისი" {{ request('branch') === 'ქუთაისი' ? 'selected' : '' }}>ქუთაისი</option>
                    <option value="თელავი" {{ request('branch') === 'თელავი' ? 'selected' : '' }}>თელავი</option>
                    <option value="ზუგდიდი" {{ request('branch') === 'ზუგდიდი' ? 'selected' : '' }}>ზუგდიდი</option>
                    <option value="მარნეული" {{ request('branch') === 'მარნეული' ? 'selected' : '' }}>მარნეული</option>
                    <option value="გორი" {{ request('branch') === 'გორი' ? 'selected' : '' }}>გორი</option>
                </select>
            </div>
            <div class="filter-buttons mt-4">
                <button type="submit" class="btn btn-primary "><i class="fa fa-filter"></i></button>
                <a href="{{ route('dashboard') }}" class="btn btn-danger">
                    <i class="fa fa-trash"></i>
                </a>
            </div>
        </div>
    </form>
    <div style="width: 100%; margin-top: 1rem;">
        <div class="row main" style="margin-left: 1rem; margin-right: auto">
            @foreach($folders as $folder)
                <div class="card" style="position: relative; padding:0; margin-right: 1rem; box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px; position:relative; width: 300px; margin-bottom: 1.5rem; border-radius: 1rem;">
                    @if (Auth::user()->role !== 'viewer')
                    <a class="btn btn-primary visible-on-hover" style="position: absolute; z-index: 10; left: 4px; top: 4px" href="{{ route('folders.edit', $folder) }}"><i class="fas fa-edit"></i></a>
                    <form class="visible-on-hover" style="position: absolute; z-index: 10; right: 4px; top: 4px;" action="{{ route('folders.destroy', $folder->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this folder?');">
                            <i style="z-index: 11;" class="fas fa-trash"></i>
                        </button>
                    </form>
                    @endif
                    @if (Auth::user()->role === 'admin' && $folder->visible !== 'public')
                    <form class="visible-on-hover" style="position: absolute; z-index: 10; right: 4px; bottom: 4px;" action="{{ route('folders.publish', $folder->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure you want to publish this folder?');">
                            <i style="z-index: 11;" class="far fa-calendar-plus"></i>
                        </button>
                    </form>
                    @endif

                    <a href="{{ route('folders.show', $folder->id) }}" class="image-card" style="border-radius: 1rem; z-index: 9">
                        <div>სახელი: {{ $folder->name }}</div>
                        <div>ფილიალი: {{ $folder->branch }}</div>
                        <div>პოსტის თარიღი: {{ $folder->start_date }}</div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
    <style>
        .image-card {
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #101010;
            background-color: #fff;
            max-width: 100%;
            height: 120px;
            position: relative;
            overflow: hidden;
        }

        .image-card:hover {
            color: #476298;
        }

        .main {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Creates a responsive grid */
            gap: 1rem; /* Space between grid items */
            margin: 0 auto; /* Center the main container */
        }

        .visible-on-hover {
            opacity: 0;
            transition: all .2s;
        }

        .card:hover .visible-on-hover {
            opacity: 1;
            transition: all .4s;
        }

        .filters {
            display: flex;
            justify-content: center;
            align-items: center
        }

        @media screen and (max-width: 600px) {
            .wrapper {
                flex-direction: column;
            }

            .visible-on-hover {
                opacity: 1;
            }

            .card {
                width: 350px !important;
            }

            .main {
                display: flex;
                justify-content: center;
            }

            .filters {
                display: flex;
                flex-direction: column;
                align-items: normal;
                margin-left: 1rem;
            }

            .filter-buttons {
                margin-top: 0.5rem !important;
            }
        }
    </style>
@endsection
