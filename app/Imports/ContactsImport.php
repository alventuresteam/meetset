<?php

namespace App\Imports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use Maatwebsite\Excel\Concerns\WithUpserts;

class ContactsImport implements ToModel, WithUpserts, WithUpsertColumns
{
    /**
     * @param array $row
     *
     * @return Contact|null
     */
    public function model(array $row): Contact|null
    {
        if (!isset($row[0]) && !isset($row[1]) && !isset($row[2])) {
            return null;
        }
        return new Contact([
            'name' => $row[0],
            'surname' => $row[1],
            'email' => $row[2]
        ]);
    }

    /**
     * @return string|array
     */
    public function uniqueBy(): array|string
    {
        return 'email';
    }

    public function upsertColumns(): array
    {
        return ['name', 'surname', 'email'];
    }
}
