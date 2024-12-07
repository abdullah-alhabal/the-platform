<?php

namespace App\Traits;

use App\Domain\Course\Enums\Permission;
use Illuminate\Support\Collection;

trait HasPermissions
{
    public function hasPermission(string $permission): bool
    {
        return $this->permissions->contains($permission)
            || $this->roles->flatMap->permissions->contains($permission);
    }

    public function hasAnyPermission(array $permissions): bool
    {
        return $this->permissions->intersect($permissions)->isNotEmpty()
            || $this->roles->flatMap->permissions->intersect($permissions)->isNotEmpty();
    }

    public function hasAllPermissions(array $permissions): bool
    {
        $userPermissions = $this->getAllPermissions();
        return collect($permissions)->every(fn($permission) => $userPermissions->contains($permission));
    }

    public function getAllPermissions(): Collection
    {
        return $this->permissions->merge($this->roles->flatMap->permissions)->unique();
    }

    public function grantPermission(string|Permission $permission): self
    {
        $permissionValue = $permission instanceof Permission ? $permission->value : $permission;
        if (!$this->hasPermission($permissionValue)) {
            $this->permissions()->attach($permissionValue);
            $this->load('permissions');
        }
        return $this;
    }

    public function revokePermission(string|Permission $permission): self
    {
        $permissionValue = $permission instanceof Permission ? $permission->value : $permission;
        $this->permissions()->detach($permissionValue);
        $this->load('permissions');
        return $this;
    }

    public function syncPermissions(array $permissions): self
    {
        $permissionValues = collect($permissions)
            ->map(fn($permission) => $permission instanceof Permission ? $permission->value : $permission)
            ->all();

        $this->permissions()->sync($permissionValues);
        $this->load('permissions');
        return $this;
    }

    public function hasRole(string $role): bool
    {
        return $this->roles->contains('name', $role);
    }

    public function hasAnyRole(array $roles): bool
    {
        return $this->roles->pluck('name')->intersect($roles)->isNotEmpty();
    }

    public function assignRole(string $role): self
    {
        if (!$this->hasRole($role)) {
            $this->roles()->attach($role);
            $this->load('roles');
        }
        return $this;
    }

    public function removeRole(string $role): self
    {
        $this->roles()->detach($role);
        $this->load('roles');
        return $this;
    }

    public function syncRoles(array $roles): self
    {
        $this->roles()->sync($roles);
        $this->load('roles');
        return $this;
    }
}
