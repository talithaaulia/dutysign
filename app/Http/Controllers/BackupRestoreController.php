<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use ZipArchive;

class BackupRestoreController extends Controller
{
    // lokasi mysql
    private $mysqlBin = "D:\\laragon\\bin\\mysql\\mysql-8.4.3-winx64\\bin\\";

    // BACKUP
    public function backup()
    {
        $db   = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $pass = env('DB_PASSWORD');
        $host = env('DB_HOST', '127.0.0.1');

        $auth = $pass ? "-p{$pass}" : "";

        $mysqldump = $this->mysqlBin . "mysqldump.exe";

        // file sementara
        $sqlFile = storage_path("app/backup_{$db}.sql");
        $zipFile = storage_path("app/backup-" . date('Y-m-d-H-i-s') . ".zip");

        // dump database
        $command = "\"{$mysqldump}\" --add-drop-table -h {$host} -u {$user} {$auth} {$db} > \"{$sqlFile}\"";
        system($command);

        // buat zip
        $zip = new ZipArchive;
        if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
            $zip->addFile($sqlFile, 'database.sql');
            $this->addFolderToZip(storage_path('app/public/surat_scan'), $zip, 'surat_scan');
            $this->addFolderToZip(storage_path('app/public/reports'), $zip, 'reports');
            $zip->close();
        }

        unlink($sqlFile);

        return response()->download($zipFile)->deleteFileAfterSend(true);
    }

    // helper zip folder
    private function addFolderToZip($folder, &$zip, $zipPath)
    {
        if (!is_dir($folder)) return;

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($folder),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($files as $file) {
            if (in_array($file->getFilename(), ['.', '..'])) continue;

            $filePath = $file->getRealPath();
            $relativePath = $zipPath . '/' . substr($filePath, strlen($folder) + 1);

            if ($file->isDir()) {
                $zip->addEmptyDir($relativePath);
            } else {
                $zip->addFile($filePath, $relativePath);
            }
        }
    }

    // RESTORE
    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:zip',
        ]);

        $file = $request->file('backup_file');
        $extractPath = storage_path('app/restore_temp');

        if (is_dir($extractPath)) {
            File::deleteDirectory($extractPath);
        }
        mkdir($extractPath);

        $zip = new \ZipArchive;
        if ($zip->open($file->getRealPath()) === TRUE) {
            $zip->extractTo($extractPath);
            $zip->close();
        }

        $db   = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $pass = env('DB_PASSWORD');
        $host = env('DB_HOST', '127.0.0.1');

        $auth = $pass ? "-p{$pass}" : "";

        $mysql = $this->mysqlBin . "mysql.exe";

        // drop & create db
        $dropCommand   = "\"{$mysql}\" -h {$host} -u {$user} {$auth} -e \"DROP DATABASE IF EXISTS `{$db}`;\"";
        $createCommand = "\"{$mysql}\" -h {$host} -u {$user} {$auth} -e \"CREATE DATABASE `{$db}`;\"";

        exec($dropCommand, $outputDrop, $returnDrop);
        exec($createCommand, $outputCreate, $returnCreate);

        if ($returnCreate !== 0) {
            return back()->with('error', 'Gagal drop & create ulang database.');
        }

        // import sql
        $sqlFile = $extractPath . '/database.sql';
        if (file_exists($sqlFile)) {
            $importCommand = "\"{$mysql}\" -h {$host} -u {$user} {$auth} {$db} < \"{$sqlFile}\"";
            exec($importCommand, $outputImport, $returnImport);

            if ($returnImport !== 0) {
                return back()->with('error', 'Gagal import database.');
            }
        }

        // restore file
        if (is_dir($extractPath . '/surat_scan')) {
            File::copyDirectory($extractPath . '/surat_scan', storage_path('app/public/surat_scan'));
        }

        if (is_dir($extractPath . '/reports')) {
            File::copyDirectory($extractPath . '/reports', storage_path('app/public/reports'));
        }

        File::deleteDirectory($extractPath);

        return back()->with('success', 'Restore berhasil!');
    }
}
