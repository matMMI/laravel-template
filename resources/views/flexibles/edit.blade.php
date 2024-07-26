@extends('layouts.app')
@section('content')
<div class="container mx-auto px-6">
    <h1 class="my-5 text-3xl font-semibold">Modifier le Flexible</h1>
    <form action="{{ route('flexibles.update', $flexible) }}" method="post" enctype="multipart/form-data"
        class="space-y-4">
        @csrf
        @method('PUT')
        <div class="flex flex-col">
            <label for="title" class="mb-2">Title</label>
            <input type="text" id="title" name="title" value="{{ $flexible->title }}" class="p-2 border rounded-md">
        </div>
        <div class="flex flex-col">
            <label for="last_check_date" class="mb-2">Date de péremption</label>
            <input type="date" id="last_check_date" name="last_check_date" value="{{ $flexible->last_check_date }}"
                class="p-2 border rounded-md">
        </div>
        <div class="flex flex-col">
            <label for="photos" class="mb-2">Photos</label>
            <input type="file" id="photos" name="photos[]" multiple class="p-2 border rounded-md">
        </div>
        @if ($flexible->photos->count() > 0)
        <div class="flex flex-col">
            <label for="current_photos" class="mb-2">Image actuelle</label>
            <div class="flex flex-wrap">
                @foreach ($flexible->photos as $photo)
                <div class="relative mr-2 mt-2">
                    <img src="{{ asset($photo->path) }}" alt="Photo" class="w-24 h-auto"
                        style="object-fit: cover; height: 100px; width: 100px; border-radius: 10px;">
                    <button class="absolute top-0 right-0 py-1 px-1 " onclick="deleteImage({{ $photo->id }})">
                        <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="0.394287" y="0.323242" width="32.1328" height="32.1328" rx="16.0664"
                                fill="#FF7658" />
                            <path
                                d="M12.6111 21.2017L11.6487 20.2393L15.4983 16.3896L11.6487 12.54L12.6111 11.5776L16.4607 15.4272L20.3103 11.5776L21.2727 12.54L17.4231 16.3896L21.2727 20.2393L20.3103 21.2017L16.4607 17.3521L12.6111 21.2017Z"
                                fill="white" />
                        </svg>
                    </button>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">Mettre à
            jour</button>
    </form>
</div>
@endsection