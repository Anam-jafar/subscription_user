@php
    // Define the absolute file path
    $storageFilePath = $pdfFile ? '/var/www/static_files/fin_statement_attachments/' . basename($pdfFile) : '';

    // Check if the file exists
    $fileExists = $storageFilePath && file_exists($storageFilePath);
    $fileSize = $fileExists ? round(filesize($storageFilePath) / 1024, 2) . ' KB' : 'N/A';

    // Generate a URL for download (create a custom route)
    $downloadUrl = $fileExists ? route('download.attachment', ['filename' => basename($pdfFile)]) : '#';
@endphp

<div class="bg-gray-50 rounded-lg mt-2">
    <p class="text-gray-800 mb-4">{{ $title }}</p>

    @if ($fileExists)
        <div class="flex items-center justify-between rounded-md p-3 border border-[#6E829F] bg-[#EBEBEB] h-12">
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <img src="{{ asset('subscription/assets/icons/fin_pdf.svg') }}" alt="PDF" class="w-8 h-8" />
                </div>
                <div class="flex flex-col">
                    <span class="text-sm text-gray-600">{{ $fileSize }}</span>
                </div>
            </div>
            <a href="{{ $downloadUrl }}" target="_blank" rel="noopener noreferrer"
                class="text-gray-500 hover:text-gray-700">
                <img src="{{ asset('subscription/assets/icons/fin_pdf_download.svg') }}" alt="download"
                    class="w-10 h-10" />
            </a>
        </div>
    @else
        <div class="flex items-center justify-center rounded-md p-3 border border-[#6E829F] bg-[#EBEBEB] h-12">
            <span class="text-gray-600">No PDF Available</span>
        </div>
    @endif
</div>
