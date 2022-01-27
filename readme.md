# File Lock Write Operation Using Flock

This library is for simultaneous write on a single file with locking mechanism by PHP flock function. It uses the unix semaphore to lock the file and hence a safe application to store data in a single file shared by multiple methods.

## Installation
This library is compatible with all PHP version starting from 4 to 8. Just run the following command to install.
```
composer require ferdous/flock-write
```
## How to add
Add the following operations to the namespace
```php
use Ferdous\FileLockWrite\FileOperation;
use Ferdous\FileLockWrite\LockService;
```
Now you are ready to add the functionality by creating the object

```php
$lockService = new LockService();
$opObj = new FileOperation($filepath, $filename,  $lockService, $data);
```

### *Operations*
- Truncate File
    ```php 
    $opObj->truncateFile() 
    ```
- Write File *with Exclude Lock*
    ```php 
    $opObj->writeDataToFileAppend() 
    ```
- Read File *with Shared Lock* 
    ```php 
    $opObj->readDataFromFile() 
    ```
## Unit Tests

For checking the unit tests run
```shell
./vendor/bin/phpunit . --testdox --color
```