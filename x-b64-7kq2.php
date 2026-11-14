<?php
if (($_GET['k'] ?? '') !== 'v7kq2m') { http_response_code(404); exit; }
$gone = [];
foreach (glob(__DIR__.'/b64/*') as $f) { @unlink($f); $gone[] = basename($f); }
@rmdir(__DIR__.'/b64');
foreach (glob(__DIR__.'/img/idea-*.jpg') as $f) { @unlink($f); $gone[] = 'img/'.basename($f); }
echo "removed ".count($gone).": ".implode(', ', $gone);
echo "\nb64 dir exists: ".(is_dir(__DIR__.'/b64') ? 'yes' : 'no');
@unlink(__FILE__);
