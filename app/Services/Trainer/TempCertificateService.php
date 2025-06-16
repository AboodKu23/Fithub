<?php

namespace App\Services\Trainer;

use App\Models\Certificate;
use App\Models\TempCertificate;
use App\Repositories\TempCertificateRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class TempCertificateService
{
    protected TempCertificateRepository $tempCertificateRepository;

    public function __construct(TempCertificateRepository $tempCertificateRepository)
    {
        $this->tempCertificateRepository = $tempCertificateRepository;
    }

    public function addCertificate(array $data): TempCertificate
    {
        if (isset($data['certificate_file']) && $data['certificate_file'] instanceof UploadedFile)
        {
            $data['certificate_file'] = $this->storeFile($data['certificate_file']);
        }

        return $this->tempCertificateRepository->create([
            'token' => Str::uuid(),
            'temp_user_token'       => $data['temp_user_token'],
            'certificate_name'      => $data['certificate_name'],
            'issuing_organization'  => $data['issuing_organization'],
            'issue_date'            => $data['issue_date'],
            'expiry_date'           => $data['expiry_date'] ?? null,
            'certificate_file'      => $data['certificate_file'] ?? null,
        ]);
    }

    public function storeFile(UploadedFile $file): string
    {
        return $file->store('certificate', 'public');
    }

    public function deleteTempCertificate($tempCertificate): void
    {
         $this->tempCertificateRepository->delete($tempCertificate);
    }

    public function getTempCertificate(string $token): Collection
    {
        return $this->tempCertificateRepository->getByToken($token);
    }
}
