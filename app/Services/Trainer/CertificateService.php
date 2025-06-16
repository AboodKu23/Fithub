<?php

namespace App\Services\Trainer;

use App\Models\Certificate;
use App\Repositories\CertificateRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CertificateService
{
    protected CertificateRepository $certificateRepository;

    public function __construct(CertificateRepository $certificateRepository)
    {
        $this->certificateRepository = $certificateRepository;
    }

    public function addCertificate(array $certificate): Certificate
    {
        return $this->certificateRepository->create($certificate);
    }


}
