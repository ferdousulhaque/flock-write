<?php

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
*/
require __DIR__ . '/vendor/autoload.php';

use Ferdous\FileLockWrite\FileOperation;
use Ferdous\FileLockWrite\LockService;

$filename = 'reporting.csv';
$filepath = realpath('./storage');
$data = '1,100,200,w300';

$lockService = new LockService();
$opObj = new FileOperation($filepath, $filename,  $lockService, $data);
// $opObj->truncateFile();
$opObj->writeDataToFileAppend();
