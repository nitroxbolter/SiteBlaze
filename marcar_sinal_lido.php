<?php
$sinalFile = 'sinal.json';
if (file_exists($sinalFile)) {
    $sinalData = json_decode(file_get_contents($sinalFile), true);
    $sinalData['ativo'] = false;
    file_put_contents($sinalFile, json_encode($sinalData));
} 