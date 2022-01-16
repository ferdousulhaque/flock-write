<?php

declare(strict_types=1);

namespace Ferdous\FileLockWrite;

use Exception;

class LockService
{

    private $fp;

    /**
     * Lock file and share pointer
     *
     * @param string $file_with_path
     * @param string $option
     * @return $fp|bool
     */
    public function lockFile($file_with_path, $option = "r+")
    {
        try {
            $this->fp = fopen($file_with_path, $option);
            if (!$this->fp) {
                throw new \RuntimeException("File permission issue");
            }

            flock($this->fp, LOCK_EX | LOCK_NB);
            // if (!flock($this->fp, LOCK_EX | LOCK_NB)) {  // acquire an exclusive lock
            //     fclose($this->fp);
            //     throw new \RuntimeException("File can not be opened with lock");
            // }

            return $this->fp;
        } catch (\RuntimeException $ex) {
            dump($ex->getMessage());
            exit(1);
        }
    }

    /**
     * Release the file pointer
     *
     * @return void
     */
    public function releaseFile(): void
    {
        if (!$this->fp) {
            throw new Exception("No File Resource Given");
        }

        flock($this->fp, LOCK_UN); // release the lock
        fclose($this->fp);
    }
}
