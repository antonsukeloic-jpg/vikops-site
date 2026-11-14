<?php
if (($_GET['k'] ?? '') !== 'p3z8vq') { http_response_code(404); exit; }
$n = 0;
foreach (glob(__DIR__.'/b64/*') as $f) { @unlink($f); $n++; }
@rmdir(__DIR__.'/b64');
echo "removed $n, b64 exists: ".(is_dir(__DIR__.'/b64') ? 'yes' : 'no');
@unlink(__FILE__);
