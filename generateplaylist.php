<?php
$mp3FilesDir = 'mp3_files';
$files = scandir($mp3FilesDir);

// Filter out non-MP3 files and create an array of song file paths
$songFilePaths = array();
foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'mp3') {
        $songFilePaths[] = $mp3FilesDir . '/' . $file;
    }
}

// Generate the custom URL with local file paths separated by ,
$streamURL = 'vlc://media/' . implode(',', $songFilePaths);

// Output the custom URL
echo $streamURL;
?>
