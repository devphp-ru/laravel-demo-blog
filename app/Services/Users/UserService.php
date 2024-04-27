<?php

namespace App\Services\Users;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

final class UserService
{
    public function __construct(private UserRepository $userRepository) {}

    public function getAllAdminsWithPagination(
        Request $request,
        int $perPage,
    ): LengthAwarePaginator
    {
        return $this->userRepository->getAllAdminsWithPagination($request, $perPage);
    }

    public function create(UserRequest $request): ?User
    {
        $request->merge(['is_banned' => $request->input('is_banned', 0)]);

        return $this->userRepository->create($request);
    }

    public function update(
        UserRequest $request,
        User $user,
    ): ?User
    {
        $request->merge(['is_banned' => $request->input('is_banned', 0)]);
        $request->merge(['password' => $request->input('password') ?? $user->password]);

        return $this->userRepository->update($request, $user);
    }

    public function destroy(User $user): bool
    {
        return $this->userRepository->destroy($user);
    }

}
