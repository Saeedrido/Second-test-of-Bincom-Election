<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FixWardLgaMappingSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Fixing ward.lga_id mappings for all affected LGAs...');

        // ward.lga_id uses lga.lga_id instead of lga.uniqueid
        // Mapping: ward currently uses 'from', should use 'to' (lga.uniqueid)
        $fixes = [
            ['from' => 5,  'to' => 3,  'name' => 'Ethiope East'],
            ['from' => 6,  'to' => 4,  'name' => 'Ethiope West'],
            ['from' => 7,  'to' => 5,  'name' => 'Ika North-East'],
            ['from' => 8,  'to' => 6,  'name' => 'Ika South'],
            ['from' => 9,  'to' => 7,  'name' => 'Isoko North'],
            ['from' => 10, 'to' => 8,  'name' => 'Isoko South'],
            ['from' => 11, 'to' => 9,  'name' => 'Ndokwa East'],
            ['from' => 12, 'to' => 10, 'name' => 'Ndokwa West'],
            ['from' => 13, 'to' => 11, 'name' => 'Okpe'],
            ['from' => 14, 'to' => 12, 'name' => 'Oshimili North'],
            ['from' => 15, 'to' => 13, 'name' => 'Oshimili South'],
            ['from' => 16, 'to' => 14, 'name' => 'Patani'],
            ['from' => 17, 'to' => 15, 'name' => 'Sapele'],
            ['from' => 18, 'to' => 16, 'name' => 'Udu'],
            ['from' => 19, 'to' => 17, 'name' => 'Ughelli North'],
            ['from' => 20, 'to' => 18, 'name' => 'Ughelli South'],
            ['from' => 21, 'to' => 19, 'name' => 'Ukwuani'],
            ['from' => 22, 'to' => 20, 'name' => 'Uvwie'],
            ['from' => 31, 'to' => 21, 'name' => 'Bomadi'],
            ['from' => 32, 'to' => 22, 'name' => 'Burutu'],
            ['from' => 33, 'to' => 23, 'name' => 'Warri North'],
            ['from' => 34, 'to' => 24, 'name' => 'Warri South'],
            ['from' => 35, 'to' => 25, 'name' => 'Warri South West'],
        ];

        $totalFixed = 0;

        foreach ($fixes as $fix) {
            $count = DB::table('ward')
                ->where('lga_id', $fix['from'])
                ->update(['lga_id' => $fix['to']]);

            $totalFixed += $count;
            if ($count > 0) {
                $this->command->info("  {$fix['name']}: fixed {$count} wards (lga_id {$fix['from']} → {$fix['to']})");
            }
        }

        $this->command->info("Total wards fixed: {$totalFixed}");

        // Fix party table: LABOUR partyid is 6 chars but results use 4-char 'LABO'
        $this->command->info('Fixing party table: LABOUR → LABO...');
        DB::table('party')
            ->where('partyid', 'LABOUR')
            ->update(['partyid' => 'LABO', 'partyname' => 'LABOUR']);

        // Also fix polling_unit.lga_id for affected units
        $this->command->info('Fixing polling_unit.lga_id for affected polling units...');

        $puFixes = [
            ['from' => 5,  'to' => 3,  'name' => 'Ethiope East'],
            ['from' => 6,  'to' => 4,  'name' => 'Ethiope West'],
            ['from' => 7,  'to' => 5,  'name' => 'Ika North-East'],
            ['from' => 8,  'to' => 6,  'name' => 'Ika South'],
            ['from' => 9,  'to' => 7,  'name' => 'Isoko North'],
            ['from' => 10, 'to' => 8,  'name' => 'Isoko South'],
            ['from' => 11, 'to' => 9,  'name' => 'Ndokwa East'],
            ['from' => 12, 'to' => 10, 'name' => 'Ndokwa West'],
            ['from' => 13, 'to' => 11, 'name' => 'Okpe'],
            ['from' => 14, 'to' => 12, 'name' => 'Oshimili North'],
            ['from' => 15, 'to' => 13, 'name' => 'Oshimili South'],
            ['from' => 16, 'to' => 14, 'name' => 'Patani'],
            ['from' => 17, 'to' => 15, 'name' => 'Sapele'],
            ['from' => 18, 'to' => 16, 'name' => 'Udu'],
            ['from' => 19, 'to' => 17, 'name' => 'Ughelli North'],
            ['from' => 20, 'to' => 18, 'name' => 'Ughelli South'],
            ['from' => 21, 'to' => 19, 'name' => 'Ukwuani'],
            ['from' => 22, 'to' => 20, 'name' => 'Uvwie'],
            ['from' => 31, 'to' => 21, 'name' => 'Bomadi'],
            ['from' => 32, 'to' => 22, 'name' => 'Burutu'],
            ['from' => 33, 'to' => 23, 'name' => 'Warri North'],
            ['from' => 34, 'to' => 24, 'name' => 'Warri South'],
            ['from' => 35, 'to' => 25, 'name' => 'Warri South West'],
        ];

        foreach ($puFixes as $fix) {
            $count = DB::table('polling_unit')
                ->where('lga_id', $fix['from'])
                ->where('uniquewardid', '>', 0)
                ->update(['lga_id' => $fix['to']]);

            if ($count > 0) {
                $this->command->info("  Polling units ({$fix['name']}): fixed {$count} units");
            }
        }
    }
}

