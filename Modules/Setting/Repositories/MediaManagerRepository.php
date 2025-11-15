<?php

namespace Modules\Setting\Repositories;

use App\Traits\UploadMedia;
use Illuminate\Support\Facades\Auth;
use Modules\Setting\Entities\MediaManager;

class MediaManagerRepository
{
    use UploadMedia;

    public function getFiles($data)
    {
        $query = MediaManager::query();
        $user_id = Auth::id();
        if (Auth::user()->role_id != 1) {
            $query = $query->where('user_id', $user_id);
        }
        if (isset($data['search']) && !empty($data['search'])) {
            $slugs = explode(' ', $data['search']);
            if (isset($data['sort']) && $data['sort'] != 'newest') {
                if ($data['sort'] == 'oldest') {
                    $query = $query->orderBy('id', 'asc')->where(function ($q) use ($slugs) {
                        foreach ($slugs as $slug) {
                            $q = $q->orWhere('original_name', 'LIKE', "%{$slug}%");
                        }
                        return $q;
                    });
                } elseif ($data['sort'] == 'smallest') {
                    $query = $query->orderBy('size')->where(function ($q) use ($slugs) {
                        foreach ($slugs as $slug) {
                            $q = $q->orWhere('original_name', 'LIKE', "%{$slug}%");
                        }
                        return $q;
                    });
                } elseif ($data['sort'] == 'biggest') {
                    $query = $query->orderByDesc('size')->where(function ($q) use ($slugs) {
                        foreach ($slugs as $slug) {
                            $q = $q->orWhere('original_name', 'LIKE', "%{$slug}%");
                        }
                        return $q;
                    });
                }
            }
            $query = $query->orderByDesc('id')->where(function ($q) use ($slugs) {
                foreach ($slugs as $slug) {
                    $q = $q->orWhere('original_name', 'LIKE', "%{$slug}%");
                }
                return $q;
            });
        } else {
            if (isset($data['sort']) && $data['sort'] != 'newest') {
                if ($data['sort'] == 'oldest') {
                    $query = $query->orderBy('id');
                } elseif ($data['sort'] == 'smallest') {
                    $query = $query->orderBy('size');
                } elseif ($data['sort'] == 'biggest') {
                    $query = $query->orderByDesc('size');
                }
            }

            $query = $query->orderByDesc('id');
        }
        return $query->paginate(18);
    }

    public function store($file)
    {
        $file_info = $this->mediaUpload($file);
        $file_info['user_id'] = Auth::id();
        return MediaManager::create($file_info);
    }

    public function destroy($id)
    {
        try {
            $file = MediaManager::find($id);

            if ($file) {
                foreach ($file->used_media as $media) {
                    $used_for = $media->used_for;
                    if ($media->usable) {
                        $media->usable->update([
                            $used_for => null
                        ]);
                    }
                    $media->delete();
                }

                $this->deleteFile(@$file->file_name);

                $file->delete();
                return true;
            }
        } catch (\Exception $exception) {

        }
        return false;
    }

    public function getMediaById($request)
    {
        $data = MediaManager::whereIn('id', $request->ids);
        if ($request->prev_ids) {
            $new_ids = implode(',', $request->ids);
            $prev_ids = $request->prev_ids . ',' . $new_ids;
            $data->orderByRaw('FIELD(id, ' . $prev_ids . ')');
        }
        return $data->get();
    }

}
