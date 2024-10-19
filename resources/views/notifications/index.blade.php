@extends('layouts.default')

@section('title', __('Notifications'))

@section('content')
    <div class="container mt-4">

        @if ($notifications->isEmpty())
            <div class="alert alert-info text-center">No notifications available.</div>
        @else
            <div class="list-group">
                @foreach ($notifications as $notification)
                    <div
                        class="list-group-item d-flex justify-content-between align-items-start
                    {{ $notification->read_at ? 'bg-light' : 'bg-white border border-primary' }}
                    shadow-sm p-3 mb-3 rounded">
                        <a class="flex-fill text-decoration-none"
                            href="{{ $notification->data['url'] ?? '#' }}?notify_id={{ $notification->id }}">
                            <h5 class="mb-1 text-truncate">{{ $notification->data['title'] ?? 'Notification Title' }}</h5>
                            <p class="mb-1">{{ $notification->data['body'] ?? 'No message provided.' }}</p>
                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            @if (!$notification->read_at)
                                <span class="badge bg-danger rounded-pill">New</span>
                            @endif
                        </a>
                        <div>
                            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete Notification">
                                    <i class="bi bi-trash">X</i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination Links --}}
            <div class="d-flex justify-content-center mt-4">
                {{-- {{ $notifications->links() }} <!-- Laravel pagination links --> --}}
            </div>
        @endif
    </div>


@endsection
