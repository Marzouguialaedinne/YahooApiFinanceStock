<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockRepository::class)]
class Stock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 5)]
    private ?string $symbol = null;

    #[ORM\Column(length: 5)]
    private ?string $region = null;

    #[ORM\Column(length: 50)]
    private ?string $shortName = null;

    #[ORM\Column(length: 50)]
    private ?string $exchangeName = null;

    #[ORM\Column(length: 5)]
    private ?string $currency = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?float $pricePreviousClose = null;

    #[ORM\Column]
    private ?float $priceChange = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): static
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): static
    {
        $this->region = $region;

        return $this;
    }

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function setShortName(string $shortName): static
    {
        $this->shortName = $shortName;

        return $this;
    }

    public function getExchangeName(): ?string
    {
        return $this->exchangeName;
    }

    public function setExchangeName(string $exchangeName): static
    {
        $this->exchangeName = $exchangeName;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getPricePreviousClose(): ?float
    {
        return $this->pricePreviousClose;
    }

    public function setPricePreviousClose(float $pricePreviousClose): static
    {
        $this->pricePreviousClose = $pricePreviousClose;

        return $this;
    }

    public function getPriceChange(): ?float
    {
        return $this->priceChange;
    }

    public function setPriceChange(float $priceChange): static
    {
        $this->priceChange = $priceChange;

        return $this;
    }
}
