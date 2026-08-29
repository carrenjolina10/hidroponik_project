<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RecordSensorData extends Command
{
    protected $signature = 'sensor:record';

    protected $description = 'Record sensor data from Firebase to MySQL';

    public function handle()
    {
        $firebaseUrl = 'https://esp32-hydroponic-default-rtdb.asia-southeast1.firebasedatabase.app/hydroponic.json';

        $response = Http::get($firebaseUrl);

        if (!$response->successful()) {
            $this->error('Gagal mengambil data dari Firebase.');
            return Command::FAILURE;
        }

        $data = $response->json();

        $recordingEnabled = data_get($data, 'recording.enabled', false);

        if (!$recordingEnabled) {
            $this->info('Recording OFF. Data tidak disimpan.');
            return Command::SUCCESS;
        }

        $temperature = data_get($data, 'sensor.temperature');
        $ph          = data_get($data, 'sensor.phValue');
        $tds         = data_get($data, 'sensor.tdsValue');

        if ($temperature === null || $ph === null || $tds === null) {
            $this->error('Data sensor tidak lengkap.');
            return Command::FAILURE;
        }

        DB::table('data')->insert([
            'idTumbuhan' => 'T001',
            'suhu'       => $temperature,
            'pH'         => $ph,
            'nutrisi'    => $tds,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $this->info('Sensor berhasil direcord ke database.');
        $this->info("Temperature: {$temperature} °C");
        $this->info("pH: {$ph}");
        $this->info("TDS: {$tds} ppm");

        return Command::SUCCESS;
    }
}