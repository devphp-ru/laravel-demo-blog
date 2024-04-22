<?php

namespace App\Services\AdminUsers;

use App\Http\Requests\AdminUserRequest;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

final class AdminUserRepository
{
    public function getById(int $id): ?AdminUser
    {
        return AdminUser::find($id);
    }

    public function getAllAdminsWithPagination(
        Request $request,
        int $perPage,
    ): LengthAwarePaginator
    {
        $builder = AdminUser::query();

        return $builder
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(AdminUserRequest $request): ?AdminUser
    {
        $result = AdminUser::create($request->only((new AdminUser())->getFillable()));

        return $result ?? null;
    }

    public function update(
        AdminUserRequest $request,
        AdminUser $adminUser,
    ): ?AdminUser
    {
        $result = $adminUser->update($request->only($adminUser->getFillable()));

        return $result ? $adminUser : null;
    }

    public function destroy(AdminUser $adminUser): bool
    {
        return $adminUser->delete();
    }

}
