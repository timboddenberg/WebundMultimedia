<?php


class Product
{
    private int $id;
    private String $name;
    private float $price;
    private String $image;
    private int $amount;

    public function __construct(int $id, string $name, float $price, string $image, int $amount)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->image = $image;
        $this->amount = $amount;
    }

    public function getName(): string
    {
        return $this->name;
    }


    public function setName(string $name): void
    {
        $this->name = $name;
    }


    public function getPrice(): float
    {
        return $this->price;
    }


    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }


    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }



}