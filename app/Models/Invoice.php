<?php

namespace App\Models;

use App\Core\Model;

class Invoice extends Model {
    protected static string $table = 'invoices';
    protected static array $fillable = [
        'invoice_number',
        'client_name',
        'client_email',
        'client_address',
        'currency_code',
        'currency_symbol',
        'issue_date',
        'due_date',
        'subtotal',
        'tax_rate',
        'tax_amount',
        'total_amount',
        'notes',
        'status',
        'payment_date',
        'payment_method'
    ];

    /**
     * Generate the next unique invoice number
     */
    public static function generateInvoiceNumber(): string {
        $prefix = 'INV-' . date('Y') . '-';
        
        $sql = "SELECT invoice_number FROM invoices WHERE invoice_number LIKE :prefix ORDER BY id DESC LIMIT 1";
        $stmt = static::getDB()->prepare($sql);
        $stmt->execute(['prefix' => $prefix . '%']);
        $result = $stmt->fetch();

        if ($result) {
            $lastNumber = $result['invoice_number'];
            $lastSequence = (int) str_replace($prefix, '', $lastNumber);
            $nextSequence = $lastSequence + 1;
        } else {
            $nextSequence = 1;
        }

        return $prefix . str_pad((string)$nextSequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get line items for an invoice
     */
    public static function getItems(int $invoiceId): array {
        $sql = "SELECT * FROM invoice_items WHERE invoice_id = :id ORDER BY id ASC";
        $stmt = static::getDB()->prepare($sql);
        $stmt->execute(['id' => $invoiceId]);
        return $stmt->fetchAll();
    }

    /**
     * Delete all items for an invoice (used before updating)
     */
    public static function deleteItems(int $invoiceId): void {
        $sql = "DELETE FROM invoice_items WHERE invoice_id = :id";
        $stmt = static::getDB()->prepare($sql);
        $stmt->execute(['id' => $invoiceId]);
    }

    /**
     * Add a line item to an invoice
     */
    public static function addItem(int $invoiceId, string $description, float $quantity, float $unitPrice, float $total): void {
        $sql = "INSERT INTO invoice_items (invoice_id, description, quantity, unit_price, total) VALUES (:invoice_id, :description, :quantity, :unit_price, :total)";
        $stmt = static::getDB()->prepare($sql);
        $stmt->execute([
            'invoice_id' => $invoiceId,
            'description' => $description,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total' => $total
        ]);
    }
}
