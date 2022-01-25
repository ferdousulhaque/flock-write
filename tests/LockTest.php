<?php

use PHPUnit\Framework\TestCase;
use Ferdous\FileLockWrite\FileOperation;
use Ferdous\FileLockWrite\LockService;

class LockTest extends TestCase
{
    private $lockService;

    /**
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->lockService = new LockService();
    }

    /**
     * @dataProvider dataProviderForLock
     */
    public function testLock(string $filename, string $filepath, $firstData, $secondData, $expected): void
    {
        $this->writeWithSleep($filename, $filepath, $firstData);
        $this->writeWithoutSleep($filename, $filepath, $secondData);
        $opObj = new FileOperation($filepath, $filename,  $this->lockService);
        $actual = $opObj->readDataFromFile();
        $this->assertEquals($expected, $actual);
    }

    private function writeWithSleep(string $filename, string $filepath, $data)
    {
        $opObj = new FileOperation($filepath, $filename,  $this->lockService, $data);
        $opObj->truncateFile();
        $opObj->writeDataToFileAppend(3);
    }

    private function writeWithoutSleep(string $filename, string $filepath, $data)
    {
        $opObj = new FileOperation($filepath, $filename,  $this->lockService, $data);
        $opObj->writeDataToFileAppend();
    }

    public function dataProviderForLock(): array
    {
        $filepath = realpath('./storage');
        return [
            ['lock.csv', $filepath, '-firstData/', '-secondData/', '-firstData/-secondData/'],
        ];
    }
}
