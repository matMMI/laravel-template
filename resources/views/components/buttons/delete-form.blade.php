@auth
<form action="{{ $route }}" method="POST"
    {{-- onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce flexible ?');" --}}
    >
    @csrf
    @method('DELETE')
    <button type="submit"
        class="transition duration-100 w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Supprimer</button>
</form>
@endauth