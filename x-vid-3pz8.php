<?php
if (($_GET['k'] ?? '') !== 'p3z8vq') { http_response_code(404); exit; }
set_time_limit(300);
$base = 'https://d8j0ntlcm91z4.cloudfront.net/user_35wPUPJ2v88iHaWPVur1ukU158G/';
$vids = [
  'v1-makro'   => 'hf_20261114_153418_37830675-8774-4514-9e98-08a3be0b60d5.mp4',
  'v2-reveal'  => 'hf_20261114_153418_e6dee8ca-e382-4239-95f2-398a78412e67.mp4',
  'v4-laiptai' => 'hf_20261114_154336_7ed0154a-b52e-4b07-9ea2-e641cfbb4c8d.mp4',
  'v5-virtuve' => 'hf_20261114_154335_f7fcd3ff-525f-40b4-95cd-e5a859f67127.mp4',
];
$chunk = (int)($_GET['chunk'] ?? 1000000);
@mkdir(__DIR__.'/b64', 0755); foreach (glob(__DIR__.'/b64/*') as $g) @unlink($g);
$out = [];
foreach ($vids as $n => $f) {
  $ch = curl_init($base.$f);
  curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER=>1, CURLOPT_FOLLOWLOCATION=>1, CURLOPT_TIMEOUT=>120]);
  $data = curl_exec($ch); $code = curl_getinfo($ch, CURLINFO_HTTP_CODE); curl_close($ch);
  if ($code != 200 || !$data) { $out[] = "$n: HTTP $code"; continue; }
  $b = base64_encode($data);
  $n = (int)ceil(strlen($b)/$chunk); $parts = str_split($b, (int)ceil(strlen($b)/$n));
  foreach ($parts as $i => $p) file_put_contents(__DIR__."/b64/$n.$i.txt", $p);
  $out[] = "$n: ".strlen($data)." bytes, ".count($parts)." parts, md5 ".md5($data);
}
echo implode("\n", $out);
