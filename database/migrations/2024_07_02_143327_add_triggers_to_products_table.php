<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Trigger untuk memperbarui stok produk setelah insert ke order_items
        DB::unprepared('
            CREATE TRIGGER update_stock_after_insert_order_items
            AFTER INSERT ON order_items FOR EACH ROW
            BEGIN
                UPDATE products
                SET stock = stock - NEW.quantity
                WHERE id = NEW.product_id;
            END
        ');

        // Trigger untuk memperbarui stok produk setelah update order_items
        DB::unprepared('
            CREATE TRIGGER update_stock_after_update_order_items
            AFTER UPDATE ON order_items FOR EACH ROW
            BEGIN
                DECLARE quantity_diff INT;
                SET quantity_diff = NEW.quantity - OLD.quantity;
                UPDATE products
                SET stock = stock - quantity_diff
                WHERE id = NEW.product_id;
            END
        ');

        // Trigger untuk memperbarui stok produk setelah delete dari order_items
        DB::unprepared('
            CREATE TRIGGER update_stock_after_delete_order_items
            AFTER DELETE ON order_items FOR EACH ROW
            BEGIN
                UPDATE products
                SET stock = stock + OLD.quantity
                WHERE id = OLD.product_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop triggers
        DB::unprepared('DROP TRIGGER IF EXISTS update_stock_after_insert_order_items');
        DB::unprepared('DROP TRIGGER IF EXISTS update_stock_after_update_order_items');
        DB::unprepared('DROP TRIGGER IF EXISTS update_stock_after_delete_order_items');
    }
};
