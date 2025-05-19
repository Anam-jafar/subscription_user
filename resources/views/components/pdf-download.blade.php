@php
  $storageRoot = '/var/www/static_files';
  $storageFilePath = $pdfFile ? $storageRoot . '/' . $pdfFile : '';

  $fileExists = $storageFilePath && file_exists($storageFilePath);
  $fileSize = $fileExists ? round(filesize($storageFilePath) / 1024, 2) . ' KB' : 'N/A';

  // Extract year and filename from the path for the route
  $year = $pdfFile ? explode('/', $pdfFile)[1] : null;
  $filename = $pdfFile ? basename($pdfFile) : null;

  $downloadUrl =
      $fileExists && $year && $filename
          ? route('download.attachment', ['year' => $year, 'filename' => $filename])
          : '#';
@endphp

<div class="mt-2 rounded-lg bg-gray-50">
  <p class="mb-4 text-gray-800">{{ $title }}</p>

  @if ($fileExists)
    <div class="flex h-12 items-center justify-between rounded-md border border-[#6E829F] bg-[#EBEBEB] p-3">
      <div class="flex items-center space-x-3">
        <div class="flex-shrink-0">
          <img src="{{ asset('subscription/assets/icons/fin_pdf.svg') }}" alt="PDF" class="h-8 w-8" />
        </div>
        <div class="flex flex-col">
          <span class="text-sm text-gray-600">{{ $fileSize }}</span>
        </div>
      </div>
      <a href="{{ $downloadUrl }}" target="_blank" rel="noopener noreferrer" class="text-gray-500 hover:text-gray-700">
        <img src="{{ asset('subscription/assets/icons/fin_pdf_download.svg') }}" alt="download" class="h-10 w-10" />
      </a>
    </div>
  @else
    <div class="flex h-12 items-center justify-center rounded-md border border-[#6E829F] bg-[#EBEBEB] p-3">
      <span class="text-gray-600">No PDF Available</span>
    </div>
  @endif
</div>
