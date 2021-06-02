<?php


class ShoppingCartItem
/*
 * This class is the template for the shoppingitem
 */
{
    private string $id;
    private string $name;
    private int $amount;
    private String $picture;

    public function setPicture($picture): void{
        $this->picture = $picture;
    }

    public function getPicture(): string{
        return $this->picture;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

}