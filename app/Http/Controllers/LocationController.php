<?php

namespace App\Http\Controllers;

use Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{
    // public function store(Request $request){
    //     $lat = $request->input('lat');
    //     $lng = $request->input('lng');

    //     // Database ya log me save karna
    //     Log::info("Location: $lat, $lng");

    //     return response()->json(['message' => 'Location saved successfully']);
    // }


    public function store(Request $request){
        $lat = $request->lat;
        $lng = $request->lng;
        
        //  Database ya log me save karna
        Log::info("Location: $lat, $lng");
        
        // $apiKey = env('OPENCAGE_API_KEY');
        
        // $response = Http::get("https://api.opencagedata.com/geocode/v1/json", [
        //     'q' => "$lat+$lng",
        //     'key' => $apiKey,
        // ]);

        // Call to Nominatim API

        $url = "https://nominatim.openstreetmap.org/reverse";
        $response = Http::withHeaders([
            'User-Agent' => 'LaravelApp/1.0'
        ])->get($url, [
            'format' => 'json',
            'lat' => $lat,
            'lon' => $lng,
        ]);

        if($response->successful()) {
            $data = $response->json();
            // $address = $data['results'][0]['formatted'] ?? 'Address not found';
            $address = $data['address'] ?? [];

            Log::info("User Address: " . $address);

            // return response()->json(['success' => true]);

            // return response(null, 204);

            return response()->json([
                'full_address' => $data['display_name'] ?? '',
                'address' => $address
            ]);
        }
        return response()->json(['error' => 'Unable to fetch location'], 500);
    }
}
