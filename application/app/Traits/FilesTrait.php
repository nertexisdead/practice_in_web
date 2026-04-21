<?php

namespace App\Traits;

use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

trait FilesTrait
{
    public function getEntityType(): string
    {
        return (new \ReflectionClass($this))->getName();
    }

    public function getEntityId(): int
    {
        return $this->id;
    }

    public function getFiles(): Collection
    {
        return File::where('fileable_type', $this->getEntityType())
            ->where('fileable_id', $this->getEntityId())
            ->get()
        ;
    }

    public function uploadFile(FormRequest $request): File|JsonResponse
    {
        try {
            DB::beginTransaction();
            $requestFile = $request->file;
            $fileName = $requestFile->getClientOriginalName();

            $fileContent = file_get_contents($requestFile->getRealPath());
            $hash = hash('sha256', $fileContent);

            $file = File::create([
                'fileable_type' => $this->getEntityType(),
                'fileable_id' => $this->getEntityId(),
                'file_name' => $fileName,
                'extension' => $requestFile->getClientOriginalExtension(),
                'description' => $request->description,
                'approved_at' => $request->approved_at,
                'mime' => $requestFile->getClientMimeType(),
                'hash' => $hash,
                'user_id' => User::current()->id,
            ]);

            $requestFile
                ->storeAs(
                    $file->getDirectory(),
                    $requestFile->getClientOriginalName(),
                    'public'
                )
            ;
            DB::commit();
            return $file;
        } catch (Throwable $ex) {
            Log::error($ex);
            DB::rollBack();
        }
        return response()->json(
            [
                'errors' => [
                    'file' => __('File wasn\'t uploaded'),
                ],
            ],
            500
        );
    }

    public function clearFiles()
    {
        foreach ($this->getFiles() as $file) {
            $file->delete();
        }
    }
}
