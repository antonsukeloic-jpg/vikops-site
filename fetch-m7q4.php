<?php
header('Content-Type: text/plain; charset=utf-8');
if (($_GET['k'] ?? '') !== 'vikops-2026-m7q4') { http_response_code(403); exit("no\n"); }
$imgs = [
  'int-kitchen' => 'https://d8j0ntlcm91z4.cloudfront.net/user_35wPUPJ2v88iHaWPVur1ukU158G/hf_20261107_215506_0528f016-2943-44df-b681-b62014b9340e.png',
  'int-hall'    => 'https://d8j0ntlcm91z4.cloudfront.net/user_35wPUPJ2v88iHaWPVur1ukU158G/hf_20261107_215506_f9975f23-4cd9-4607-89d1-9a0578149d92.png',
  'int-open'    => 'https://d8j0ntlcm91z4.cloudfront.net/user_35wPUPJ2v88iHaWPVur1ukU158G/hf_20261107_215505_bd02773c-bd89-4f89-8f26-495696e48b41.png',
];
$dir = __DIR__ . '/img';
foreach ($imgs as $name => $url) {
  $ch = curl_init($url); curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER=>true,CURLOPT_FOLLOWLOCATION=>true,CURLOPT_TIMEOUT=>60]);
  $data = curl_exec($ch); $code = curl_getinfo($ch, CURLINFO_HTTP_CODE); curl_close($ch);
  if (!$data || $code !== 200) { echo "$name: download failed ($code)\n"; continue; }
  $src = @imagecreatefromstring($data); if (!$src) { echo "$name: decode failed\n"; continue; }
  $w=imagesx($src);$h=imagesy($src);$nw=min($w,1800);$nh=(int)round($h*$nw/$w);
  $dst=imagecreatetruecolor($nw,$nh); imagecopyresampled($dst,$src,0,0,0,0,$nw,$nh,$w,$h); imageinterlace($dst,true);
  $ok=imagejpeg($dst,"$dir/$name.jpg",84); imagedestroy($src); imagedestroy($dst);
  echo "$name: ".($ok?"saved {$nw}x{$nh}":"save failed")."\n";
}
@unlink(__FILE__); echo "done\n";
