@props(['qrCode'])

<div class="flex flex-col items-center justify-center p-4">
    <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code" class="w-64 h-64">
    <p class="mt-4 text-sm text-gray-500">Scan this QR code to view document details</p>
</div> 