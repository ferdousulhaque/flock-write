<?php

declare(strict_types=1);

namespace Ferdous\FileLockWrite;

class FileOperation
{
    /**
     * File Path
     *
     * @var string
     */
    private $filepath;

    private $data;

    /**
     *
     * @param string $filepath
     * @param string $filename
     * @param LockService $lockService
     */
    public function __construct($filepath, $filename, private LockService $lockService, $data = "")
    {
        $this->filepath = $filepath . '/' . $filename;
        $this->data = $data;
    }

    /**
     * @return void
     */
    public function truncateFile()
    {
        $fp = $this->lockService->lockFile($this->filepath);
        ftruncate($fp, 0); // truncate file
        fflush($fp);  // flush output before releasing the lock
        $this->lockService->releaseFile();
    }

    /**
     *
     * @return void
     */
    public function writeDataToFileAppend(): void
    {
        $fp = $this->lockService->lockFile($this->filepath, 'a');
        // sleep(20);
        fputs($fp, $this->data);
        fflush($fp);  // flush output before releasing the lock
        $this->lockService->releaseFile();
    }
}
