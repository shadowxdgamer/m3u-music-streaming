<?php
// Function to stream audio file to the client
function streamAudio($filePath) {
    // Set appropriate headers for audio streaming
    header('Content-Type: audio/mpeg');
    header('Content-Length: ' . filesize($filePath));

    // Stream the file in small chunks to the client
    $chunkSize = 1024 * 1024; // 1 MB
    $handle = fopen($filePath, 'rb');
    while (!feof($handle)) {
        echo fread($handle, $chunkSize);
        ob_flush();
        flush();
    }
    fclose($handle);
}

// Check if the 'play' query parameter is set in the URL
if (isset($_GET['play'])) {
    // Get the filename from the 'play' query parameter and sanitize it for security
    $filename = basename($_GET['play']);
    $mp3FilesDir = 'mp3_files';

    // Check if the file exists in the 'mp3' directory
    $filePath = $mp3FilesDir . '/' . $filename;
    if (file_exists($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'mp3') {
        // Stream the audio file to the client
        streamAudio($filePath);
        exit();
    } else {
        // File not found or invalid format
        http_response_code(404);
        exit();
    }
}
?>
