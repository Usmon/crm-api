<?php

namespace App\Models\Foundation\Traits;

trait ResetToken
{
    /**
     * @var string
     */
    protected $resetTokenName = 'reset_token';

    /**
     * @return bool
     */
    public function hasReset(): bool
    {
        return is_null($this->{$this->getResetTokenName()});
    }

    /**
     * @param string $token
     *
     * @return bool
     */
    public function isResetToken(string $token): bool
    {
        return $this->{$this->getResetTokenName()} === $token;
    }

    /**
     * @return bool
     */
    public function markResetToken(): bool
    {
        return $this->forceFill([
            $this->getResetTokenName() => null,
        ])->save();
    }

    /**
     * @return string
     */
    public function getResetToken(): string
    {
        return $this->{$this->getResetTokenName()};
    }

    /**
     * @return string
     */
    public function getResetTokenName(): string
    {
        return $this->resetTokenName;
    }

    /**
     * @return void
     */
    public function sendResetTokenNotification(): void
    {
        //
    }
}
