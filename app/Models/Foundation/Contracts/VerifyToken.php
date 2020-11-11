<?php

namespace App\Models\Foundation\Contracts;

interface VerifyToken
{
    /**
     * @return bool
     */
    public function hasVerify(): bool;

    /**
     * @param string $token
     *
     * @return bool
     */
    public function isVerifyToken(string $token): bool;

    /**
     * @return bool
     */
    public function markVerifyToken(): bool;

    /**
     * @return string
     */
    public function getVerifyToken(): string;

    /**
     * @return string
     */
    public function getVerifyTokenName(): string;

    /**
     * @return void
     */
    public function sendVerifyTokenNotification(): void;
}
