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
    // Get the filename from the 'play' query parameter
    $filename = $_GET['play'];
    $mp3FilesDir = 'mp3_files';

    // Check if the file exists in the 'mp3_files' directory
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
<!DOCTYPE html>
<html>
<head>
    <title>My Playlist - Music Streaming Website</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.html">Back</a></li>
                <li>My Playlist</a></li>
                <li><a href="streaming.php">Stream Songs</a></li>
                <!-- Add more navigation links as needed -->
            </ul>
        </nav>
    </header>
    <main>
        <h2>My Playlist</h2>
        <ul>
            <?php
            $mp3FilesDir = 'mp3_files';
            $files = scandir($mp3FilesDir);

            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'mp3') {
                    echo '<li>';
                    echo '<a href="?play=' . urlencode($file) . '">' . $file . '</a>';
                    echo '</li>';
                }
            }
            ?>
        </ul>
        <button id="playAllBtn">Play All</button>

        <script>
            document.getElementById('playAllBtn').addEventListener('click', () => {
                const songLinks = <?php echo json_encode(glob('mp3_files/*.mp3')); ?>;
                let currentIndex = 0;

                function playNextSong() {
                    if (currentIndex < songLinks.length) {
                        const audio = new Audio(songLinks[currentIndex]);
                        audio.addEventListener('ended', () => {
                            currentIndex++;
                            playNextSong();
                        });
                        audio.play()
                            .catch(error => {
                                console.error('Error playing song:', error);
                                currentIndex++;
                                playNextSong();
                            });
                    } else {
                        currentIndex = 0; // Reset the index when all songs have been played
                    }
                }

                playNextSong();
            });
        </script>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> Music Streaming Website. All rights reserved.</p>
    </footer>
</body>
</html>
