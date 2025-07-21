<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AntropometryRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'anak_id',
        'age_in_month',
        'weight',
        'height',
        'vitamin_a_count',
        'head_circumference',
        'upper_arm_circumference'
    ];

    public function anak()
    {
        return $this->belongsTo(Anak::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function predictionRecord()
    {
        return $this->hasOne(PredictionRecord::class);
    }

    protected static function booted(): void
    {
        static::creating(function (self $record) {
            // if user_id wasn’t set in the form, grab it from the Anak
            if (! $record->user_id && $record->anak_id) {
                $record->user_id = $record->anak->user_id;
            }
        });

        static::created(function (self $record) {
            // Create a default prediction record first to satisfy constraints
            $defaultPrediction = $record->predictionRecords()->create([
                'user_id'                 => $record->user_id,
                'anak_id'                 => $record->anak_id,
                'antropometry_record_id'  => $record->id,
                'status_stunting'         => 'Processing',
                'status_underweight'      => 'Processing',
                'status_wasting'          => 'Processing',
                'recommendation'          => 'Analyzing data...',
            ]);

            $anak = $record->anak;

            $payload = [
                'nama'            => $anak->name,
                'jenis_kelamin'   => $anak->gender,
                'umur_bulan'      => $record->age_in_month,
                'berat'           => $record->weight,
                'tinggi'          => $record->height,
                'lingkar_lengan'  => $record->upper_arm_circumference,
                'lingkar_kepala'  => $record->head_circumference,
                'kecamatan'       => $anak->region,
                'jumlah_vit_a'    => $record->vitamin_a_count,
                'pendidikan_ibu'  => $anak->mother_edu,
                'pendidikan_ayah' => $anak->father_edu,
            ];

            $response = Http::post('https://n8n.dfxx.site/webhook/post-data', $payload);

            if (!$response->ok()) {
                Log::warning("Prediction API failed for record {$record->id}", [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                
                // Update the default prediction with error status
                $defaultPrediction->update([
                    'status_stunting'    => 'API Error',
                    'status_underweight' => 'API Error',
                    'status_wasting'     => 'API Error',
                    'recommendation'     => 'Unable to process prediction due to API error. Please try again later.',
                ]);
                return;
            }

            $apiResponse = $response->json();
            Log::info("Prediction API response for record {$record->id}", [
                'response' => $apiResponse,
            ]);

            // If the response is a list/array, take the first element
            if (is_array($apiResponse) && array_is_list($apiResponse)) {
                $data = $apiResponse[0] ?? [];
            } elseif (is_array($apiResponse)) {
                $data = $apiResponse;
            } else {
                $data = [];
            }

            // Now, *guarantee* the three status fields are never null
            $statusStunting    = (!empty($data['status_stunting'])) ? (string)$data['status_stunting'] : 'Unknown';
            $statusUnderweight = (!empty($data['status_underweight'])) ? (string)$data['status_underweight'] : 'Unknown';
            $statusWasting     = (!empty($data['status_wasting'])) ? (string)$data['status_wasting'] : 'Unknown';

            // Debug log to see what we're about to insert
            Log::info("About to update prediction record", [
                'record_id' => $record->id,
                'status_stunting' => $statusStunting,
                'status_underweight' => $statusUnderweight,
                'status_wasting' => $statusWasting,
                'data_from_api' => $data
            ]);

            // Also guarantee recommendation is always string (even if null)
            $recommendation = '';
            if (array_key_exists('recommendation', $data) && $data['recommendation'] !== null) {
                $recommendation = (string) $data['recommendation'];
            } elseif (array_key_exists('response', $data) && $data['response'] !== null) {
                $recommendation = (string) $data['response'];
            }

            // Update the existing prediction record with API results
            try {
                $defaultPrediction->update([
                    'status_stunting'         => $statusStunting ?: 'Unknown',
                    'status_underweight'      => $statusUnderweight ?: 'Unknown',
                    'status_wasting'          => $statusWasting ?: 'Unknown',
                    'recommendation'          => $recommendation ?: 'No recommendation available',
                ]);

                Log::info("Successfully updated prediction record", [
                    'prediction_id' => $defaultPrediction->id,
                    'record_id' => $record->id
                ]);
            } catch (\Exception $e) {
                Log::error("Failed to update prediction record", [
                    'error' => $e->getMessage(),
                    'record_id' => $record->id,
                    'prediction_id' => $defaultPrediction->id
                ]);
            }
        });
    }
}
