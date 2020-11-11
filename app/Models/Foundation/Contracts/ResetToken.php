<?php

namespace App\Models\Foundation\Contracts;

interface ResetToken
{
    /**
     * @return bool
     */
    public function hasReset(): bool;

    /**
     * @param string $token
     *
     * @return bool
     */
    public function isResetToken(string $token): bool;

    /**
     * @return bool
     */
    public function markResetToken(): bool;

    /**
     * @return string
     */
    public function getResetToken(): string;

    /**
     * @return string
     */
    public function getResetTokenName(): string;

    /**
     * @return void
     */
    public function sendResetTokenNotification(): void;
}
