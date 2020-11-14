<?php

namespace App\Models\Foundation\Traits;

use Illuminate\Contracts\Auth\Access\Gate;

trait Authorizable
{
    /**
     * @param iterable|string $abilities
     *
     * @param array|mixed $arguments
     *
     * @return bool
     */
    public function can($abilities, $arguments = []): bool
    {
        return app(Gate::class)->forUser($this)->check($abilities, $arguments);
    }

    /**
     * @param iterable|string $abilities
     *
     * @param array|mixed $arguments
     *
     * @return bool
     */
    public function canAny($abilities, $arguments = []): bool
    {
        return app(Gate::class)->forUser($this)->any($abilities, $arguments);
    }

    /**
     * @param iterable|string $abilities
     *
     * @param array|mixed $arguments
     *
     * @return bool
     */
    public function cant($abilities, $arguments = []): bool
    {
        return ! $this->can($abilities, $arguments);
    }

    /**
     * @param iterable|string $abilities
     *
     * @param array|mixed $arguments
     *
     * @return bool
     */
    public function cannot($abilities, $arguments = []): bool
    {
        return $this->cant($abilities, $arguments);
    }
}
