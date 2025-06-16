<?php

namespace App\Repositories;

use App\Models\TempCertificate;
use Illuminate\Support\Collection;

class TempCertificateRepository
{
    // --------------------- Create Temporary Certificate ---------------------
    public function create(array $data) : TempCertificate
    {
        return TempCertificate::create($data);
    }


    // --------------------- Find Temporary Certificates By Token ---------------------
    public function getByToken(string $token) : Collection
    {
        return TempCertificate::where('temp_user_token', $token)->get();
    }


    // --------------------- Delete Temporary User ---------------------
    public function delete($tempCertificate) : void
    {
        $tempCertificate->each->delete();
    }
}
