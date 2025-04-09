<div class="flex items-center space-x-2">
    @if ($siswa->users_status === 'active')
        <a href="{{ route('siswa.edit', $siswa->id) }}"
            class="inline-flex items-center px-3 py-1.5 bg-yellow-400 text-white text-sm rounded hover:bg-yellow-500 transition">
            Edit
        </a>

        <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" id="deleteForm{{ $siswa->id }}" style="display:none;">
            @csrf
            @method('DELETE')
        </form>
        <button type="button"
            class="inline-flex items-center px-3 py-1.5 bg-red-500 text-white text-sm rounded hover:bg-red-600 transition"
            onclick="confirmDelete({{ $siswa->id }})">
            Hapus
        </button>
    @endif
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus Siswa?',
            text: "Anda tidak dapat mengembalikan data ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm' + id).submit();
            }
        });
    }
</script>
