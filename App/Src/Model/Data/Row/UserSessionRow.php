<?php


namespace App\Src\Model\Data\Row;


class UserSessionRow extends Row
{
    protected $user_id;

    protected $token;

    protected $created_date;

    public static function create()
    {
        return new self();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): UserSessionRow
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     * @return UserSessionRow
     */
    public function setUserId(int $user_id): UserSessionRow
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return UserSessionRow
     */
    public function setToken(string $token): UserSessionRow
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedDate(): string
    {
        return $this->created_date;
    }

    /**
     * @param string $created_date
     * @return UserSessionRow
     */
    public function setCreatedDate(string $created_date): UserSessionRow
    {
        $this->created_date = $created_date;
        return $this;
    }
}
