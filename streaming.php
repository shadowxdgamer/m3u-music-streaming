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
                <li><a href="playlist.php">Back</a></li>
                <li>My Playlist</a></li>
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
                    echo '<a href="stream.php?play=' . rawurlencode($file) . '">' . $file . '</a>';
                    echo '</li>';
                }
            }
            ?>
        </ul>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> Music Streaming Website. All rights reserved.</p>
    </footer>
</body>
</html>
