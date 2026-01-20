@extends('layouts.app')

@section('content')
<h1>Notifikasi</h1>

<div class="list-group">
@forelse($notifikasis as $n)
  @php $jadwalId = is_array($n->data) && array_key_exists('jadwal_id',$n->data) ? $n->data['jadwal_id'] : (is_string($n->data) ? (json_decode($n->data,true)['jadwal_id'] ?? null) : null); @endphp
  <div class="list-group-item d-flex justify-content-between align-items-start">
    <div>
      <strong>{{ $n->title }}</strong>
      <div class="small text-muted">{{ $n->created_at->format('Y-m-d H:i') }}</div>
      <div class="mt-1">{{ $n->message }}</div>
    </div>
    <div class="text-end">
      @if($jadwalId)
        <a href="{{ route('jadwal_konseling.show', ['jadwal_konseling' => $jadwalId]) }}" class="btn btn-sm btn-outline-primary mb-1">Buka Jadwal</a>
      @endif

      @if(!$n->is_read)
        <form method="POST" action="{{ route('notifikasi.read', ['id' => $n->id]) }}" style="display:inline-block;">
          @csrf
          <button class="btn btn-sm btn-primary">Tandai dibaca</button>
        </form>
      @else
        <span class="badge bg-secondary">Dibaca</span>
      @endif
    </div>
  </div>
@empty
  <div class="text-muted">Belum ada notifikasi</div>
@endforelse
</div>

{{ $notifikasis->links() }}

@endsection
