@extends('layouts.admin')

@section('title', 'Services')

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">Services</h1>
            <p class="page-subtitle">Service cards shown on the home page.</p>
        </div>
    </div>

    {{-- enctype is required for file uploads. @method('PUT') tells Laravel this is an update --}}
    <form method="POST" action="{{ route('admin.services.update') }}" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')

        <section class="section-card" data-repeater data-max-rows="4">
            <div class="section-head">
                <h2 class="section-title">Service Cards</h2>
                <button type="button" class="btn-outline" data-add>+ Add Service</button>
            </div>

            <div class="cards-auto-grid" data-rows>
                @foreach (old('services', $services) as $i => $row)
                    @include('admin.rows.service', ['i' => $i, 'row' => $row])
                @endforeach
            </div>

            {{-- JavaScript copies this blank row and replaces __INDEX__ with a new number --}}
            <template>
                @include('admin.rows.service', ['i' => '__INDEX__', 'row' => []])
            </template>
        </section>

        @include('partials.save-bar', ['label' => 'Save Services'])
    </form>
@endsection
