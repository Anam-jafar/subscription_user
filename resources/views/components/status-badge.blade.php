@props(['column', 'value', 'text' => null])

@php
    $statusStyles = [
        'sta' => [
            0 => ['text' => 'Aktif', 'bg' => '#d1fae5', 'textColor' => '#047857', 'border' => '#047857'],
            1 => ['text' => 'Tidak Aktif', 'bg' => '#fef3c7', 'textColor' => '#b45309', 'border' => '#b45309'],
            2 => ['text' => 'Ditamatkan', 'bg' => '#fee2e2', 'textColor' => '#b91c1c', 'border' => '#b91c1c'],
            3 => ['text' => 'Terpelihara', 'bg' => '#e5e7eb', 'textColor' => '#374151', 'border' => '#374151'],
            'default' => ['text' => 'Unknown', 'bg' => '#e5e7eb', 'textColor' => '#374151', 'border' => '#374151'],
        ],
        'status' => [
            0 => ['text' => 'Draft', 'bg' => '#e5e7eb', 'textColor' => '#374151', 'border' => '#374151'],
            1 => ['text' => 'Disemak', 'bg' => '#fef3c7', 'textColor' => '#b45309', 'border' => '#b45309'],
            2 => ['text' => 'Diterima', 'bg' => '#d1fae5', 'textColor' => '#047857', 'border' => '#047857'],
            3 => ['text' => 'Dibatalkan', 'bg' => '#fee2e2', 'textColor' => '#b91c1c', 'border' => '#b91c1c'],
            4 => ['text' => 'Permohonan Kemaskini', 'bg' => '#fce7f3', 'textColor' => '#be185d', 'border' => '#be185d'],
            'default' => ['text' => 'Unknown', 'bg' => '#e5e7eb', 'textColor' => '#374151', 'border' => '#374151'],
        ],
        'FIN_STATUS' => [
            0 => ['text' => 'Draft', 'bg' => '#e5e7eb', 'textColor' => '#374151', 'border' => '#374151'],
            1 => ['text' => 'Disemak', 'bg' => '#fef3c7', 'textColor' => '#b45309', 'border' => '#b45309'],
            2 => ['text' => 'Diterima', 'bg' => '#d1fae5', 'textColor' => '#047857', 'border' => '#047857'],
            3 => ['text' => 'Dibatalkan', 'bg' => '#fee2e2', 'textColor' => '#b91c1c', 'border' => '#b91c1c'],
            4 => ['text' => 'Mohon Kemaskini', 'bg' => '#fce7f3', 'textColor' => '#be185d', 'border' => '#be185d'],
            'default' => ['text' => 'Unknown', 'bg' => '#e5e7eb', 'textColor' => '#374151', 'border' => '#374151'],
        ],
        'default' => [
            'default' => ['text' => 'Unknown', 'bg' => '#e5e7eb', 'textColor' => '#374151', 'border' => '#374151'],
        ],
    ];

    // Determine the appropriate status mapping
    $columnStatus = $statusStyles[$column] ?? $statusStyles['default'];
    $statusData = $columnStatus[$value] ?? $columnStatus['default'];

    // Use provided text if not null, otherwise use default status text
    $displayText = $text ?? $statusData['text'];
@endphp

<span
    style="
        display: inline-block;
        width: 12rem;
        padding: 4px 8px;
        font-size: 0.75rem;
        font-weight: 600;
        text-align: center;
        border-radius: 4px;
        border: 1px solid {{ $statusData['border'] }};
        background-color: {{ $statusData['bg'] }};
        color: {{ $statusData['textColor'] }};
    ">
    {{ $displayText }}
</span>
