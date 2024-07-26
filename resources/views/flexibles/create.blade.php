@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6">
    <h1 class=" text-3xl font-semibold my-5">Ajouter un nouveau flexible</h1>

    <form action="{{ route('flexibles.store') }}" method="post" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label for="title" class="block text-sm font-medium">Titre</label>
            <input type="text" id="title" name="title"
                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        </div>

        <div>
            <label for="last_check_date" class="block text-sm font-medium">Dernière vérification</label>
            <input type="date" id="last_check_date" name="last_check_date"
                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        </div>

        <div>
            <label for="photos" class="block text-sm font-medium">Photos</label>
            <input type="file" id="photos" name="photos[]" multiple
                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        </div>

        <button type="submit" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            style="width:100%;">Ajouter</button>
    </form>
</div>
@endsection