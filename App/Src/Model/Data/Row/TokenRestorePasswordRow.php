<?php


namespace App\Src\Model\Data\Row;


class TokenRestorePasswordRow extends Row
{
    protected $id;

    protected $userId;

    protected $token;

    protected $createdDate;

    public static function create()
    {
        return new self();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): TokenRestorePasswordRow
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
     * @return TokenRestorePasswordRow
     */
    public function setUserId(int $userId): TokenRestorePasswordRow
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
     * @return TokenRestorePasswordRow
     */
    public function setToken(string $token): TokenRestorePasswordRow
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
     * @return TokenRestorePasswordRow
     */
    public function setCreatedDate(string $createdDate): TokenRestorePasswordRow
    {
        $this->createdDate = $createdDate;
        return $this;
    }
}