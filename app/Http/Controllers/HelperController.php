<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class HelperController extends Controller
{

    public function uploadScreenshots(Request $request)
    {

        $validated = $request->validate([
            'trade_id' => 'required|integer|exists:trades,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'existing_images' => 'nullable|array',
            'existing_images.*' => 'string',
        ]);

        $trade = Trade::where('id', $validated['trade_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $existingImages = $validated['existing_images'] ?? [];

        $dbImages = [];

        if (!empty($trade->trd_screenshots)) {
            $dbImages = @unserialize($trade->trd_screenshots);
            if (!is_array($dbImages)) {
                $dbImages = [];
            }
        }

        $existingImages = array_merge($dbImages, $existingImages);

        $newPaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {

                if (!$image->isValid()) continue;

                $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('screenshots', $imageName, 'public');

                $newPaths[] = asset('storage/' . $path);
            }
        }

        $finalImages = array_values(array_unique(array_merge($existingImages, $newPaths)));

        $update = [
            'trd_screenshots' => serialize($finalImages),
        ];

        $trade->update($update);

        return response()->json([
            'success' => true,
            'trade_id' => $trade->id,
            'images' => $finalImages,
        ]);
    }

    public function deleteScreenshot(Request $request)
    {

        $validate = $request->validate([
            'trade_id' => 'required|integer',
            'screenshotURL' => 'required|string',
        ]);

        $trade = Trade::where('id', '=', $validate['trade_id'], false)->first();

        $screenshots = unserialize($trade->trd_screenshots);
        $updatedScreenshots = [];
        foreach($screenshots as $screenshot) {
            if( $screenshot == $validate['screenshotURL'] ) {
                $screenshot = parse_url( $screenshot, PHP_URL_PATH );
                $screenshot = ltrim(str_replace('/storage', '', $screenshot));
                if( Storage::disk('public')->exists($screenshot) ) {
                    Storage::disk('public')->delete($screenshot);
                }
            } else {
                $updatedScreenshots[] = $screenshot;
            }
        }
        // $updatedScreenshots = array_filter($screenshots, function ($url) use ($validate) {
        //     return $url !== $validate['screenshotURL'];
        // });
        $update = [
            'trd_screenshots' => serialize($updatedScreenshots),
        ];
        $trade->update($update);

        return response()->json([
            'success' => true,
            $updatedScreenshots
        ]);
    }

}
