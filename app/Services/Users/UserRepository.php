<?php

namespace App\Services\Users;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class UserRepository
{
    public function getAllAdminsWithPagination(
        Request $request,
        int $perPage,
    ): LengthAwarePaginator
    {
        $builder = User::query();
        $builder = $this->adminSearch($request, $builder);

        return $builder
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    private function adminSearch(
        Request $request,
        Builder $builder,
    ): Builder
    {
        if ($request->filled('q') ) {
            $query = \trim($request->input('q'));
            $query = \preg_replace('#[^0-9-a-zA-ZА-Яа-яёЁ@\.]#u', ' ', $query);
            $query = \preg_replace('#\s+#u', ' ', $query);
            $query = \mb_strtolower(\trim($query));
            $like = "%{$query}%";

            $builder->orWhere(DB::raw('lower(name)'), 'like', $like);
            $builder->orWhere(DB::raw('lower(email)'), 'like', $like);
        }

        return $builder;
    }

    public function create(UserRequest $request): ?User
    {
        $result = User::create($request->only((new User())->getFillable()));

        return $result ?? null;
    }

    public function update(
        UserRequest $request,
        User $user,
    ): ?User
    {
        $result = $user->update($request->only($user->getFillable()));

        return $result ? $user : null;
    }

    public function destroy(User $user): bool
    {
        return $user->delete();
    }

}
