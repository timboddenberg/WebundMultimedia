<?php


class Rating
{
    private int $ratingId;
    private int $rating;
    private int $productId;
    private int $userId;

    /**
     * Rating constructor.
     * @param int $ratingId
     * @param int $rating
     * @param int $productId
     * @param int $userId
     */
    public function __construct(int $ratingId, int $rating, int $productId, int $userId)
    {
        $this->ratingId = $ratingId;
        $this->rating = $rating;
        $this->productId = $productId;
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getRatingId(): int
    {
        return $this->ratingId;
    }

    /**
     * @param int $ratingId
     */
    public function setRatingId(int $ratingId): void
    {
        $this->ratingId = $ratingId;
    }

    /**
     * @return int
     */
    public function getRating(): int
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     */
    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @param int $productId
     */
    public function setProductId(int $productId): void
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