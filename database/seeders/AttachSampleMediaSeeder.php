<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Research;

class AttachSampleMediaSeeder extends Seeder
{
    public function run()
    {
        // Find a research to attach a sample file to
        $research = Research::first();
        if (! $research) {
            $this->command->info('No Research records found. Skipping sample media attach.');
            return;
        }

        // Try to find any PDF inside storage/app/public (including subfolders)
        $sample = null;
        $dir = storage_path('app/public');
        if (is_dir($dir)) {
            $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));
            foreach ($rii as $file) {
                if ($file->isDir()) {
                    continue;
                }
                if (strtolower($file->getExtension()) === 'pdf') {
                    $sample = $file->getPathname();
                    break;
                }
            }
        }

        if (! $sample || ! file_exists($sample)) {
            $this->command->info('No PDF sample found under storage/app/public. Skipping.');
            return;
        }

        // Attach to media library (collection: research_files, disk: public)
        try {
            $research->addMedia($sample)
                ->preservingOriginal()
                ->toMediaCollection('research_files', 'media');

            $this->command->info('Attached sample media to Research ID: ' . $research->id);
        } catch (\Throwable $e) {
            $this->command->error('Failed to attach media: ' . $e->getMessage());
        }
    }
}
