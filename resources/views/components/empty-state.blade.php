@props([
    'icon' => 'bi-inbox', 
    'message' => 'Belum ada data yang tercatat.',
    'colspan' => 1,
    'asTr' => true // Default sebagai baris tabel
])

@if($asTr)
    <tr>
        <td colspan="{{ $colspan }}" class="text-center py-5 text-muted">
            <div class="empty-state-simple">
                <i class="bi {{ $icon }} fs-1 d-block mb-2"></i>
                <span>{{ $message }}</span>
            </div>
        </td>
    </tr>
@else
    <div class="text-center py-5 text-muted w-100">
        <div class="empty-state-simple">
            <i class="bi {{ $icon }} fs-1 d-block mb-2"></i>
            <span>{{ $message }}</span>
        </div>
    </div>
@endif