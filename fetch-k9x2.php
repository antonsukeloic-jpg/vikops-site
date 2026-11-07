<?php
// One-off helper: pulls generated images server-side, resizes, saves to img/, then deletes itself.
header('Content-Type: text/plain; charset=utf-8');
if (($_GET['k'] ?? '') !== 'vikops-2026-k9x2') { http_response_code(403); exit("no\n"); }
$imgs = [
  'int-living'     => 'https://d8j0ntlcm91z4.cloudfront.net/user_35wPUPJ2v88iHaWPVur1ukU158G/hf_20261107_213810_040f9450-3648-49f2-90a3-0db7f0542b90.png',
  'int-spa'        => 'https://d8j0ntlcm91z4.cloudfront.net/user_35wPUPJ2v88iHaWPVur1ukU158G/hf_20261107_213810_cb9f2577-0090-4595-ba6b-df76d9faa6d6.png',
  'int-restaurant' => 'https://d8j0ntlcm91z4.cloudfront.net/user_35wPUPJ2v88iHaWPVur1ukU158G/hf_20261107_213811_eee021de-e614-4be7-aa03-b185c440c314.png',
  'int-manor'      => 'https://d8j0ntlcm91z4.cloudfront.net/user_35wPUPJ2v88iHaWPVur1ukU158G/hf_20261107_213810_0faa0d94-a1b9-44f1-b3d4-2816dcb66bb3.png',
];
$dir = __DIR__ . '/img';
foreach ($imgs as $name => $url) {
  $ch = curl_init($url);
  curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => true, CURLOPT_TIMEOUT => 60]);
  $data = curl_exec($ch); $code = curl_getinfo($ch, CURLINFO_HTTP_CODE); curl_close($ch);
  if (!$data || $code !== 200) { echo "$name: download failed ($code)\n"; continue; }
  $src = @imagecreatefromstring($data);
  if (!$src) { echo "$name: decode failed\n"; continue; }
  $w = imagesx($src); $h = imagesy($src); $maxw = 1800;
  $nw = min($w, $maxw); $nh = (int)round($h * $nw / $w);
  $dst = imagecreatetruecolor($nw, $nh);
  imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
  imageinterlace($dst, true);
  $ok = imagejpeg($dst, "$dir/$name.jpg", 84);
  imagedestroy($src); imagedestroy($dst);
  echo "$name: " . ($ok ? "saved {$nw}x{$nh} " . filesize("$dir/$name.jpg") . " bytes" : "save failed") . "\n";
}
@unlink(__FILE__);
echo "done\n";
