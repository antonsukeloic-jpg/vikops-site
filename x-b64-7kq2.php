<?php
if (($_GET['k'] ?? '') !== 'v7kq2m') { http_response_code(404); exit; }
@mkdir(__DIR__.'/b64', 0755);
$f = __DIR__."/img/idea-amonitas.jpg";
$b = base64_encode(file_get_contents($f));
$n = 7; $len = (int)ceil(strlen($b)/$n);
$parts = str_split($b, $len);
foreach ($parts as $i => $p) file_put_contents(__DIR__."/b64/am.$i.txt", $p);
echo strlen($b)." chars, ".count($parts)." parts of $len";
