<div class="overflow-auto sm:p-2">
    <table class="min-w-full divide-y divide-gray-200 mt-4 border-separate border-spacing-y-4"
        style="table-layout: fixed;">
        <thead>
            <tr class="border-b border-defaultborder">
                <th scope="col" class="px-1 py-1 text-xs font-medium text-center"
                    style="color: #2624D0 !important; font-weight: bold !important; width: 50px;">
                    Bil.
                </th>
                @foreach ($headers as $header)
                    <th scope="col" class="px-2 py-1 text-left text-xs font-medium text-start"
                        style="color: #2624D0 !important; font-weight: bold !important;">
                        {{ $header }}
                    </th>
                @endforeach
                <th scope="col" class="px-2 py-1 text-left text-xs font-medium text-center"
                    style="color: #2624D0 !important; font-weight: bold !important;">
                    Tindakan
                </th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @forelse($rows as $key => $row)
                <tr class="hover:bg-gray-50 cursor-pointer">
                    <!-- Index Column -->
                    <td class="px-1 py-2 whitespace-nowrap text-xs text-black text-center">
                        {{ $rows->firstItem() + $key }}
                    </td>
                    <!-- Dynamic Data Columns -->
                    @foreach ($columns as $column)
                        <td class="px-2 py-2 whitespace-nowrap text-xs text-black break-words text-start">
                            @if ($column === 'profile_status')
                                <span class="text-green-500 font-semibold">{{ $row->$column ?? '-' }}</span>
                            @elseif ($column === 'status')
                                <span class="text-green-500 font-semibold">{{ $row->$column ?? '-' }}</span>
                            @else
                                {{ $row->$column ?? '-' }}
                            @endif
                        </td>
                    @endforeach
                    <!-- Actions Column -->
                    <td class="px-2 py-2 whitespace-nowrap text-xs text-black break-words text-center">
                        @php
                            $finalRoute =
                                isset($row->submission_status) && $row->submission_status === 'SS05'
                                    ? $secondaryRoute
                                    : $route;
                        @endphp

                        @if ($finalRoute)
                            <a href="{{ route($finalRoute, ['id' => $row->id]) }}"
                                class="text-blue-500 hover:underline">
                                <i class="fe {{ $docIcon ? 'fe-file-text' : 'fe-edit' }}"></i>
                            </a>
                        @endif

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headers) + 2 }}"
                        class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 text-center">
                        Tiada rekod ditemui.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
