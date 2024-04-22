<?php

namespace Database\Seeders;

use App\Models\SalaryGradeStep;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SalaryGrade;

class SalaryGradesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $salary_grades = [
            [
                ['step' => 'Step 1', 'amount' => 12350],
                ['step' => 'Step 2', 'amount' => 12454],
                ['step' => 'Step 3', 'amount' => 12558],
                ['step' => 'Step 4', 'amount' => 12663],
                ['step' => 'Step 5', 'amount' => 12769],
                ['step' => 'Step 6', 'amount' => 12875],
                ['step' => 'Step 7', 'amount' => 12983],
                ['step' => 'Step 8', 'amount' => 13091],
            ],
            // 2
            [
                ['step' => 'Step 1', 'amount' => 13128],
                ['step' => 'Step 2', 'amount' => 13229],
                ['step' => 'Step 3', 'amount' => 13330],
                ['step' => 'Step 4', 'amount' => 13433],
                ['step' => 'Step 5', 'amount' => 13536],
                ['step' => 'Step 6', 'amount' => 13639],
                ['step' => 'Step 7', 'amount' => 13745],
                ['step' => 'Step 8', 'amount' => 13849],
            ],
            // 3
            [
                ['step' => 'Step 1', 'amount' => 13944],
                ['step' => 'Step 2', 'amount' => 14052],
                ['step' => 'Step 3', 'amount' => 14160],
                ['step' => 'Step 4', 'amount' => 14269],
                ['step' => 'Step 5', 'amount' => 14379],
                ['step' => 'Step 6', 'amount' => 14488],
                ['step' => 'Step 7', 'amount' => 14601],
                ['step' => 'Step 8', 'amount' => 14712],
            ],
            // 4
            [
                ['step' => 'Step 1', 'amount' => 14807],
                ['step' => 'Step 2', 'amount' => 14921],
                ['step' => 'Step 3', 'amount' => 15036],
                ['step' => 'Step 4', 'amount' => 15151],
                ['step' => 'Step 5', 'amount' => 15267],
                ['step' => 'Step 6', 'amount' => 15383],
                ['step' => 'Step 7', 'amount' => 15502],
                ['step' => 'Step 8', 'amount' => 15621],
            ],
            // 5
            [
                ['step' => 'Step 1', 'amount' => 15716],
                ['step' => 'Step 2', 'amount' => 15837],
                ['step' => 'Step 3', 'amount' => 15959],
                ['step' => 'Step 4', 'amount' => 16082],
                ['step' => 'Step 5', 'amount' => 16204],
                ['step' => 'Step 6', 'amount' => 16330],
                ['step' => 'Step 7', 'amount' => 16455],
                ['step' => 'Step 8', 'amount' => 16580],
            ],
            // 6
            [
                ['step' => 'Step 1', 'amount' => 16675],
                ['step' => 'Step 2', 'amount' => 16804],
                ['step' => 'Step 3', 'amount' => 16933],
                ['step' => 'Step 4', 'amount' => 17064],
                ['step' => 'Step 5', 'amount' => 17195],
                ['step' => 'Step 6', 'amount' => 17326],
                ['step' => 'Step 7', 'amount' => 17460],
                ['step' => 'Step 8', 'amount' => 17594],
            ],
            // 7
            [
                ['step' => 'Step 1', 'amount' => 17689],
                ['step' => 'Step 2', 'amount' => 17825],
                ['step' => 'Step 3', 'amount' => 17962],
                ['step' => 'Step 4', 'amount' => 18100],
                ['step' => 'Step 5', 'amount' => 18238],
                ['step' => 'Step 6', 'amount' => 18379],
                ['step' => 'Step 7', 'amount' => 18519],
                ['step' => 'Step 8', 'amount' => 18662],
            ],
            // 8
            [
                ['step' => 'Step 1', 'amount' => 18757],
                ['step' => 'Step 2', 'amount' => 18927],
                ['step' => 'Step 3', 'amount' => 19099],
                ['step' => 'Step 4', 'amount' => 19271],
                ['step' => 'Step 5', 'amount' => 19445],
                ['step' => 'Step 6', 'amount' => 19620],
                ['step' => 'Step 7', 'amount' => 19798],
                ['step' => 'Step 8', 'amount' => 19978],
            ],
            // 9
            [
                ['step' => 'Step 1', 'amount' => 20150],
                ['step' => 'Step 2', 'amount' => 20319],
                ['step' => 'Step 3', 'amount' => 20489],
                ['step' => 'Step 4', 'amount' => 20660],
                ['step' => 'Step 5', 'amount' => 20833],
                ['step' => 'Step 6', 'amount' => 21006],
                ['step' => 'Step 7', 'amount' => 21182],
                ['step' => 'Step 8', 'amount' => 21359],
            ],
            // 10
            [
                ['step' => 'Step 1', 'amount' => 22017],
                ['step' => 'Step 2', 'amount' => 22202],
                ['step' => 'Step 3', 'amount' => 22387],
                ['step' => 'Step 4', 'amount' => 22574],
                ['step' => 'Step 5', 'amount' => 22763],
                ['step' => 'Step 6', 'amount' => 22953],
                ['step' => 'Step 7', 'amount' => 23145],
                ['step' => 'Step 8', 'amount' => 23339],
            ],
            // 11
            [
                ['step' => 'Step 1', 'amount' => 25650],
                ['step' => 'Step 2', 'amount' => 25920],
                ['step' => 'Step 3', 'amount' => 26194],
                ['step' => 'Step 4', 'amount' => 26472],
                ['step' => 'Step 5', 'amount' => 26753],
                ['step' => 'Step 6', 'amount' => 27039],
                ['step' => 'Step 7', 'amount' => 27328],
                ['step' => 'Step 8', 'amount' => 27621],
            ],
            // 12
            [
                ['step' => 'Step 1', 'amount' => 27707],
                ['step' => 'Step 2', 'amount' => 27977],
                ['step' => 'Step 3', 'amount' => 28250],
                ['step' => 'Step 4', 'amount' => 28527],
                ['step' => 'Step 5', 'amount' => 28807],
                ['step' => 'Step 6', 'amount' => 29091],
                ['step' => 'Step 7', 'amount' => 29378],
                ['step' => 'Step 8', 'amount' => 29669],
            ],
            // 13
            [
                ['step' => 'Step 1', 'amount' => 29754],
                ['step' => 'Step 2', 'amount' => 30051],
                ['step' => 'Step 3', 'amount' => 30352],
                ['step' => 'Step 4', 'amount' => 30656],
                ['step' => 'Step 5', 'amount' => 30964],
                ['step' => 'Step 6', 'amount' => 31276],
                ['step' => 'Step 7', 'amount' => 31591],
                ['step' => 'Step 8', 'amount' => 31911],
            ],
            // 14
            [
                ['step' => 'Step 1', 'amount' => 32151],
                ['step' => 'Step 2', 'amount' => 32478],
                ['step' => 'Step 3', 'amount' => 32808],
                ['step' => 'Step 4', 'amount' => 33144],
                ['step' => 'Step 5', 'amount' => 33482],
                ['step' => 'Step 6', 'amount' => 33825],
                ['step' => 'Step 7', 'amount' => 34172],
                ['step' => 'Step 8', 'amount' => 34524],
            ],
            // 15
            [
                ['step' => 'Step 1', 'amount' => 34788],
                ['step' => 'Step 2', 'amount' => 35147],
                ['step' => 'Step 3', 'amount' => 35511],
                ['step' => 'Step 4', 'amount' => 35880],
                ['step' => 'Step 5', 'amount' => 36252],
                ['step' => 'Step 6', 'amount' => 36629],
                ['step' => 'Step 7', 'amount' => 37011],
                ['step' => 'Step 8', 'amount' => 37399],
            ],
            // 16
            [
                ['step' => 'Step 1', 'amount' => 37688],
                ['step' => 'Step 2', 'amount' => 38084],
                ['step' => 'Step 3', 'amount' => 38484],
                ['step' => 'Step 4', 'amount' => 38888],
                ['step' => 'Step 5', 'amount' => 39299],
                ['step' => 'Step 6', 'amount' => 39740],
                ['step' => 'Step 7', 'amount' => 40135],
                ['step' => 'Step 8', 'amount' => 40559],
            ],
            // 17
            [
                ['step' => 'Step 1', 'amount' => 40879],
                ['step' => 'Step 2', 'amount' => 41314],
                ['step' => 'Step 3', 'amount' => 41753],
                ['step' => 'Step 4', 'amount' => 42199],
                ['step' => 'Step 5', 'amount' => 42650],
                ['step' => 'Step 6', 'amount' => 43107],
                ['step' => 'Step 7', 'amount' => 43569],
                ['step' => 'Step 8', 'amount' => 44037],
            ],
            // 18
            [
                ['step' => 'Step 1', 'amount' => 44389],
                ['step' => 'Step 2', 'amount' => 44867],
                ['step' => 'Step 3', 'amount' => 45351],
                ['step' => 'Step 4', 'amount' => 45840],
                ['step' => 'Step 5', 'amount' => 46337],
                ['step' => 'Step 6', 'amount' => 46840],
                ['step' => 'Step 7', 'amount' => 47348],
                ['step' => 'Step 8', 'amount' => 47863],
            ],
            // 19
            [
                ['step' => 'Step 1', 'amount' => 48789],
                ['step' => 'Step 2', 'amount' => 49491],
                ['step' => 'Step 3', 'amount' => 50205],
                ['step' => 'Step 4', 'amount' => 50930],
                ['step' => 'Step 5', 'amount' => 50930],
                ['step' => 'Step 6', 'amount' => 52415],
                ['step' => 'Step 7', 'amount' => 53177],
                ['step' => 'Step 8', 'amount' => 53951],
            ],
            // 20
            [
                ['step' => 'Step 1', 'amount' => 54480],
                ['step' => 'Step 2', 'amount' => 55272],
                ['step' => 'Step 3', 'amount' => 56079],
                ['step' => 'Step 4', 'amount' => 56897],
                ['step' => 'Step 5', 'amount' => 57731],
                ['step' => 'Step 6', 'amount' => 58577],
                ['step' => 'Step 7', 'amount' => 59437],
                ['step' => 'Step 8', 'amount' => 60311],
            ],
            // 21
            [
                ['step' => 'Step 1', 'amount' => 60797],
                ['step' => 'Step 2', 'amount' => 61693],
                ['step' => 'Step 3', 'amount' => 62604],
                ['step' => 'Step 4', 'amount' => 63529],
                ['step' => 'Step 5', 'amount' => 64471],
                ['step' => 'Step 6', 'amount' => 65427],
                ['step' => 'Step 7', 'amount' => 66398],
                ['step' => 'Step 8', 'amount' => 67386],
            ],
            // 22
            [
                ['step' => 'Step 1', 'amount' => 67935],
                ['step' => 'Step 2', 'amount' => 68948],
                ['step' => 'Step 3', 'amount' => 69978],
                ['step' => 'Step 4', 'amount' => 71024],
                ['step' => 'Step 5', 'amount' => 72087],
                ['step' => 'Step 6', 'amount' => 73168],
                ['step' => 'Step 7', 'amount' => 74266],
                ['step' => 'Step 8', 'amount' => 75382],
            ],
            // 23
            [
                ['step' => 'Step 1', 'amount' => 76003],
                ['step' => 'Step 2', 'amount' => 77147],
                ['step' => 'Step 3', 'amount' => 78310],
                ['step' => 'Step 4', 'amount' => 79499],
                ['step' => 'Step 5', 'amount' => 80797],
                ['step' => 'Step 6', 'amount' => 82115],
                ['step' => 'Step 7', 'amount' => 83455],
                ['step' => 'Step 8', 'amount' => 84817],
            ],
            // 24
            [
                ['step' => 'Step 1', 'amount' => 85574],
                ['step' => 'Step 2', 'amount' => 86971],
                ['step' => 'Step 3', 'amount' => 88391],
                ['step' => 'Step 4', 'amount' => 89834],
                ['step' => 'Step 5', 'amount' => 91300],
                ['step' => 'Step 6', 'amount' => 92790],
                ['step' => 'Step 7', 'amount' => 94305],
                ['step' => 'Step 8', 'amount' => 95844],
            ],
            // 25
            [
                ['step' => 'Step 1', 'amount' => 97556],
                ['step' => 'Step 2', 'amount' => 99148],
                ['step' => 'Step 3', 'amount' => 100766],
                ['step' => 'Step 4', 'amount' => 102410],
                ['step' => 'Step 5', 'amount' => 104082],
                ['step' => 'Step 6', 'amount' => 105781],
                ['step' => 'Step 7', 'amount' => 107508],
                ['step' => 'Step 8', 'amount' => 109261],
            ],
            // 26
            [
                ['step' => 'Step 1', 'amount' => 110238],
                ['step' => 'Step 2', 'amount' => 112036],
                ['step' => 'Step 3', 'amount' => 113865],
                ['step' => 'Step 4', 'amount' => 115723],
                ['step' => 'Step 5', 'amount' => 117613],
                ['step' => 'Step 6', 'amount' => 119532],
                ['step' => 'Step 7', 'amount' => 121482],
                ['step' => 'Step 8', 'amount' => 123466],
            ],
            // 27
            [
                ['step' => 'Step 1', 'amount' => 124568],
                ['step' => 'Step 2', 'amount' => 126601],
                ['step' => 'Step 3', 'amount' => 128668],
                ['step' => 'Step 4', 'amount' => 130768],
                ['step' => 'Step 5', 'amount' => 132902],
                ['step' => 'Step 6', 'amount' => 135071],
                ['step' => 'Step 7', 'amount' => 137276],
                ['step' => 'Step 8', 'amount' => 139516],
            ],
            // 28
            [
                ['step' => 'Step 1', 'amount' => 140762],
                ['step' => 'Step 2', 'amount' => 143060],
                ['step' => 'Step 3', 'amount' => 145395],
                ['step' => 'Step 4', 'amount' => 147768],
                ['step' => 'Step 5', 'amount' => 150179],
                ['step' => 'Step 6', 'amount' => 152631],
                ['step' => 'Step 7', 'amount' => 155122],
                ['step' => 'Step 8', 'amount' => 157653],
            ],
            // 29
            [
                ['step' => 'Step 1', 'amount' => 159060],
                ['step' => 'Step 2', 'amount' => 161658],
                ['step' => 'Step 3', 'amount' => 164296],
                ['step' => 'Step 4', 'amount' => 166978],
                ['step' => 'Step 5', 'amount' => 169702],
                ['step' => 'Step 6', 'amount' => 172473],
                ['step' => 'Step 7', 'amount' => 175287],
                ['step' => 'Step 8', 'amount' => 178149],
            ],
            // 30
            [
                ['step' => 'Step 1', 'amount' => 179739],
                ['step' => 'Step 2', 'amount' => 182672],
                ['step' => 'Step 3', 'amount' => 185654],
                ['step' => 'Step 4', 'amount' => 188684],
                ['step' => 'Step 5', 'amount' => 191763],
                ['step' => 'Step 6', 'amount' => 194893],
                ['step' => 'Step 7', 'amount' => 198074],
                ['step' => 'Step 8', 'amount' => 201307],
            ],

        ];
        // dd($salary_grades);
        // Loop through the sa;art grades array and create records
        foreach ($salary_grades as $salary_grade) {
            SalaryGrade::create([
                'steps' => $salary_grade
            ]);
        }
    }
}
