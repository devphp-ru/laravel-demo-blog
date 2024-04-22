<?php

namespace App\Services\AdminUsers;

use App\Http\Requests\AdminUserRequest;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

final class AdminUserService
{
    public function __construct(private AdminUserRepository $adminUserRepository) {}

    public function getById(int $id): ?AdminUser
    {
        return $this->adminUserRepository->getById($id);
    }

    public function getAllAdminsWithPagination(
        Request $request,
        int $perPage,
    ): LengthAwarePaginator
    {
        return $this->adminUserRepository->getAllAdminsWithPagination($request, $perPage);
    }

    public function create(AdminUserRequest $request): ?AdminUser
    {
        $request->merge(['is_banned' => $request->input('is_banned', 0)]);

        return $this->adminUserRepository->create($request);
    }

    public function update(
        AdminUserRequest $request,
        AdminUser $adminUser,
    ): ?AdminUser
    {
        $request->merge(['is_banned' => $request->input('is_banned', 0)]);
        $request->merge(['password' => $request->input('password') ?? $adminUser->password]);

        return $this->adminUserRepository->update($request, $adminUser);
    }

    public function destroy(AdminUser $adminUser): bool
    {
        return $this->adminUserRepository->destroy($adminUser);
    }

}
