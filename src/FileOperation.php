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
     * @param string $data
     */
    public function __construct($filepath, $filename, private LockService $lockService, $data = "")
    {
        $this->filepath = $filepath . '/' . $filename;
        if (is_array($data)) {
            $data = json_encode($data);
        }

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
    public function writeDataToFileAppend($sleep = 0): void
    {
        $fp = $this->lockService->lockFile($this->filepath, 'a');
        sleep($sleep);
        fputs($fp, strval($this->data));
        fflush($fp);  // flush output before releasing the lock
        $this->lockService->releaseFile();
    }

    /**
     *
     * @return string
     */
    public function readDataFromFile(): string
    {
        $this->lockService->lockFile($this->filepath, 'r+');
        $lines = file_get_contents($this->filepath);
        $this->lockService->releaseFile();
        return $lines;
    }
}
