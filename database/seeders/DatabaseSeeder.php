<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $sqlPath = base_path('bincom_test.sql');

        if (!File::exists($sqlPath)) {
            $this->command->error('bincom_test.sql file not found in project root.');
            return;
        }

        // Try MySQL CLI first (most reliable)
        $mysqlPath = $this->findMysqlCli();

        if ($mysqlPath) {
            $this->importViaCli($mysqlPath, $sqlPath);
        } else {
            $this->importViaPhp($sqlPath);
        }

        $this->call(FixWardLgaMappingSeeder::class);

        $this->verifyImport();
    }

    protected function findMysqlCli(): ?string
    {
        // XAMPP default paths on Windows
        $possiblePaths = [
            'C:\\xampp\\mysql\\bin\\mysql.exe',
            'C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\mysql.exe',
            'C:\\Program Files\\MySQL\\MySQL Server 5.7\\bin\\mysql.exe',
        ];

        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        // Try system PATH
        $output = [];
        $returnCode = 0;
        exec('where mysql 2>nul', $output, $returnCode);
        if ($returnCode === 0 && !empty($output)) {
            return trim($output[0]);
        }

        return null;
    }

    protected function importViaCli(string $mysqlPath, string $sqlPath): void
    {
        $this->command->info('Importing via MySQL CLI...');

        $dbConfig = config('database.connections.mysql');
        $host = $dbConfig['host'] ?? '127.0.0.1';
        $port = $dbConfig['port'] ?? 3306;
        $database = $dbConfig['database'] ?? 'bincomphptest';
        $username = $dbConfig['username'] ?? 'root';
        $password = $dbConfig['password'] ?? '';

        $escapedPath = escapeshellarg($sqlPath);
        $cmd = sprintf(
            '%s -h %s -P %s -u %s %s %s < %s 2>&1',
            escapeshellarg($mysqlPath),
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($username),
            $password ? '-p' . escapeshellarg($password) : '',
            escapeshellarg($database),
            $escapedPath
        );

        exec($cmd, $output, $returnCode);

        if ($returnCode !== 0) {
            $this->command->warn('MySQL CLI import failed, falling back to PHP parser...');
            $this->importViaPhp($sqlPath);
            return;
        }

        $this->command->info('SQL imported successfully via MySQL CLI.');
    }

    protected function importViaPhp(string $sqlPath): void
    {
        $this->command->info('Importing via PHP parser (fallback)...');

        $sql = File::get($sqlPath);

        // Remove MySQL conditional comments like /*!40101 SET ... */;
        $sql = preg_replace('/\/\*!\d+\s.*?\*\s*\//s', '', $sql);

        // Remove all comment-only lines (-- style)
        $sql = preg_replace('/^\s*--.*$/m', '', $sql);

        // Split by semicolons
        $statements = array_filter(
            array_map('trim', explode(';', $sql)),
            fn ($statement) => !empty($statement)
        );

        $processed = 0;
        $errors = 0;

        foreach ($statements as $statement) {
            if (empty($statement)) {
                continue;
            }

            try {
                DB::unprepared($statement);
                $processed++;
            } catch (\Exception $e) {
                $errors++;
                if ($errors <= 5) {
                    $this->command->warn("  Error: " . $e->getMessage());
                }
            }
        }

        $this->command->info("Import completed: {$processed} statements processed, {$errors} errors.");
    }

    protected function verifyImport(): void
    {
        $this->command->info('Verifying imported data...');

        $tables = [
            'states' => 'id',
            'lga' => 'uniqueid',
            'ward' => 'uniqueid',
            'polling_unit' => 'uniqueid',
            'party' => 'partyid',
            'announced_pu_results' => 'result_id',
            'announced_lga_results' => 'result_id',
        ];

        foreach ($tables as $table => $primaryKey) {
            try {
                $count = DB::table($table)->count();
                $this->command->info("  {$table}: {$count} records");
            } catch (\Exception $e) {
                $this->command->warn("  {$table}: Table not found or empty");
            }
        }

        try {
            $validPUs = DB::table('polling_unit')
                ->where('uniquewardid', '>', 0)
                ->where('lga_id', '>', 0)
                ->count();
            $this->command->info("  Valid polling units: {$validPUs}");
        } catch (\Exception $e) {
            $this->command->warn("  Could not verify polling unit relationships");
        }
    }
}
