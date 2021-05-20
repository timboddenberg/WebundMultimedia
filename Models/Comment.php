<?php


class Comment
{
    private int $id;
    private String $inhalt;
    private String $productId;
    private int $userId;
    public function __construct(int $id, string $inhalt, string $productId, int $userId)
    {
        $this->id = $id;
        $this->inhalt = $inhalt;
        $this->productId = $productId;
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getInhalt(): string
    {
        return $this->inhalt;
    }

    /**
     * @param string $inhalt
     */
    public function setInhalt(string $inhalt): void
    {
        $this->inhalt = $inhalt;
    }

    /**
     * @return string
     */
    public function getProductId(): string
    {
        return $this->productId;
    }

    /**
     * @param string $productId
     */
    public function setProductId(string $productId): void
    {
        $this->productId = $productId;
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
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }




}