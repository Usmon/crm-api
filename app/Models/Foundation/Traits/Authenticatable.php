<?php

namespace App\Models\Foundation\Traits;

trait Authenticatable
{
    /**
     * @var string
     */
    protected $authPasswordName = 'password';

    /**
     * @var string
     */
    protected $rememberTokenName = 'remember_token';

    /**
     * @return string
     */
    public function getAuthIdentifierName(): string
    {
        return $this->getKeyName();
    }

    /**
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    /**
     * @return string
     */
    public function getAuthPassword(): string
    {
        return $this->{$this->getAuthPasswordName()};
    }

    /**
     * @return string
     */
    public function getRememberToken(): string
    {
        return $this->{$this->getRememberTokenName()};
    }

    /**
     * @param string $value
     *
     * @return void
     */
    public function setRememberToken(string $value): void
    {
        $this->{$this->getRememberTokenName()} = $value;
    }

    /**
     * @return string
     */
    public function getAuthPasswordName(): string
    {
        return $this->authPasswordName;
    }

    /**
     * @return string
     */
    public function getRememberTokenName(): string
    {
        return $this->rememberTokenName;
    }
}
