@extends('layouts.app')
@section('content')
<div class="container mx-auto px-6">
    <div class="flex flex-wrap -mx-4">
        <div class="w-full lg:w-12/12 px-4">
            <h1 class=" my-5 text-3xl font-semibold">Liste des flexibles</h1>
            @auth
            <a href="{{ route('flexibles.create') }}"
                class="inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-3">Ajouter
                un Flexible</a>
            @endauth
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($flexibles as $flexible)
                <div class="card rounded-lg shadow-lg overflow-hidden">
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            @foreach ($flexible->photos as $photo)
                            <div class="swiper-slide">
                                <img src="{{ asset($photo->path) }}" alt="{{ $flexible->title }}"
                                    class="w-full h-64 object-cover">
                            </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                    <div class="p-6">
                        <h2 class=" text-2xl font-semibold mb-4">{{ $flexible->title }}
                        </h2>
                        <div class="grid grid-cols-2 gap-2">
                            @component('components.buttons.show-flexible', ['flexible' => $flexible])
                            @endcomponent
                            @component('components.buttons.edit-flexible', ['flexible' => $flexible])
                            @endcomponent
                            @component('components.buttons.delete-form', ['route' => route('flexibles.destroy',
                            $flexible)])
                            @endcomponent
                            @component('components.buttons.show-qrcode',['flexible' => $flexible])
                            @endcomponent
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            <div>
                {{ $flexibles->links() }}
            </div>
        </div>
    </div>
</div>
@endsection