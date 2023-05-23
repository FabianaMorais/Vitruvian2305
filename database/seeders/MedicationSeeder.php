<?php

use Illuminate\Database\Seeder;
use App\Models\Medication;
use App\Models\CrisisEvent;
use App\Models\MinuteTimestamps;

class MedicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Medication::on('mysql_v_watch')->create([
            'name' => 'furozemide',
            'pill_dosage' => 40,
            'type' => 1,
            // descrição tomar em jejum
            //type pill
        ]);

        Medication::on('mysql_v_watch')->create([
            'name' => 'omeprazole',
            'pill_dosage' => 40,
            'type' => 2,
            // descrição tomar em jejum - on an empty stomach
            //type capsule
        ]);

        Medication::on('mysql_v_watch')->create([
            'name' => 'meteformin',
            'pill_dosage' => 500,
            // descrição tomar em jejum - on an empty stomach
            'type' => 1,
        ]);

        Medication::on('mysql_v_watch')->create([
            'name' => 'alprazolan',
            'pill_dosage' => 0.5,
            // descrição 30 mins before sleep
            'type' => 1,
        ]);

        

        CrisisEvent::on('mysql_v_watch')->create([
            'name' => 'Other'
        ]);
        CrisisEvent::on('mysql_v_watch')->create([
            'name' => 'Absence seizure'
        ]);
        CrisisEvent::on('mysql_v_watch')->create([
            'name' => 'Tonic-clonic epileptic seizure'
        ]);
        CrisisEvent::on('mysql_v_watch')->create([
            'name' => 'Loss of balance'
        ]);
        CrisisEvent::on('mysql_v_watch')->create([
            'name' => 'Loss of consciousness'
        ]);
        CrisisEvent::on('mysql_v_watch')->create([
            'name' => 'Fall'
        ]);

        //fills minute_timestamps table with every hour + min possibility
        for($i=0; $i<24; $i++){
            for($j=0; $j<60; $j++){
                MinuteTimestamps::on('mysql_v_watch')->create([
                    'hour' => $i,
                    'minute' => $j
                ]);
            }
        }
    }
}
