@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="{{ asset('js/index.js') }}"></script>
@endsection

@section('link')
    <div class="search_box">
        <form id="searchForm" action="{{ route('store.index') }}" method="GET" class="search-form">
            <div class="select-wrapper">
                <select name="area_id" class="search-area-select" onchange="submitForm()">
                    <option value="all" {{ (isset($areaId) && $areaId == 'all') ? 'selected' : '' }}>All areas</option>
                    @foreach($areas as $area)
                    <option value="{{ $area->id }}" {{ (isset($areaId) && $areaId == $area->id) ? 'selected' : '' }}>
                        {{ $area->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="select-wrapper">
                <select name="genre_id" class="search-genre-select" onchange="submitForm()">
                    <option value="all" {{ (isset($genreId) && $genreId == 'all') ? 'selected' : '' }}>All genre</option>
                    @foreach($genres as $genre)
                    <option value="{{ $genre->id }}" {{ (isset($genreId) && $genreId == $genre->id) ? 'selected' : '' }}>
                        {{ $genre->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="search-wrapper">
                <input type="text" name="keyword" value="{{ $keyword ?? '' }}" placeholder="Search ..." class="search-keyword-input" oninput="submitForm()">
            </div>
        </form>
    </div>
@endsection

@section('content')
    @foreach($stores as $store)
    <div class="shop">
        <img class="shop_img" src="{{ asset('img/' . $store->store_id . '.jpg') }}" alt="{{ $store->name }}の店舗画像">
        <div class="shop_content">
            <h3>{{ $store->name }}</h3>
            <p>#{{ $store->area->name }} #{{ $store->genre->name }}</p>
            <a href="{{ route('store.detail', ['store_id' => $store->store_id]) }}">詳しくみる</a>
        </div>
        <div class="heart-icon"></div>
    </div>
    @endforeach
@endsection
