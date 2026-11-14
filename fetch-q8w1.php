<?php
header('Content-Type: text/plain; charset=utf-8');
if (($_GET['k'] ?? '') !== 'vikops-2026-q8w1') { http_response_code(403); exit("no\n"); }
$imgs = [
  'idea-virtuve'   => 'https://d8j0ntlcm91z4.cloudfront.net/user_35wPUPJ2v88iHaWPVur1ukU158G/hf_20261114_150207_7b17e8c4-cb9b-496b-92b3-4cf32716c1d3.png',
  'idea-prieskambaris' => 'https://d8j0ntlcm91z4.cloudfront.net/user_35wPUPJ2v88iHaWPVur1ukU158G/hf_20261114_150303_a008a25a-af7a-4d83-9c61-62825bc1a131.png',
  'idea-laiptai'   => 'https://d8j0ntlcm91z4.cloudfront.net/user_35wPUPJ2v88iHaWPVur1ukU158G/hf_20261114_150208_8e59f6cf-c4fb-4806-91bd-da87287aa858.png',
  'idea-zidinys'   => 'https://d8j0ntlcm91z4.cloudfront.net/user_35wPUPJ2v88iHaWPVur1ukU158G/hf_20261114_150208_ea5cc705-da79-483d-939d-2220d95e0177.png',
  'idea-stalas'    => 'https://d8j0ntlcm91z4.cloudfront.net/user_35wPUPJ2v88iHaWPVur1ukU158G/hf_20261114_150303_0b67e270-8974-4ecb-adeb-a5b0b1b83a0f.png',
  'idea-amonitas'  => 'https://d8j0ntlcm91z4.cloudfront.net/user_35wPUPJ2v88iHaWPVur1ukU158G/hf_20261114_150457_547abb8e-8b9e-4ce3-90ec-706f093cfdf4.png',
];
$dir = __DIR__ . '/img';
foreach ($imgs as $name => $url) {
  $ch = curl_init($url); curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER=>true,CURLOPT_FOLLOWLOCATION=>true,CURLOPT_TIMEOUT=>60]);
  $data = curl_exec($ch); $code = curl_getinfo($ch, CURLINFO_HTTP_CODE); curl_close($ch);
  if (!$data || $code !== 200) { echo "$name: download failed ($code)\n"; continue; }
  $src = @imagecreatefromstring($data); if (!$src) { echo "$name: decode failed\n"; continue; }
  $w=imagesx($src);$h=imagesy($src);$nw=min($w,1800);$nh=(int)round($h*$nw/$w);
  $dst=imagecreatetruecolor($nw,$nh); imagecopyresampled($dst,$src,0,0,0,0,$nw,$nh,$w,$h); imageinterlace($dst,true);
  $ok=imagejpeg($dst,"$dir/$name.jpg",86); imagedestroy($src); imagedestroy($dst);
  echo "$name: ".($ok?"saved {$nw}x{$nh}":"save failed")."\n";
}
@unlink(__FILE__); echo "done\n";
