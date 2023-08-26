<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MoveImagesToS3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $sourcePath = public_path() . '/images/educations/';
        // $sourcePath = storage_path('app/public/images'); // Adjust the source path
        $s3Path = 'images/educations/'; // The target path in S3

        $files = Storage::disk('local')->files('public/images/educations'); // List all files in the source path

        foreach ($files as $file) {
            $filename = pathinfo($file, PATHINFO_BASENAME);

            // Read the file contents
            $fileData = Storage::disk('local')->get($file);

            // Upload the file to S3
            Storage::disk('s3')->put("$s3Path/$filename", $fileData);

            $this->info("Moved $file to S3");
        }

        $this->info('All images moved to S3.');
    }
}
