@extends('layouts.admin')

@section('title', 'Detail Pesan: ' . $message->name)

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Pesan</h1>
            <p class="mt-1 text-sm text-gray-600">Dari: {{ $message->name }} &lt;{{ $message->email }}&gt;</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.contact-messages.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            @if($message->isUnread())
            <form action="{{ route('admin.contact-messages.mark-as-read', $message) }}"
                method="POST"
                class="inline">
                @csrf
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    <i class="fas fa-check mr-2"></i>Tandai Dibaca
                </button>
            </form>
            @endif
            @if(!$message->isArchived())
            <form action="{{ route('admin.contact-messages.mark-as-archived', $message) }}"
                method="POST"
                class="inline">
                @csrf
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700">
                    <i class="fas fa-archive mr-2"></i>Arsipkan
                </button>
            </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Message Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Message Card -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex justify-between items-center">
                        <h2 class="text-lg font-medium text-gray-900">Pesan Asli</h2>
                        <div class="flex items-center space-x-2">
                            @if($message->isUnread())
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                Belum Dibaca
                            </span>
                            @elseif($message->isReplied())
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Sudah Dibalas
                            </span>
                            @elseif($message->isArchived())
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                Diarsipkan
                            </span>
                            @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                Sudah Dibaca
                            </span>
                            @endif
                            <span class="text-sm text-gray-500">
                                {{ $message->created_at->format('d M Y H:i') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Sender Info -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-600 text-2xl font-bold">
                                        {{ strtoupper(substr($message->name, 0, 1)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-900">{{ $message->name }}</h3>
                                <div class="mt-2 space-y-1">
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-envelope mr-2 w-5"></i>
                                        <a href="mailto:{{ $message->email }}" class="hover:text-blue-600">
                                            {{ $message->email }}
                                        </a>
                                    </div>
                                    @if($message->phone)
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-phone mr-2 w-5"></i>
                                        <a href="tel:{{ $message->phone }}" class="hover:text-blue-600">
                                            {{ $message->phone }}
                                        </a>
                                    </div>
                                    @endif
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-calendar mr-2 w-5"></i>
                                        <span>Dikirim: {{ $message->created_at->format('d F Y, H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Subject -->
                    <div class="mb-6">
                        <div class="text-sm font-medium text-gray-500 mb-2">Subjek</div>
                        <div class="text-lg font-medium text-gray-900 bg-gray-50 p-4 rounded-lg">
                            {{ $message->subject }}
                        </div>
                    </div>

                    <!-- Message Content -->
                    <div>
                        <div class="text-sm font-medium text-gray-500 mb-2">Pesan</div>
                        <div class="bg-gray-50 p-6 rounded-lg whitespace-pre-line text-gray-700">
                            {{ $message->message }}
                        </div>
                    </div>

                    <!-- Technical Info -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-500 mb-3">Informasi Teknis</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <div class="text-gray-600">IP Address</div>
                                <div class="font-medium">{{ $message->ip_address ?? '-' }}</div>
                            </div>
                            <div>
                                <div class="text-gray-600">Browser</div>
                                <div class="font-medium truncate" title="{{ $message->user_agent }}">
                                    {{ Str::limit($message->user_agent, 50) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reply Form (if not replied) -->
            @if(!$message->isReplied())
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-medium text-gray-900">Balas Pesan</h2>
                </div>

                <form action="{{ route('admin.contact-messages.reply', $message) }}" method="POST" class="p-6">
                    @csrf

                    <div class="space-y-4">
                        <div>
                            <label for="reply_message" class="block text-sm font-medium text-gray-700 mb-2">
                                Balasan Anda
                            </label>
                            <textarea name="reply_message"
                                id="reply_message"
                                rows="8"
                                required
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-nasdem-red focus:ring focus:ring-red-200 focus:ring-opacity-50"
                                placeholder="Tulis balasan untuk {{ $message->name }}..."></textarea>
                            @error('reply_message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-3">
                            <button type="button"
                                onclick="document.getElementById('reply_message').value = ''"
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Hapus
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-nasdem-red text-white rounded-md text-sm font-medium hover:bg-red-700">
                                <i class="fas fa-paper-plane mr-2"></i>Kirim Balasan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            @endif
        </div>

        <!-- Right Column: Sidebar -->
        <div class="space-y-6">
            <!-- Status & Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Status & Aksi</h3>

                <div class="space-y-4">
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Status Saat Ini</div>
                        @if($message->isUnread())
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                            Belum Dibaca
                        </span>
                        @elseif($message->isReplied())
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                            Sudah Dibalas
                        </span>
                        @elseif($message->isArchived())
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                            Diarsipkan
                        </span>
                        @else
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                            Sudah Dibaca
                        </span>
                        @endif
                    </div>

                    <div>
                        <div class="text-sm text-gray-500 mb-1">Dibalas Oleh</div>
                        <div class="font-medium">
                            @if($message->replier)
                            {{ $message->replier->name }}
                            @else
                            <span class="text-gray-400">Belum dibalas</span>
                            @endif
                        </div>
                    </div>

                    @if($message->replied_at)
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Tanggal Balasan</div>
                        <div class="font-medium">
                            {{ $message->replied_at->format('d M Y H:i') }}
                        </div>
                    </div>
                    @endif

                    <div class="pt-4 border-t border-gray-200 space-y-2">
                        @if(!$message->isReplied())
                        <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}"
                            target="_blank"
                            class="block w-full text-center px-4 py-2 bg-blue-100 text-blue-700 rounded-md text-sm font-medium hover:bg-blue-200">
                            <i class="fas fa-envelope mr-2"></i>Balas via Email
                        </a>
                        @endif

                        @if($message->phone)
                        <a href="tel:{{ $message->phone }}"
                            class="block w-full text-center px-4 py-2 bg-green-100 text-green-700 rounded-md text-sm font-medium hover:bg-green-200">
                            <i class="fas fa-phone mr-2"></i>Telepon
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>

                <div class="space-y-3">
                    @if($message->isUnread())
                    <form action="{{ route('admin.contact-messages.mark-as-read', $message) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 bg-green-50 text-green-700 rounded-md text-sm font-medium hover:bg-green-100">
                            <i class="fas fa-check mr-2"></i>Tandai sebagai Dibaca
                        </button>
                    </form>
                    @endif

                    @if(!$message->isArchived())
                    <form action="{{ route('admin.contact-messages.mark-as-archived', $message) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 bg-yellow-50 text-yellow-700 rounded-md text-sm font-medium hover:bg-yellow-100">
                            <i class="fas fa-archive mr-2"></i>Arsipkan Pesan
                        </button>
                    </form>
                    @endif

                    <form action="{{ route('admin.contact-messages.destroy', $message) }}"
                        method="POST"
                        onsubmit="return confirm('Hapus pesan ini secara permanen?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full text-left px-4 py-2 bg-red-50 text-red-700 rounded-md text-sm font-medium hover:bg-red-100">
                            <i class="fas fa-trash mr-2"></i>Hapus Pesan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Reply Preview (if replied) -->
            @if($message->isReplied())
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Balasan Anda</h3>

                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500 mb-2">
                        Dibalas pada {{ $message->replied_at->format('d M Y, H:i') }}
                    </div>
                    <div class="text-gray-700 whitespace-pre-line">
                        {{ $message->reply_message }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection