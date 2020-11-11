<?php

namespace App\Models\Foundation\Traits;

trait VerifyToken
{
    /**
     * @var string
     */
    protected $verifyTokenName = 'verify_token';

    /**
     * @return bool
     */
    public function hasVerify(): bool
    {
        return is_null($this->{$this->getVerifyTokenName()});
    }

    /**
     * @param string $token
     *
     * @return bool
     */
    public function isVerifyToken(string $token): bool
    {
        return $this->{$this->getVerifyTokenName()} === $token;
    }

    /**
     * @return bool
     */
    public function markVerifyToken(): bool
    {
        return $this->forceFill([
            $this->getVerifyTokenName() => null,
        ])->save();
    }

    /**
     * @return string
     */
    public function getVerifyToken(): string
    {
        return $this->{$this->getVerifyTokenName()};
    }

    /**
     * @return string
     */
    public function getVerifyTokenName(): string
    {
        return $this->verifyTokenName;
    }

    /**
     * @return void
     */
    public function sendVerifyTokenNotification(): void
    {
        //
    }
}
