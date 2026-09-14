<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Data;

class RecordFirebaseSensor extends Command
{
    protected $signature = 'sensor:record';

    protected $description = 'Mengambil data sensor dari Firebase dan menyimpannya ke MySQL';

    public function handle()
    {
        try {

            $firebaseUrl = 'https://esp32-hydroponic-default-rtdb.asia-southeast1.firebasedatabase.app/hydroponic.json';

            $response = Http::timeout(10)->get($firebaseUrl);

            if (!$response->successful()) {

                $this->error('Gagal mengambil data dari Firebase.');

                return Command::FAILURE;
            }

            $data = $response->json();

            if (
                !isset($data['sensor']['temperature']) ||
                !isset($data['sensor']['phValue']) ||
                !isset($data['sensor']['tdsValue'])
            ) {

                $this->error('Data sensor tidak lengkap.');

                return Command::FAILURE;
            }

            $temperature = (float) $data['sensor']['temperature'];
            $ph = (float) $data['sensor']['phValue'];
            $tds = (float) $data['sensor']['tdsValue'];

            Data::create([
                'idTumbuhan' => 'T001',
                'suhu' => $temperature,
                'pH' => $ph,
                'nutrisi' => $tds,
            ]);

            $this->info(
                "Data berhasil disimpan | " .
                "Suhu: {$temperature}°C | " .
                "pH: {$ph} | " .
                "TDS: {$tds} ppm"
            );

            return Command::SUCCESS;

        } catch (\Throwable $e) {

            $this->error('ERROR: ' . $e->getMessage());

            return Command::FAILURE;
        }
    }
}