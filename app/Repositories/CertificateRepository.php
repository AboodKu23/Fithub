<?php

namespace App\Repositories;

use App\Models\Certificate;
use phpDocumentor\Reflection\Types\Collection;

class CertificateRepository
{
    public function create(array $data): Certificate
    {
        return Certificate::create($data);
    }

    public function update(Certificate $certificate, array $data): bool
    {
        return $certificate->update($data);
    }

    public function delete(Certificate $certificate): bool
    {
        return $certificate->delete();
    }

    public function getCertificateByTrainerId(int $trainerId): Collection
    {
        return Certificate::where('trainer_id', $trainerId)->get();
    }

    public function getCertificateById(int $certificateId, int $trainerId): ?Certificate
    {
        return Certificate::where('id', $certificateId)
            ->where('trainer_id', $trainerId)
            ->first();
    }
}
