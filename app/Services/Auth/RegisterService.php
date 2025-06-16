<?php

namespace App\Services\Auth;

use App\Models\TempUser;
use App\Repositories\TempUserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterService
{
    protected TempUserRepository $tempUserRepo;

    public function __construct(TempUserRepository $tempUserRepo)
    {
        $this->tempUserRepo = $tempUserRepo;
    }

    public function handleStepOne(array $data): TempUser
    {
        $data['temp_token'] = Str::uuid();
        $data['password'] = Hash::make($data['password']);
        return $this->tempUserRepo->create($data);
    }
}
