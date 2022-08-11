<?php declare(strict_types=1);

namespace App\Service;


class ImportData
{

    public function __construct(private readonly string $fileLocation)
    {
    }

    public function storeImportData(string $username): void
    {
        file_put_contents($this->fileLocation, json_encode(['username' => $username, 'dateTime' => date('c')]), JSON_THROW_ON_ERROR);
    }

    /**
     * @return array{username: string, dateTime: string}
     */
    public function fetchLatestImportData(): array
    {
        return json_decode(file_get_contents($this->fileLocation), true, JSON_THROW_ON_ERROR);
    }

}
