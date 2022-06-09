<?php

namespace App\Service;

class TaxCalculator
{
    const TVA20 = 20;
    const TVA10 = 10;
    const TVA5 = 5.5;

    private $inclTax = 0; // TTC
    private $exclTax = 0; // HT
    private $taxValue = 0; // Montant TVA

    private $vateRate = self::TVA20;

    public function setVateRate($vateRate): self
    {
        $this->vateRate = $vateRate;

        return $this;
    }

    /**
     * @return int
     */
    public function getVateRate(): int
    {
        return $this->vateRate;
    }

    public function getInclTax()
    {
        return $this->inclTax;
    }

    public function setInclTax($inclTax): self
    {
        $this->inclTax = $inclTax;

        return $this;
    }

    public function getExclTax()
    {
        return $this->exclTax;
    }

    public function setExclTax($exclTax): self
    {
        $this->exclTax = $exclTax;

        return $this;
    }

    public function getTaxValue()
    {
        return $this->taxValue;
    }

    public function setTaxValue($taxValue): self
    {
        $this->taxValue = $taxValue;

        return $this;
    }

    public function calculate(): void
    {
        if( $this->getInclTax() !== 0 ) {
            $this->calculateExclTax();
        } else {
            $this->calculateInclTax();
        }
    }

    private function calculateInclTax(): void {
        $this->setTaxValue($this->getExclTax() * $this->vateRate / 100);
        $this->setInclTax( $this->getExclTax() + $this->getTaxValue());
    }

    private function calculateExclTax(): void {
        $this->setExclTax($this->getInclTax() / (1 + $this->vateRate / 100));
        $this->setTaxValue($this->getInclTax() - $this->getExclTax());
    }
}
