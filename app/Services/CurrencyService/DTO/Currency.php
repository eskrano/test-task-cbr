<?php

namespace App\Services\CurrencyService\DTO;

class Currency
{
    /**
     * @var string
     */
    protected string $char_code;

    /**
     * @var int
     */
    protected int $nominal;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var float
     */
    protected float $value;

    /**
     * @return string
     */
    public function getCharCode(): string
    {
        return $this->char_code;
    }

    /**
     * @param $char_code
     * @return $this
     */
    public function setCharCode($char_code): Currency
    {
        $this->char_code = $char_code;
        return $this;
    }

    /**
     * @return int
     */
    public function getNominal(): int
    {
        return $this->nominal;
    }

    /**
     * @param mixed $nominal
     * @return Currency
     */
    public function setNominal($nominal): Currency
    {
        $this->nominal = $nominal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name): Currency
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     * @return $this
     */
    public function setValue(float $value): Currency
    {
        $this->value = $value;
        return $this;
    }
}
