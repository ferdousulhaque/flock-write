<?php

use PHPUnit\Framework\TestCase;
use Ferdous\FileLockWrite\FileOperation;
use Ferdous\FileLockWrite\LockService;

class TruncateTest extends TestCase
{
    /**
     *
     * @param string $filename
     * @param string $filepath
     * @return void
     */
    public function testTruncate(): void
    {
        $filename = 'test.csv';
        $filepath = realpath('./storage');

        $lockService = new LockService();
        $opObj = new FileOperation($filepath, $filename,  $lockService);
        $opObj->truncateFile();
        $actual = $opObj->readDataFromFile();
        $this->assertEquals("", $actual);
    }
}
