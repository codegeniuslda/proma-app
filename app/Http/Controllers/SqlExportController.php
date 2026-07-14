<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

class SqlExportController extends Controller
{
    /**
     * Página única do módulo Exportar.
     */
    public function index()
    {
        $modules = [
            'collaborators' => 'Colaboradores',
            'time-entries' => 'Registros de Ponto',
            'establishments' => 'Estabelecimentos',
            'establishment-managements' => 'Gestão do Estabelecimento',
        ];

        return view('exportar.index', compact('modules'));
    }

    /**
     * Exporta o banco completo em SQL.
     */
    public function exportFullBackup(Request $request)
    {
        $exportPath = $this->ensureExportDirectory();

        $fileName = 'backup_full_' . now()->format('Ymd_His') . '.sql';
        $fullPath = $exportPath . DIRECTORY_SEPARATOR . $fileName;

        try {
            $process = $this->buildMysqldumpProcess($fullPath);

            $process->run();

            if (!$process->isSuccessful()) {
                return back()->withErrors([
                    'Falha ao gerar backup SQL completo: ' . $process->getErrorOutput(),
                ]);
            }

            return response()->download($fullPath)->deleteFileAfterSend(true);
        } catch (\Throwable $e) {
            return back()->withErrors([
                'Falha ao gerar backup SQL completo: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Exporta módulos específicos em SQL.
     */
    public function exportModule(Request $request, string $module)
    {
        $moduleTables = $this->moduleTableMap();

        if (!array_key_exists($module, $moduleTables)) {
            return back()->withErrors(['Módulo inválido para exportação SQL.']);
        }

        $tables = $moduleTables[$module];
        $exportPath = $this->ensureExportDirectory();

        $fileName = 'backup_' . str_replace('-', '_', $module) . '_' . now()->format('Ymd_His') . '.sql';
        $fullPath = $exportPath . DIRECTORY_SEPARATOR . $fileName;

        try {
            $process = $this->buildMysqldumpProcess($fullPath, $tables);

            $process->run();

            if (!$process->isSuccessful()) {
                return back()->withErrors([
                    'Falha ao gerar backup SQL do módulo: ' . $process->getErrorOutput(),
                ]);
            }

            return response()->download($fullPath)->deleteFileAfterSend(true);
        } catch (\Throwable $e) {
            return back()->withErrors([
                'Falha ao gerar backup SQL do módulo: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Monta o process do mysqldump para Windows/Linux.
     */
    private function buildMysqldumpProcess(string $outputFilePath, array $tables = []): Process
    {
        $connection = config('database.connections.mysql');

        $host = (string) ($connection['host'] ?? '127.0.0.1');
        $port = (string) ($connection['port'] ?? '3306');
        $database = (string) ($connection['database'] ?? '');
        $username = (string) ($connection['username'] ?? '');
        $password = (string) ($connection['password'] ?? '');

        $dumpBinary = $this->resolveMysqldumpBinary();

        if ($dumpBinary === null) {
            throw new \RuntimeException(
                'mysqldump não encontrado. Configure DB_DUMP_BINARY no .env ' .
                '(ex.: Linux: /usr/bin/mysqldump | Windows: C:\\xampp\\mysql\\bin\\mysqldump.exe) ' .
                'ou adicione mysqldump ao PATH do sistema.'
            );
        }

        $socket = (string) ($connection['unix_socket'] ?? '');
        $hostNormalized = strtolower($host);
        $isLocalhost = in_array($hostNormalized, ['localhost', '127.0.0.1'], true);

        $baseCommand = [
            $dumpBinary,
            '--user=' . $username,
            '--single-transaction',
            '--routines',
            '--triggers',
            '--events',
        ];

        if ($socket !== '') {
            $baseCommand[] = '--socket=' . $socket;
        } else {
            $baseCommand[] = '--protocol=TCP';
            $baseCommand[] = '--host=' . ($hostNormalized === 'localhost' ? '127.0.0.1' : $host);
            $baseCommand[] = '--port=' . $port;
        }

        $baseCommand[] = $database;

        if (!empty($tables)) {
            $baseCommand = array_merge($baseCommand, $tables);
        }

        // Comando shell com redirecionamento para gerar o arquivo .sql diretamente
        $cmdParts = array_map(static fn ($part) => escapeshellarg((string) $part), $baseCommand);
        $commandString = implode(' ', $cmdParts) . ' > ' . escapeshellarg($outputFilePath);

        $process = Process::fromShellCommandline($commandString);
        $process->setTimeout(300);

        if ($password !== '') {
            $process->setEnv(['MYSQL_PWD' => $password]);
        }

        return $process;
    }

    /**
     * Resolve caminho do mysqldump para Linux/Windows.
     */
    private function resolveMysqldumpBinary(): ?string
    {
        $fromEnv = (string) env('DB_DUMP_BINARY', '');
        if ($fromEnv !== '') {
            return $fromEnv;
        }

        $candidates = [
            '/usr/bin/mysqldump',
            '/usr/local/bin/mysqldump',
            'C:\\xampp\\mysql\\bin\\mysqldump.exe',
            'C:\\wamp64\\bin\\mysql\\mysql8.0.31\\bin\\mysqldump.exe',
            'C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\mysqldump.exe',
            'C:\\Program Files\\MySQL\\MySQL Server 5.7\\bin\\mysqldump.exe',
        ];

        foreach ($candidates as $candidate) {
            if (@is_file($candidate)) {
                return $candidate;
            }
        }

        return null;
    }

    /**
     * Garante pasta de exportação.
     */
    private function ensureExportDirectory(): string
    {
        $path = storage_path('app/exports');

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        return $path;
    }

    /**
     * Mapeamento de módulo -> tabelas.
     */
    private function moduleTableMap(): array
    {
        return [
            'collaborators' => ['collaborators'],
            'time-entries' => ['time_entries'],
            'establishments' => ['establishments'],
            'establishment-managements' => ['establishment_managements'],
        ];
    }
}