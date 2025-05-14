@props([
    'currentInstitute' => null,
])
<div class="min-h-[55vh] overflow-auto sm:p-2">
  <table class="mt-4 min-w-full border-separate border-spacing-y-4 divide-y divide-gray-200" style="table-layout: fixed;">
    @php
      $alignCenter = ['Status', 'Telah Hantar Penyata', 'Belum Hantar Penyata']; // Add columns that should be centered
      $alignRight = ['Jumlah Invois', 'Jumlah Pembayaran', 'Baki Tertunggak']; // Add columns that should be right-aligned
    @endphp
    <thead>
      <tr class="border-b border-defaultborder">
        <th scope="col" class="px-1 py-1 text-center text-xs font-medium"
          style="color: #2624D0 !important; font-weight: bold !important; width: 50px;">
          Bil.
        </th>
        @foreach ($headers as $header)
          @php
            $alignClass = in_array($header, $alignCenter)
                ? 'text-center'
                : (in_array($header, $alignRight)
                    ? 'text-right'
                    : 'text-left');
          @endphp
          <th scope="col" class="{{ $alignClass }} px-2 py-1 text-xs font-medium"
            style="color: #2624D0 !important; font-weight: bold !important;">
            {{ $header }}
          </th>
        @endforeach
        <th scope="col" class="px-2 py-1 text-left text-center text-xs font-medium"
          style="color: #2624D0 !important; font-weight: bold !important;">
          Tindakan
        </th>
      </tr>
    </thead>
    <tbody class="bg-white">
      @forelse($rows as $key => $row)
        <tr class="cursor-pointer hover:bg-gray-50">
          <!-- Index Column -->
          <td class="whitespace-nowrap px-1 py-2 text-center text-xs text-black">
            {{ $rows->firstItem() + $key }}
          </td>
          <!-- Dynamic Data Columns -->
          @foreach ($columns as $column)
            @php
              $alignCenter = [
                  'status',
                  'subscription_status',
                  'is_activated',
                  'FINSUBMISSIONSTATUS',
                  'SUBSCRIPTION_STATUS',
                  'FIN_STATUS',
                  'STATUS',
                  'total_submission',
                  'unsubmitted',
              ]; // Add columns that should be centered
              $alignRight = ['TOTAL_INVOICE', 'TOTAL_RECEIVED', 'TOTAL_OUTSTANDING']; // Add columns that should be right-aligned
            @endphp
            <td
              class="{{ in_array($column, $alignCenter) ? 'text-center' : (in_array($column, $alignRight) ? 'text-right' : '') }} whitespace-nowrap px-2 py-2 text-xs text-black">
              @if (in_array($column, ['sta', 'status', 'subscription_status', 'is_activated']))
                <x-status-badge :column="$column" :value="$row->$column" />
              @elseif ($column == 'FIN_STATUS' && is_array($row->FIN_STATUS))
                <x-status-badge :column="$column" :value="$row->FIN_STATUS['val'] ?? ''" :text="$row->FIN_STATUS['prm'] ?? 'Unknown'" />
              @else
                {{ $row->$column ?? '-' }}
              @endif
            </td>
          @endforeach
          <!-- Actions Column -->
          <td class="whitespace-nowrap break-words px-2 py-2 text-center text-xs text-black">
            @php
              $finalRoute =
                  isset($row->status) &&
                  ($row->status == 1 || $row->status === 2 || $row->status === 3 || $row->status === 4)
                      ? $secondaryRoute
                      : $route;
            @endphp

            @if ($finalRoute)
              <a href="{{ route($finalRoute, ['id' => $row->id, 'institute_type' => request('institute_type', $currentInstitute)]) }}"
                class="text-blue-500 hover:underline">
                <i class="fe {{ $docIcon ? 'fe-file-text' : 'fe-edit' }}"></i>
              </a>
            @endif

          </td>
        </tr>
      @empty
        <tr>
          <td colspan="{{ count($headers) + 2 }}" class="whitespace-nowrap px-6 py-4 text-center text-xs text-gray-500">
            Tiada rekod ditemui.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
