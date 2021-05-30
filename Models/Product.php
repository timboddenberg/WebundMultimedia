<?php


class Product
{
    private int $id;
    private String $name;
    private float $price;
    private String $image;
    private int $amount;
    private String $description;
    private String $brand;
    private String $color;
    private String $material;

    public function __construct(int $id, string $name, float $price, string $image, int $amount, string $description, string $brand, string $color, string $material)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->image = $image;
        $this->amount = $amount;
        $this->description = $description;
        $this->brand = $brand;
        $this->color = $color;
        $this->material = $material;
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

    /**
     * @return String
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param String $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return String
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @param String $brand
     */
    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    /**
     * @return String
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param String $color
     */
    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    /**
     * @return String
     */
    public function getMaterial(): string
    {
        return $this->material;
    }

    /**
     * @param String $material
     */
    public function setMaterial(string $material): void
    {
        $this->material = $material;
    }





}