<?php
$mp3FilesDir = 'mp3_files';
$files = scandir($mp3FilesDir);

// Filter out non-MP3 files and create an array of song filenames
$songFilenames = array();
foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'mp3') {
        $songFilenames[] = urlencode($file);
    }
}

// Generate the custom URL with the song filenames separated by |
$streamURL = 'https://musicworld123321.000webhostapp.com/playlist.php?play=' . implode('|', $songFilenames);

// Output the custom URL
echo $streamURL;
?>
