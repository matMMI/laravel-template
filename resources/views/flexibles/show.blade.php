@extends('layouts.app')
@section('content')
<div class="container mx-auto mt-5 px-6">
    <div class="mt-6">
        <h1 class=" text-3xl font-bold mb-5">{{ $flexible->title }}</h1>
        @if(\Carbon\Carbon::parse($flexible->last_check_date)->isPast())
        <p class="inline-block mb-5 text-lg bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            Date de péremption : {{ \Carbon\Carbon::parse($flexible->last_check_date)->format('d-m-Y') }}
        </p>
        @elseif(\Carbon\Carbon::parse($flexible->last_check_date)->lt(\Carbon\Carbon::now()->addMonth()))
        <p
            class="inline-block mb-5 text-lg bg-orange-100 border border-orange-400 text-orange-700 px-4 py-3 rounded relative">
            Date de péremption : {{ \Carbon\Carbon::parse($flexible->last_check_date)->format('d-m-Y') }}
        </p>
        @else
        <p
            class="inline-block mb-5 text-lg bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            Date de péremption : {{ \Carbon\Carbon::parse($flexible->last_check_date)->format('d-m-Y') }}
        </p>
        @endif
        <div>
            @component('components.buttons.edit-flexible', ['flexible' => $flexible])
            @endcomponent
        </div>
        <div class="parent mt-5 ">
            <div class="div1 card rounded-lg shadow-lg overflow-hidden">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        @foreach($flexible->photos as $photo)
                        <div class="swiper-slide">
                            <img src="{{ $photo->path }}" alt="{{ $flexible->title }}" class="w-full h-64 object-cover">
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
            <div class="div2">
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all  sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white">
                        <img src="{{ asset('qrcodes/'.$flexible->id.'.png') }}" alt="QR Code for {{ $flexible->title }}"
                            class="w-full rounded-lg shadow-md">
                    </div>
                </div>
            </div>
            <div class="div3">
                <form action="{{ route('flexibles.updateFields', $flexible) }}" method="post">
                    @csrf
                    <div class="rounded-lg relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        DATE DE VÉRIFICATION
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        STATUS
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        ÉTAT
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        CONTRÔLEUR
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- AFFICHER ICI LES DONNÉS VALIDÉES -->
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ \Carbon\Carbon::parse($flexible->date_verification)->format('d-m-Y') }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $flexible->status }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $flexible->etat }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $flexible->controlleur }}
                                    </td>
                                </tr>
                                @auth
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <!-- DATE DE VÉRIFICATION -->
                                        <input type="date" id="date_verification" name="date_verification">
                                    </th>
                                    <td class="px-6 py-4">
                                        <!-- ÉTAT (BON ou À REMPLACER) -->
                                        <select id="etat" name="status">
                                            <option value="VÉRIFIÉ">VÉRIFIÉ</option>
                                            <option value="NON VÉRIFIÉ">NON VÉRIFIÉ</option>
                                        </select>
                                    </td>
                                    <td class="px-6 py-4">
                                        <!-- ÉTAT (BON ou À REMPLACER) -->
                                        <select id="etat" name="etat">
                                            <option value="BON">Bon</option>
                                            <option value="À REMPLACER">À remplacer</option>
                                        </select>
                                    </td>
                                    <td class="px-6 py-4">
                                        <!-- NOM DE LA PERSONNE QUI A FAIT LE CONTRÔLE -->
                                        <input type="text" id="controlleur" name="controlleur">
                                    </td>
                                </tr>
                                @endauth
                            </tbody>
                        </table>
                    </div>
                    @auth
                    <button type="submit"
                        class="my-5 px-4 py-2 font-semibold text-white bg-blue-500 rounded hover:bg-blue-700">Valider</button>
                    @endauth
                    @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">

                        <span class="block sm:inline">LES CHAMPS SUIVANTS DOIVENT ÊTRE REMPLIS</span>
                        <ul class="mt-3 text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                </form>
            </div>
        </div>
    </div>
</div>
@endsection