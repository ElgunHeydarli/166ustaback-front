<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

/**
 * Automatically deletes storage files when a model is deleted.
 *
 * Add to model:
 *   use CleansUpMedia;
 *   protected array $singleMediaFields = ['cover_image', 'og_image'];
 *   protected array $arrayMediaFields  = ['gallery'];
 */
trait CleansUpMedia
{
    public static function bootCleansUpMedia(): void
    {
        static::deleting(function ($model) {
            foreach ($model->singleMediaFields ?? [] as $field) {
                if (!empty($model->$field)) {
                    Storage::disk('public')->delete($model->$field);
                }
            }
            foreach ($model->arrayMediaFields ?? [] as $field) {
                foreach ($model->$field ?? [] as $path) {
                    if (!empty($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
            }
        });
    }
}
