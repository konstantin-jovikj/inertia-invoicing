<?php

namespace App\Services;

use App\Models\Document;
use App\Models\Tax;

class TaxCalculationService
{

    public function calculateDocumentTotals(Document $document, $taxId, $discountRate, $advancePayment)
    {
        $tax = Tax::find($taxId);
        $taxRate = $tax ? $tax->tax_rate : 0;
        $discountRate = $discountRate ?? $document->discount;

        if ($document->curency_id == 1) {
            return $this->calculateDomesticTotals(
                $document,
                $discountRate,
                $taxRate,
                $advancePayment
            );
        }

        return $this->calculateForeignTotals(
            $document,
            $discountRate,
            $taxRate,
            $advancePayment
        );
    }

    private function calculateDomesticTotals($document, $discountRate, $taxRate, $advancePayment)
    {
        $discountAmount = round($document->total * ($document->discount / 100));
        $taxAmount = round(($document->total - $document->discount_amount) * ($document->tax->tax_rate / 100));
        $total = round($document->total - $discountAmount + $taxAmount);
        $grandTotal = round($total - $advancePayment);
        $advancedBase = round($grandTotal / (1 + $taxRate / 100));
        $advancedTax = round($grandTotal - $advancedBase);

        return [
            'discount_amount' => $discountAmount,
            'tax_amount' => $taxAmount,
            'total_with_tax_and_discount' => $total,
            'grand_total' => $grandTotal,
            'advanced_payment_tax' => $advancedTax,
            'advanced_payment_base' => $advancedBase,
        ];
    }
    private function calculateForeignTotals($document, $discountRate, $taxRate, $advancePayment)
    {
        $discountAmount = $document->total * ($document->discount / 100);
        $taxAmount = ($document->total - $document->discount_amount) * ($document->tax->tax_rate / 100);
        $total = $document->total - $discountAmount + $taxAmount;
        $grandTotal = $total - $advancePayment;
        $advancedBase = $grandTotal / (1 + $taxRate / 100);
        $advancedTax = $grandTotal - $advancedBase;

        return [
            'discount_amount' => $discountAmount,
            'tax_amount' => $taxAmount,
            'total_with_tax_and_discount' => $total,
            'grand_total' => $grandTotal,
            'advanced_payment_tax' => $advancedTax,
            'advanced_payment_base' => $advancedBase,
        ];
    }


};