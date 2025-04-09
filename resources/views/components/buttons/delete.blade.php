@props(['action'])

<form action="{{ $action }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="inline-block">
    @csrf
    @method('DELETE')
    <button type="submit"
            class="inline-flex items-center bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition duration-200">
        <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Hapus
    </button>
</form>
