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

    <div class="max-w-xl mx-auto bg-white shadow-md rounded-lg p-6 mt-10">
        <h1 class="text-2xl font-bold mb-4 text-center text-blue-600">Daftar Tugas</h1>

        <form action="{{ route('tasks.store') }}" method="POST" class="flex gap-2 mb-6">
            @csrf
            <input type="text" name="title" placeholder="Tambahkan tugas baru..." required 
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                Tambah
            </button>
        </form>

        <ul>
            @foreach($tasks as $task)
                <li class="flex items-center justify-between p-3 border-b last:border-b-0">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" onchange="toggleTask({{ $task->id }}, this)" 
                            {{ $task->is_completed ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 cursor-pointer">
                        <span id="task-title-{{ $task->id }}" class="{{ $task->is_completed ? 'line-through text-gray-400' : '' }}">
                            {{ $task->title }}
                        </span>
                    </div>
                    
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold">
                            Hapus
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>

    <script>
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
                    if(data.status) {
                        titleElement.classList.add('line-through', 'text-gray-400');
                    } else {
                        titleElement.classList.remove('line-through', 'text-gray-400');
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>