<?php

use PHPUnit\Framework\TestCase;
use Ferdous\FileLockWrite\FileOperation;
use Ferdous\FileLockWrite\LockService;

class WriteTest extends TestCase
{
    /**
     * @dataProvider dataProviderForWrite
     */
    public function testWrite(string $filename, string $filepath, $actual, $expected): void
    {
        $lockService = new LockService();
        $opObj = new FileOperation($filepath, $filename,  $lockService, $expected);
        // $opObj->truncateFile();
        $opObj->writeDataToFileAppend();
        $actual = $opObj->readDataFromFile();
        if (is_array($expected)) {
            $expected = json_encode($expected);
        }
        $this->assertEquals($expected, $actual);
        $opObj->truncateFile();
    }

    public function dataProviderForWrite(): array
    {
        $filepath = realpath('./storage');
        return [
            ['test.csv', $filepath, [], '[]'],
            ['test.csv', $filepath, 'test', 'test'],
            ['test.csv', $filepath, 0, '0'],
        ];
    }
}
