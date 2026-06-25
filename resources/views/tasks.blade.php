<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Task Tracker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800 font-sans antialiased p-6">

    <div class="max-w-xl mx-auto bg-white shadow-md rounded-lg p-6 mt-10 relative">
        <h1 class="text-2xl font-bold mb-4 text-center text-blue-600">Daftar Tugas</h1>

        <!-- Form Tambah Tugas -->
        <form action="{{ route('tasks.store') }}" method="POST" class="flex gap-2 mb-6">
            @csrf
            <input type="text" name="title" placeholder="Tambahkan tugas baru..." required 
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                Tambah
            </button>
        </form>

        <!-- List Tugas -->
        <ul id="task-list">
            @foreach($tasks as $task)
                <!-- Tambahkan ID pada tag li agar mudah digeser oleh JavaScript -->
                <li id="task-item-{{ $task->id }}" class="flex items-center justify-between p-3 border-b last:border-b-0 transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" onchange="toggleTask({{ $task->id }}, this)" 
                            {{ $task->is_completed ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 cursor-pointer">
                        <span id="task-title-{{ $task->id }}" class="transition-all duration-300 {{ $task->is_completed ? 'line-through text-gray-400' : '' }}">
                            {{ $task->title }}
                        </span>
                    </div>
                    
                    <!-- Fitur Konfirmasi Hapus -->
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menghapus tugas ini? 🗑️')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-3 py-1.5 rounded-md hover:bg-red-600 transition-colors duration-200 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-red-400">
                            Hapus
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- UI Notifikasi (Disembunyikan secara default) -->
    <div id="toast" class="fixed bottom-5 left-5 bg-green-500 text-white px-6 py-3 rounded-md shadow-lg transform transition-all duration-300 translate-y-20 opacity-0 pointer-events-none z-50">
        Pesan Notifikasi
    </div>

    <!-- JavaScript untuk interaksi AJAX & DOM -->
    <script>
        // Fungsi untuk memunculkan notifikasi
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            toast.innerText = message;
            
            // Bersihkan warna sebelumnya agar tidak bertumpuk
            toast.classList.remove('bg-green-500', 'bg-gray-500');

            // Set warna sesuai tipe
            if (type === 'success') {
                toast.classList.add('bg-green-500');
            } else {
                toast.classList.add('bg-gray-500');
            }

            // Munculkan notifikasi (animasi naik)
            toast.classList.remove('translate-y-20', 'opacity-0');

            // Sembunyikan otomatis setelah 3 detik
            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 3000);
        }

        // Fungsi toggle status tugas
        function toggleTask(id, checkbox) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch(`/tasks/${id}/toggle`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    const titleElement = document.getElementById(`task-title-${id}`);
                    const liElement = document.getElementById(`task-item-${id}`);
                    const ulElement = document.getElementById('task-list');

                    if(data.status) {
                        titleElement.classList.add('line-through', 'text-gray-400');
                        ulElement.appendChild(liElement); 
                        showToast('Tugas berhasil diselesaikan! 🎉', 'success');
                    } else {
                        titleElement.classList.remove('line-through', 'text-gray-400');
                        ulElement.prepend(liElement); 
                        showToast('Tugas dikembalikan ke daftar.', 'neutral');
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Cek dan jalankan notifikasi dari Session Laravel (saat halaman di-reload setelah hapus)
        @if(session('success'))
            // Beri jeda 100 milidetik agar transisi animasinya terlihat mulus
            setTimeout(() => {
                showToast("{{ session('success') }}", 'neutral');
            }, 100); 
        @endif

        // Notifikasi saat tugas baru ditambahkan
        @if(session('success_add'))
            setTimeout(() => {
                showToast("{{ session('success_add') }}", 'success');
            }, 100);
        @endif
    </script>
</body>
</html>