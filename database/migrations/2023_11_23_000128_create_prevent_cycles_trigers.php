<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table_name = 'product_categories';
            $before_update_trigger_name = 'trg_prevent_cycles_when_creating';
            $error_msg = 'Cannot create cycle in category hierarchy';
            $error_code = '45000';
            $cte_table_name = 'CategoryPath';
            $fk_name = 'parent_id';
            $before_update_trigger = "
                        CREATE TRIGGER IF NOT EXISTS  {$before_update_trigger_name}
                            BEFORE UPDATE ON {$table_name}
                            FOR EACH ROW
                        BEGIN
                            DECLARE is_cycle INT DEFAULT 0;

                            -- Using a recursive CTE to get the entire path
                            WITH RECURSIVE {$cte_table_name} AS (
                                SELECT id, {$fk_name}
                                FROM {$table_name}
                                WHERE id = NEW.{$fk_name}
                                UNION ALL
                                SELECT c.id, c.{$fk_name}
                                FROM {$table_name} c
                                         JOIN {$cte_table_name} cp ON c.id = cp.{$fk_name}
                            )
                            SELECT COUNT(*) INTO is_cycle
                            FROM {$cte_table_name}
                            WHERE id = NEW.id;

                            IF is_cycle > 0 THEN
                                SIGNAL SQLSTATE '{$error_code}'
                                    SET MESSAGE_TEXT = '{$error_msg}';

                            END IF;

                        END;
                    ";



            $before_insert_trigger_name = 'trg_prevent_cycles_when_inserting';
            $before_insert_trigger = "

                        CREATE TRIGGER IF NOT EXISTS {$before_insert_trigger_name}
                            BEFORE INSERT ON {$table_name}
                            FOR EACH ROW
                        BEGIN

                            IF NEW.id = NEW.$fk_name THEN
                                SIGNAL SQLSTATE '{$error_code}'
                                    SET MESSAGE_TEXT = '{$error_msg}';

                        END IF;

                    END;

                ";


            DB::statement($before_update_trigger);
            DB::statement($before_insert_trigger);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP TRIGGER IF EXISTS `trg_prevent_cycles_when_creating`");
    }
};
