@extends('layouts.main')

@section('title', 'Редактирование страницы')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
@endpush

@section('content')
    <div class="body d-flex py-lg-3 py-md-2">
        <div class="container-xxl">

            <x-heading />
            <x-errors />
            <x-message />

            @if (Route::has('admin.page.store'))
                <form action="{{ route('admin.page.update', $page) }}" method="post" enctype="multipart/form-data">

                    @method('PUT')
                    @csrf

                    @includeIf('page.partials._form')

                </form>
            @else
                <x-no-data>
                    <x-slot:button>
                        @if (Route::has('admin.statistics.index'))
                            <a href="{{ route('admin.statistics.index') }}" class="btn btn-primary border lift mt-1">{{ __('Вернутся на главную') }}</a>
                        @endif
                    </x-slot>
                </x-no-data>
            @endif
            
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/dropify.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            ClassicEditor.create(document.querySelector('#editor'), {
                ckfinder: {
                    uploadUrl: '{{ route('admin.media.upload') . '?_token=' . csrf_token() }}',
                }
            });
        });

        $(function() {
            $('.dropify').dropify();
        });
    </script>
@endpush