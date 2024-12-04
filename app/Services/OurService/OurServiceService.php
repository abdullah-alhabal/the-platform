<?php

declare(strict_types=1);

namespace App\Services\OurService;

use App\Contracts\Repositories\OurService\OurServiceRepositoryInterface;
use App\DataTransferObjects\OurService\CreateOurServiceDto;
use App\DataTransferObjects\OurService\UpdateOurServiceDto;
use App\Models\OurService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class OurServiceService
{
    public function __construct(
        private readonly OurServiceRepositoryInterface $ourServiceRepository
    ) {}

    /**
     * Get all our services.
     *
     * @return Collection
     */
    public function getAllServices(): Collection
    {
        return $this->ourServiceRepository->all();
    }

    /**
     * Find an (our service) by id.
     *
     * @param  int             $id
     * @return OurService|null
     */
    public function find(int $id): ?OurService
    {
        return $this->ourServiceRepository->find($id);
    }

    /**
     * Create a new our service.
     *
     * @param  CreateOurServiceDto $dto
     * @return OurService
     */
    public function create(CreateOurServiceDto $dto): OurService
    {
        // Handle file upload if the image is an UploadedFile
        if ($dto->image instanceof UploadedFile) {
            $dto->image = $dto->image->store('images/our_services', 'public');
        }

        return $this->ourServiceRepository->create($dto);
    }

    /**
     * Update an existing our service.
     *
     * @param  int                 $id
     * @param  UpdateOurServiceDto $dto
     * @return bool
     */
    public function update(int $id, UpdateOurServiceDto $dto): bool
    {
        $ourService = $this->ourServiceRepository->find($id);

        if ($dto->image && $ourService->image) {
            // Delete old image if a new one is uploaded
            Storage::disk('public')->delete($ourService->image);
        }

        if ($dto->image instanceof UploadedFile) {
            $dto->image = $dto->image->store('images/our_services', 'public');
        }

        return $this->ourServiceRepository->update($id, $dto);
    }

    /**
     * Delete (our service) service.
     *
     * @param  int  $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $ourService = $this->ourServiceRepository->findOrFail($id);

        // Delete related image from storage
        if ($ourService->image) {
            Storage::disk('public')->delete($ourService->image);
        }

        return $this->ourServiceRepository->delete($id);
    }
}
