@props(['column', 'value'])

@php
    $statusStyles = [
        // Status mappings for 'sta' column
        'sta' => [
            0 => ['text' => 'Aktif', 'class' => 'bg-green-100 text-green-700 border-green-500'],
            1 => ['text' => 'Tidak Aktif', 'class' => 'bg-yellow-100 text-yellow-700 border-yellow-500'],
            2 => ['text' => 'Ditamatkan', 'class' => 'bg-red-100 text-red-700 border-red-500'],
            3 => ['text' => 'Terpelihara', 'class' => 'bg-gray-100 text-gray-700 border-gray-500'],
            'default' => ['text' => 'Unknown', 'class' => 'bg-gray-100 text-gray-700 border-gray-500'],
        ],

        // Status mappings for 'status' column
        'status' => [
            0 => ['text' => 'Draft', 'class' => 'bg-gray-100 text-gray-700 border-gray-500'],
            2 => ['text' => 'Diterima', 'class' => 'bg-green-100 text-green-700 border-green-500'],
            1 => ['text' => 'Disemak', 'class' => 'bg-yellow-100 text-yellow-700 border-yellow-500'],
            3 => ['text' => 'Dibatalkan', 'class' => 'bg-red-100 text-red-700 border-red-500'],
            'default' => ['text' => 'Unknown', 'class' => 'bg-gray-100 text-gray-700 border-gray-500'],
        ],

        // Default mapping for unknown columns
        'default' => [
            'default' => ['text' => 'Unknown', 'class' => 'bg-gray-100 text-gray-700 border-gray-500'],
        ],
    ];

    // Determine the appropriate status mapping
    $columnStatus = $statusStyles[$column] ?? $statusStyles['default'];
    $statusData = $columnStatus[$value] ?? $columnStatus['default'];

@endphp

<span class="inline-block w-24 px-2 py-1 text-xs font-semibold text-center border rounded-sm {{ $statusData['class'] }}">
    {{ $statusData['text'] }}
</span>
