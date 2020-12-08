<?php


namespace App\Src\Model\Data\Row;


class TokenActivateUserRow extends Row
{
    protected $id;

    protected $userId;

    protected $token;

    protected $createdDate;

    public static function create(): TokenActivateUserRow
    {
        return new self();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): TokenActivateUserRow
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return TokenActivateUserRow
     */
    public function setUserId(int $userId): TokenActivateUserRow
    {
        $this->userId = $userId;
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
     * @return TokenActivateUserRow
     */
    public function setToken(string $token): TokenActivateUserRow
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedDate(): string
    {
        return $this->createdDate;
    }

    /**
     * @param string $createdDate
     * @return TokenActivateUserRow
     */
    public function setCreatedDate(string $createdDate): TokenActivateUserRow
    {
        $this->createdDate = $createdDate;
        return $this;
    }
}
