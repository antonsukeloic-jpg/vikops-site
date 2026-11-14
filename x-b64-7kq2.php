<?php
if (($_GET['k'] ?? '') !== 'v7kq2m') { http_response_code(404); exit; }
$names = ['virtuve','prieskambaris','laiptai','zidinys','stalas','amonitas'];
@mkdir(__DIR__.'/b64', 0755);
$out = [];
foreach ($names as $n) {
  $f = __DIR__."/img/idea-$n.jpg";
  if (!is_file($f)) { $out[] = "$n: missing"; continue; }
  $b = base64_encode(file_get_contents($f));
  $parts = str_split($b, 150000);
  foreach ($parts as $i => $p) file_put_contents(__DIR__."/b64/idea-$n.$i.txt", $p);
  $out[] = "$n: ".filesize($f)." bytes, ".count($parts)." parts";
}
echo implode("\n", $out);
