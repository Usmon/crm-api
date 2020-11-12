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
    public function getAuthIdentifierName()
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
    public function getAuthPassword()
    {
        return $this->{$this->getAuthPasswordName()};
    }

    /**
     * @return string
     */
    public function getRememberToken()
    {
        return $this->{$this->getRememberTokenName()};
    }

    /**
     * @param string $value
     *
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->{$this->getRememberTokenName()} = $value;
    }

    /**
     * @return string
     */
    public function getAuthPasswordName()
    {
        return $this->authPasswordName;
    }

    /**
     * @return string
     */
    public function getRememberTokenName()
    {
        return $this->rememberTokenName;
    }
}
