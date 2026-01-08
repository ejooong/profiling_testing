@extends('layouts.admin')

@section('title', 'Pesan Kontak')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pesan Kontak</h1>
            <p class="mt-1 text-sm text-gray-600">Manajemen pesan dari pengunjung website</p>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</div>
            <div class="text-sm text-gray-600">Total Pesan</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-2xl font-bold text-red-600">{{ $stats['unread'] }}</div>
            <div class="text-sm text-gray-600">Belum Dibaca</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-2xl font-bold text-blue-600">{{ $stats['read'] }}</div>
            <div class="text-sm text-gray-600">Sudah Dibaca</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-2xl font-bold text-green-600">{{ $stats['replied'] }}</div>
            <div class="text-sm text-gray-600">Sudah Dibalas</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-2xl font-bold text-gray-600">{{ $stats['archived'] }}</div>
            <div class="text-sm text-gray-600">Diarsipkan</div>
        </div>
    </div>

    <!-- Bulk Actions -->
    <form id="bulkForm" action="{{ route('admin.contact-messages.bulk-action') }}" method="POST">
        @csrf
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <input type="checkbox" id="selectAll" class="rounded border-gray-300">
                    <span id="selectedCount" class="text-sm text-gray-600">0 pesan terpilih</span>
                </div>
                <div class="flex items-center space-x-3">
                    <select name="action" id="bulkAction" class="border-gray-300 rounded-md text-sm">
                        <option value="">Pilih Aksi</option>
                        <option value="mark_read">Tandai sebagai Dibaca</option>
                        <option value="mark_archived">Arsipkan</option>
                        <option value="delete">Hapus</option>
                    </select>
                    <button type="submit" id="applyBulkAction"
                        class="px-4 py-2 bg-nasdem-red text-white rounded-md text-sm font-medium hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                        Terapkan
                    </button>
                </div>
            </div>

            <!-- Messages List -->
            @if($messages->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10">
                                <!-- Checkbox -->
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pengirim
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Subjek
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($messages as $message)
                        <tr class="{{ $message->isUnread() ? 'bg-blue-50' : 'hover:bg-gray-50' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox"
                                    name="messages[]"
                                    value="{{ $message->id }}"
                                    class="message-checkbox rounded border-gray-300">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-600 font-bold">
                                                {{ strtoupper(substr($message->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $message->name }}
                                            @if($message->isUnread())
                                            <span class="ml-2 w-2 h-2 bg-red-500 rounded-full inline-block"></span>
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $message->email }}
                                        </div>
                                        @if($message->phone)
                                        <div class="text-xs text-gray-400">
                                            {{ $message->phone }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $message->subject }}
                                </div>
                                <div class="text-sm text-gray-500 truncate max-w-xs">
                                    {{ Str::limit($message->message, 70) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($message->isUnread())
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Belum Dibaca
                                </span>
                                @elseif($message->isReplied())
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Sudah Dibalas
                                </span>
                                @elseif($message->isArchived())
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Diarsipkan
                                </span>
                                @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Sudah Dibaca
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $message->created_at->format('d M Y') }}
                                <div class="text-xs text-gray-400">
                                    {{ $message->created_at->format('H:i') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.contact-messages.show', $message) }}"
                                        class="text-blue-600 hover:text-blue-900"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($message->isUnread())
                                    <form action="{{ route('admin.contact-messages.mark-as-read', $message) }}"
                                        method="POST"
                                        class="inline mark-read-form">
                                        @csrf
                                        <button type="submit"
                                            class="text-green-600 hover:text-green-900"
                                            title="Tandai sebagai Dibaca">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                    <form action="{{ route('admin.contact-messages.mark-as-archived', $message) }}"
                                        method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Arsipkan pesan ini?')">
                                        @csrf
                                        <button type="submit"
                                            class="text-yellow-600 hover:text-yellow-900"
                                            title="Arsipkan">
                                            <i class="fas fa-archive"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.contact-messages.destroy', $message) }}"
                                        method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Hapus pesan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900"
                                            title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t">
                {{ $messages->links() }}
            </div>
            @else
            <!-- Empty State -->
            <div class="p-12 text-center">
                <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-xl font-medium text-gray-900 mb-2">Belum ada pesan</h3>
                <p class="text-gray-600">Semua pesan dari pengunjung akan muncul di sini.</p>
            </div>
            @endif
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Bulk Actions
    const selectAll = document.getElementById('selectAll');
    const messageCheckboxes = document.querySelectorAll('.message-checkbox');
    const selectedCount = document.getElementById('selectedCount');
    const bulkAction = document.getElementById('bulkAction');
    const applyBulkAction = document.getElementById('applyBulkAction');

    // Select All functionality
    selectAll.addEventListener('change', function() {
        const isChecked = this.checked;
        messageCheckboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
        });
        updateSelectedCount();
    });

    // Update selected count
    function updateSelectedCount() {
        const checkedCount = document.querySelectorAll('.message-checkbox:checked').length;
        selectedCount.textContent = checkedCount + ' pesan terpilih';
        applyBulkAction.disabled = checkedCount === 0 || !bulkAction.value;
    }

    // Update on individual checkbox change
    messageCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedCount);
    });

    // Update apply button on action select
    bulkAction.addEventListener('change', function() {
        const checkedCount = document.querySelectorAll('.message-checkbox:checked').length;
        applyBulkAction.disabled = checkedCount === 0 || !this.value;
    });

    // Mark as read with AJAX
    document.querySelectorAll('.mark-read-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const url = form.action;
            const token = form.querySelector('input[name="_token"]').value;

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });
</script>
@endpush