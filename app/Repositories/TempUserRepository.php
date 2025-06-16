<?php

namespace App\Repositories;

use App\Models\TempCertificate;
use App\Models\TempUser;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class TempUserRepository
{
    // --------------------- Create Temporary User ---------------------
    public function create(array $data): TempUser
    {
        return TempUser::create($data);
    }


    // --------------------- Find Temporary User By Token ---------------------
    public function getByToken(string $token): ?TempUser
    {
        return TempUser::where('temp_token', $token)->firstOrFail();
    }

    // --------------------- Delete Temporary User ---------------------
    public function delete(TempUser $tempUser): void
    {
        $tempUser->delete();
    }


}
