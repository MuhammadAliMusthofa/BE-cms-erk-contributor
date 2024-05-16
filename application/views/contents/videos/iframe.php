<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IFrame dengan PHP dan AR</title>

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        iframe {
            width: 100%;
            height: 100vh;
        }

        @media (max-width: 600px) {
            iframe {
                height: 300px; /* Atur tinggi iframe untuk tampilan mobile */
            }
        }
    </style>
</head>
<body>

<?php
// URL yang ingin ditampilkan di dalam iframe
$iframeSrc = 'https://makmunzain.github.io/organdalam/';

// Output tag iframe dengan dukungan AR
echo '<iframe src="' . $iframeSrc . '" frameborder="0" allowfullscreen allow="xr-spatial-tracking"></iframe>';
?>

</body>
</html>
