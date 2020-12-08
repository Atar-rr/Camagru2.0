<?php

namespace App\Src\Model\Data\Row;

class UserRow extends Row
{
    protected $id;

    protected $email;

    protected $login;

    protected $password;

    protected $notify;

    protected $activeStatus;

    protected $createDate;

    protected $updateDate;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return UserRow
     */
    public function setId(int $id): UserRow
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     * @return UserRow
     */
    public function setLogin(string $login): UserRow
    {
        $this->login = $login;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return UserRow
     */
    public function setEmail(string $email): UserRow
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return UserRow
     */
    public function setPassword(string $password): UserRow
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return bool
     */
    public function getActiveStatus(): bool
    {
        return $this->activeStatus;
    }

    /**
     * @param bool $activeStatus
     * @return UserRow
     */
    public function setActiveStatus(bool $activeStatus): UserRow
    {
        $this->activeStatus = $activeStatus;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @param string $createDate
     * @return UserRow
     */
    public function setCreateDate(string $createDate): UserRow
    {
        $this->createDate = $createDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getUpdateDate(): string
    {
        return $this->updateDate;
    }

    /**
     * @param string $updateDate
     * @return UserRow
     */
    public function setUpdateDate(string $updateDate): UserRow
    {
        $this->updateDate = $updateDate;
        return $this;
    }

    /**
     * @return int
     */
    public function getNotify(): int
    {
        return $this->notify;
    }

    /**
     * @param int $notify
     * @return UserRow
     */
    public function setNotify(int $notify): UserRow
    {
        $this->notify = $notify;
        return $this;
    }



    /**
     * @return UserRow
     */
    public static function create(): UserRow
    {
        return new self();
    }
}
