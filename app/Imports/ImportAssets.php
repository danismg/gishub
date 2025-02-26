<?php

namespace App\Imports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportAssets implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Asset([
            // code, category. name, brand, total, status, user, noted
            'code' => $row[0],
            'category' => $row[1],
            'name' => $row[2],
            'brand' => $row[3],
            'total' => $row[4],
            'status' => $row[5],
            'user' => $row[6],
            'noted' => $row[7],
        ]);
    }
}
