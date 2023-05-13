<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;

class AllConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("TRUNCATE TABLE db_con RESTART IDENTITY;");

        $data = [
            [
                "m_w_id" => "1",
                "m_w_m_area_id" => "9",
                "location" => "pusat",
                "m_w_nama" => "kantor pusat",
                "host" => "10.20.30.21"
            ],
            [
                "m_w_id" => "2",
                "m_w_m_area_id" => "9",
                "location" => "waroeng",
                "m_w_nama" => "training center 1",
                "host" => "10.20.30.22"
            ],
            [
                "m_w_id" => "3",
                "m_w_m_area_id" => "9",
                "location" => "area",
                "m_w_nama" => "kantor ss supply pusat",
                "host" => "10.20.30.23"
            ],
            [
                "m_w_id" => "4",
                "m_w_m_area_id" => "9",
                "location" => "area",
                "m_w_nama" => "kantor ss supply solo",
                "host" => "10.20.30.24"
            ],
            [
                "m_w_id" => "5",
                "m_w_m_area_id" => "9",
                "location" => "area",
                "m_w_nama" => "kantor eksternal",
                "host" => "10.20.30.25"
            ],
            [
                "m_w_id" => "6",
                "m_w_m_area_id" => "1",
                "location" => "area",
                "m_w_nama" => "kantor area jabodetabek",
                "host" => "10.20.30.26"
            ],
            [
                "m_w_id" => "7",
                "m_w_m_area_id" => "1",
                "location" => "waroeng",
                "m_w_nama" => "wss kisamaun",
                "host" => "10.20.30.27"
            ],
            [
                "m_w_id" => "8",
                "m_w_m_area_id" => "1",
                "location" => "waroeng",
                "m_w_nama" => "wss kisamaun #2",
                "host" => "10.20.30.28"
            ],
            [
                "m_w_id" => "9",
                "m_w_m_area_id" => "1",
                "location" => "waroeng",
                "m_w_nama" => "wss bsd",
                "host" => "10.20.30.29"
            ],
            [
                "m_w_id" => "10",
                "m_w_m_area_id" => "1",
                "location" => "waroeng",
                "m_w_nama" => "wss karawaci",
                "host" => "10.20.30.30"
            ],
            [
                "m_w_id" => "11",
                "m_w_m_area_id" => "1",
                "location" => "waroeng",
                "m_w_nama" => "wss bintaro 1",
                "host" => "10.20.30.31"
            ],
            [
                "m_w_id" => "12",
                "m_w_m_area_id" => "1",
                "location" => "waroeng",
                "m_w_nama" => "wss citra raya",
                "host" => "10.20.30.32"
            ],
            [
                "m_w_id" => "13",
                "m_w_m_area_id" => "1",
                "location" => "waroeng",
                "m_w_nama" => "wss l'agricola",
                "host" => "10.20.30.33"
            ],
            [
                "m_w_id" => "14",
                "m_w_m_area_id" => "1",
                "location" => "waroeng",
                "m_w_nama" => "wss gading serpong",
                "host" => "10.20.30.34"
            ],
            [
                "m_w_id" => "15",
                "m_w_m_area_id" => "1",
                "location" => "waroeng",
                "m_w_nama" => "wss bogor yasmin",
                "host" => "10.20.30.35"
            ],
            [
                "m_w_id" => "16",
                "m_w_m_area_id" => "1",
                "location" => "waroeng",
                "m_w_nama" => "wss greenville",
                "host" => "10.20.30.36"
            ],
            [
                "m_w_id" => "17",
                "m_w_m_area_id" => "1",
                "location" => "waroeng",
                "m_w_nama" => "wss palem semi",
                "host" => "10.20.30.37"
            ],
            [
                "m_w_id" => "18",
                "m_w_m_area_id" => "1",
                "location" => "waroeng",
                "m_w_nama" => "wss bintaro 2",
                "host" => "10.20.30.38"
            ],
            [
                "m_w_id" => "19",
                "m_w_m_area_id" => "1",
                "location" => "waroeng",
                "m_w_nama" => "wss tanjung duren utara",
                "host" => "10.20.30.39"
            ],
            [
                "m_w_id" => "20",
                "m_w_m_area_id" => "1",
                "location" => "waroeng",
                "m_w_nama" => "wss bekasi",
                "host" => "10.20.30.40"
            ],
            [
                "m_w_id" => "21",
                "m_w_m_area_id" => "1",
                "location" => "waroeng",
                "m_w_nama" => "wss tamansari",
                "host" => "null"
            ],
            [
                "m_w_id" => "22",
                "m_w_m_area_id" => "1",
                "location" => "waroeng",
                "m_w_nama" => "wss jatinangor",
                "host" => "10.20.30.42"
            ],
            [
                "m_w_id" => "23",
                "m_w_m_area_id" => "1",
                "location" => "waroeng",
                "m_w_nama" => "wss bawean",
                "host" => "10.20.30.43"
            ],
            [
                "m_w_id" => "24",
                "m_w_m_area_id" => "1",
                "location" => "waroeng",
                "m_w_nama" => "wss depok margonda",
                "host" => "10.20.30.44"
            ],
            [
                "m_w_id" => "25",
                "m_w_m_area_id" => "1",
                "location" => "waroeng",
                "m_w_nama" => "wss depok sawangan",
                "host" => "10.20.30.45"
            ],
            [
                "m_w_id" => "26",
                "m_w_m_area_id" => "1",
                "location" => "waroeng",
                "m_w_nama" => "wss bogor ahmad yani",
                "host" => "10.20.30.46"
            ],
            [
                "m_w_id" => "27",
                "m_w_m_area_id" => "2",
                "location" => "area",
                "m_w_nama" => "kantor area purwokerto",
                "host" => "10.20.30.47"
            ],
            [
                "m_w_id" => "28",
                "m_w_m_area_id" => "2",
                "location" => "waroeng",
                "m_w_nama" => "wss tegal",
                "host" => "10.20.30.48"
            ],
            [
                "m_w_id" => "29",
                "m_w_m_area_id" => "2",
                "location" => "waroeng",
                "m_w_nama" => "wss cirebon ampera",
                "host" => "10.20.30.49"
            ],
            [
                "m_w_id" => "30",
                "m_w_m_area_id" => "2",
                "location" => "waroeng",
                "m_w_nama" => "wss cirebon tuparev",
                "host" => "10.20.30.50"
            ],
            [
                "m_w_id" => "31",
                "m_w_m_area_id" => "2",
                "location" => "waroeng",
                "m_w_nama" => "wss purwokerto gor satria",
                "host" => "10.20.30.51"
            ],
            [
                "m_w_id" => "32",
                "m_w_m_area_id" => "2",
                "location" => "waroeng",
                "m_w_nama" => "wss purwokerto wiryaatmaja",
                "host" => "10.20.30.52"
            ],
            [
                "m_w_id" => "33",
                "m_w_m_area_id" => "2",
                "location" => "waroeng",
                "m_w_nama" => "wss cilacap",
                "host" => "10.20.30.53"
            ],
            [
                "m_w_id" => "34",
                "m_w_m_area_id" => "2",
                "location" => "waroeng",
                "m_w_nama" => "wss tasikmalaya",
                "host" => "10.20.30.54"
            ],
            [
                "m_w_id" => "35",
                "m_w_m_area_id" => "2",
                "location" => "waroeng",
                "m_w_nama" => "wss wonosobo",
                "host" => "10.20.30.55"
            ],
            [
                "m_w_id" => "36",
                "m_w_m_area_id" => "3",
                "location" => "area",
                "m_w_nama" => "kantor area semarang",
                "host" => "10.20.30.56"
            ],
            [
                "m_w_id" => "37",
                "m_w_m_area_id" => "3",
                "location" => "waroeng",
                "m_w_nama" => "wss sompok",
                "host" => "10.20.30.57"
            ],
            [
                "m_w_id" => "38",
                "m_w_m_area_id" => "3",
                "location" => "waroeng",
                "m_w_nama" => "wss banyumanik",
                "host" => "10.20.30.58"
            ],
            [
                "m_w_id" => "39",
                "m_w_m_area_id" => "3",
                "location" => "waroeng",
                "m_w_nama" => "wss puri anjasmoro",
                "host" => "10.20.30.59"
            ],
            [
                "m_w_id" => "40",
                "m_w_m_area_id" => "3",
                "location" => "waroeng",
                "m_w_nama" => "wss sambiroto",
                "host" => "10.20.30.60"
            ],
            [
                "m_w_id" => "41",
                "m_w_m_area_id" => "3",
                "location" => "waroeng",
                "m_w_nama" => "wss lampersari",
                "host" => "10.20.30.61"
            ],
            [
                "m_w_id" => "42",
                "m_w_m_area_id" => "3",
                "location" => "waroeng",
                "m_w_nama" => "wss ngaliyan",
                "host" => "10.20.30.62"
            ],
            [
                "m_w_id" => "43",
                "m_w_m_area_id" => "3",
                "location" => "waroeng",
                "m_w_nama" => "wss salatiga diponegoro",
                "host" => "10.20.30.63"
            ],
            [
                "m_w_id" => "44",
                "m_w_m_area_id" => "3",
                "location" => "waroeng",
                "m_w_nama" => "wss salatiga sudirman",
                "host" => "10.20.30.64"
            ],
            [
                "m_w_id" => "45",
                "m_w_m_area_id" => "3",
                "location" => "waroeng",
                "m_w_nama" => "wss pekalongan",
                "host" => "10.20.30.65"
            ],
            [
                "m_w_id" => "46",
                "m_w_m_area_id" => "3",
                "location" => "waroeng",
                "m_w_nama" => "wss ungaran",
                "host" => "10.20.30.66"
            ],
            [
                "m_w_id" => "47",
                "m_w_m_area_id" => "3",
                "location" => "waroeng",
                "m_w_nama" => "wss pati",
                "host" => "10.20.30.67"
            ],
            [
                "m_w_id" => "48",
                "m_w_m_area_id" => "3",
                "location" => "waroeng",
                "m_w_nama" => "wss sampangan",
                "host" => "10.20.30.68"
            ],
            [
                "m_w_id" => "49",
                "m_w_m_area_id" => "3",
                "location" => "waroeng",
                "m_w_nama" => "wss tembalang",
                "host" => "10.20.30.69"
            ],
            [
                "m_w_id" => "50",
                "m_w_m_area_id" => "3",
                "location" => "waroeng",
                "m_w_nama" => "wss kudus",
                "host" => "10.20.30.70"
            ],
            [
                "m_w_id" => "51",
                "m_w_m_area_id" => "3",
                "location" => "waroeng",
                "m_w_nama" => "wss bawen",
                "host" => "10.20.30.71"
            ],
            [
                "m_w_id" => "52",
                "m_w_m_area_id" => "5",
                "location" => "area",
                "m_w_nama" => "kantor area jogja",
                "host" => "10.20.30.72"
            ],
            [
                "m_w_id" => "53",
                "m_w_m_area_id" => "5",
                "location" => "waroeng",
                "m_w_nama" => "wss perjuangan",
                "host" => "null"
            ],
            [
                "m_w_id" => "54",
                "m_w_m_area_id" => "5",
                "location" => "waroeng",
                "m_w_nama" => "wss condong catur barat",
                "host" => "10.20.30.74"
            ],
            [
                "m_w_id" => "55",
                "m_w_m_area_id" => "5",
                "location" => "waroeng",
                "m_w_nama" => "wss condong catur timur",
                "host" => "10.20.30.75"
            ],
            [
                "m_w_id" => "56",
                "m_w_m_area_id" => "5",
                "location" => "waroeng",
                "m_w_nama" => "wss pandega martha",
                "host" => "10.20.30.76"
            ],
            [
                "m_w_id" => "57",
                "m_w_m_area_id" => "5",
                "location" => "waroeng",
                "m_w_nama" => "wss samirono",
                "host" => "10.20.30.77"
            ],
            [
                "m_w_id" => "58",
                "m_w_m_area_id" => "5",
                "location" => "waroeng",
                "m_w_nama" => "wss jakal km 8",
                "host" => "10.20.30.78"
            ],
            [
                "m_w_id" => "59",
                "m_w_m_area_id" => "5",
                "location" => "waroeng",
                "m_w_nama" => "wss gedongkuning",
                "host" => "10.20.30.79"
            ],
            [
                "m_w_id" => "60",
                "m_w_m_area_id" => "5",
                "location" => "waroeng",
                "m_w_nama" => "wss plengkung gading",
                "host" => "10.20.30.80"
            ],
            [
                "m_w_id" => "61",
                "m_w_m_area_id" => "5",
                "location" => "waroeng",
                "m_w_nama" => "wss veteran",
                "host" => "10.20.30.81"
            ],
            [
                "m_w_id" => "62",
                "m_w_m_area_id" => "5",
                "location" => "waroeng",
                "m_w_nama" => "wss monjali",
                "host" => "10.20.30.82"
            ],
            [
                "m_w_id" => "63",
                "m_w_m_area_id" => "5",
                "location" => "waroeng",
                "m_w_nama" => "wss maguwoharjo",
                "host" => "10.20.30.83"
            ],
            [
                "m_w_id" => "64",
                "m_w_m_area_id" => "5",
                "location" => "waroeng",
                "m_w_nama" => "wss bantul",
                "host" => "10.20.30.85"
            ],
            [
                "m_w_id" => "65",
                "m_w_m_area_id" => "5",
                "location" => "waroeng",
                "m_w_nama" => "wss kyai mojo",
                "host" => "10.20.30.86"
            ],
            [
                "m_w_id" => "66",
                "m_w_m_area_id" => "5",
                "location" => "waroeng",
                "m_w_nama" => "wss megatruh",
                "host" => "null"
            ],
            [
                "m_w_id" => "67",
                "m_w_m_area_id" => "5",
                "location" => "waroeng",
                "m_w_nama" => "ss express megatruh",
                "host" => "10.20.30.88"
            ],
            [
                "m_w_id" => "68",
                "m_w_m_area_id" => "5",
                "location" => "waroeng",
                "m_w_nama" => "wss kledokan",
                "host" => "10.20.30.89"
            ],
            [
                "m_w_id" => "69",
                "m_w_m_area_id" => "5",
                "location" => "area",
                "m_w_nama" => "dapur 1 yogyakarta",
                "host" => "null"
            ],
            [
                "m_w_id" => "70",
                "m_w_m_area_id" => "4",
                "location" => "area",
                "m_w_nama" => "kantor area perintis",
                "host" => "10.20.30.91"
            ],
            [
                "m_w_id" => "71",
                "m_w_m_area_id" => "4",
                "location" => "waroeng",
                "m_w_nama" => "wss sewon",
                "host" => "10.20.30.92"
            ],
            [
                "m_w_id" => "72",
                "m_w_m_area_id" => "4",
                "location" => "waroeng",
                "m_w_nama" => "wss magelang",
                "host" => "10.20.30.93"
            ],
            [
                "m_w_id" => "73",
                "m_w_m_area_id" => "4",
                "location" => "waroeng",
                "m_w_nama" => "wss prambanan",
                "host" => "10.20.30.94"
            ],
            [
                "m_w_id" => "74",
                "m_w_m_area_id" => "4",
                "location" => "waroeng",
                "m_w_nama" => "wss palagan",
                "host" => "10.20.30.95"
            ],
            [
                "m_w_id" => "75",
                "m_w_m_area_id" => "4",
                "location" => "waroeng",
                "m_w_nama" => "wss wonosari",
                "host" => "10.20.30.96"
            ],
            [
                "m_w_id" => "76",
                "m_w_m_area_id" => "4",
                "location" => "waroeng",
                "m_w_nama" => "wss temanggung",
                "host" => "10.20.30.97"
            ],
            [
                "m_w_id" => "77",
                "m_w_m_area_id" => "4",
                "location" => "waroeng",
                "m_w_nama" => "wss kupatan",
                "host" => "10.20.30.98"
            ],
            [
                "m_w_id" => "78",
                "m_w_m_area_id" => "4",
                "location" => "waroeng",
                "m_w_nama" => "wss muntilan",
                "host" => "10.20.30.99"
            ],
            [
                "m_w_id" => "79",
                "m_w_m_area_id" => "4",
                "location" => "waroeng",
                "m_w_nama" => "wss ambarketawang",
                "host" => "10.20.30.100"
            ],
            [
                "m_w_id" => "80",
                "m_w_m_area_id" => "4",
                "location" => "waroeng",
                "m_w_nama" => "wss tekim",
                "host" => "null"
            ],
            [
                "m_w_id" => "81",
                "m_w_m_area_id" => "4",
                "location" => "waroeng",
                "m_w_nama" => "wss jakal km 12",
                "host" => "null"
            ],
            [
                "m_w_id" => "82",
                "m_w_m_area_id" => "4",
                "location" => "waroeng",
                "m_w_nama" => "wss kulonprogo",
                "host" => "10.20.30.103"
            ],
            [
                "m_w_id" => "83",
                "m_w_m_area_id" => "6",
                "location" => "area",
                "m_w_nama" => "kantor area solo",
                "host" => "10.20.30.104"
            ],
            [
                "m_w_id" => "84",
                "m_w_m_area_id" => "6",
                "location" => "waroeng",
                "m_w_nama" => "wss boyolali perintis",
                "host" => "10.20.30.105"
            ],
            [
                "m_w_id" => "85",
                "m_w_m_area_id" => "6",
                "location" => "waroeng",
                "m_w_nama" => "wss sragen",
                "host" => "10.20.30.106"
            ],
            [
                "m_w_id" => "86",
                "m_w_m_area_id" => "6",
                "location" => "waroeng",
                "m_w_nama" => "wss karanganyar",
                "host" => "10.20.30.107"
            ],
            [
                "m_w_id" => "87",
                "m_w_m_area_id" => "6",
                "location" => "waroeng",
                "m_w_nama" => "wss patimura",
                "host" => "10.20.30.108"
            ],
            [
                "m_w_id" => "88",
                "m_w_m_area_id" => "6",
                "location" => "waroeng",
                "m_w_nama" => "wss manahan barat",
                "host" => "10.20.30.109"
            ],
            [
                "m_w_id" => "89",
                "m_w_m_area_id" => "6",
                "location" => "waroeng",
                "m_w_nama" => "wss gonilan",
                "host" => "10.20.30.110"
            ],
            [
                "m_w_id" => "90",
                "m_w_m_area_id" => "6",
                "location" => "waroeng",
                "m_w_nama" => "wss solo baru",
                "host" => "10.20.30.111"
            ],
            [
                "m_w_id" => "91",
                "m_w_m_area_id" => "6",
                "location" => "waroeng",
                "m_w_nama" => "wss jurug",
                "host" => "10.20.30.112"
            ],
            [
                "m_w_id" => "92",
                "m_w_m_area_id" => "6",
                "location" => "waroeng",
                "m_w_nama" => "wss kerten",
                "host" => "10.20.30.113"
            ],
            [
                "m_w_id" => "93",
                "m_w_m_area_id" => "6",
                "location" => "waroeng",
                "m_w_nama" => "wss klaten",
                "host" => "10.20.30.114"
            ],
            [
                "m_w_id" => "94",
                "m_w_m_area_id" => "6",
                "location" => "waroeng",
                "m_w_nama" => "wss wonogiri",
                "host" => "10.20.30.115"
            ],
            [
                "m_w_id" => "95",
                "m_w_m_area_id" => "6",
                "location" => "waroeng",
                "m_w_nama" => "wss manahan timur",
                "host" => "10.20.30.116"
            ],
            [
                "m_w_id" => "96",
                "m_w_m_area_id" => "6",
                "location" => "waroeng",
                "m_w_nama" => "wss boyolali heritage",
                "host" => "10.20.30.117"
            ],
            [
                "m_w_id" => "97",
                "m_w_m_area_id" => "6",
                "location" => "waroeng",
                "m_w_nama" => "wss banyudono",
                "host" => "10.20.30.118"
            ],
            [
                "m_w_id" => "98",
                "m_w_m_area_id" => "6",
                "location" => "waroeng",
                "m_w_nama" => "wss kopral sayom",
                "host" => "10.20.30.119"
            ],
            [
                "m_w_id" => "99",
                "m_w_m_area_id" => "6",
                "location" => "area",
                "m_w_nama" => "dapur 1 solo",
                "host" => "null"
            ],
            [
                "m_w_id" => "100",
                "m_w_m_area_id" => "6",
                "location" => "waroeng",
                "m_w_nama" => "wss klodran",
                "host" => "10.20.30.121"
            ],
            [
                "m_w_id" => "101",
                "m_w_m_area_id" => "7",
                "location" => "area",
                "m_w_nama" => "kantor area malang",
                "host" => "10.20.30.122"
            ],
            [
                "m_w_id" => "102",
                "m_w_m_area_id" => "7",
                "location" => "waroeng",
                "m_w_nama" => "wss kediri",
                "host" => "10.20.30.123"
            ],
            [
                "m_w_id" => "103",
                "m_w_m_area_id" => "7",
                "location" => "waroeng",
                "m_w_nama" => "wss malang sengkaling",
                "host" => "10.20.30.124"
            ],
            [
                "m_w_id" => "104",
                "m_w_m_area_id" => "7",
                "location" => "waroeng",
                "m_w_nama" => "wss malang ciliwung",
                "host" => "10.20.30.125"
            ],
            [
                "m_w_id" => "105",
                "m_w_m_area_id" => "7",
                "location" => "waroeng",
                "m_w_nama" => "wss jember",
                "host" => "10.20.30.126"
            ],
            [
                "m_w_id" => "106",
                "m_w_m_area_id" => "7",
                "location" => "waroeng",
                "m_w_nama" => "wss madiun",
                "host" => "10.20.30.127"
            ],
            [
                "m_w_id" => "107",
                "m_w_m_area_id" => "7",
                "location" => "waroeng",
                "m_w_nama" => "wss surabaya arjuna raya",
                "host" => "10.20.30.128"
            ],
            [
                "m_w_id" => "108",
                "m_w_m_area_id" => "7",
                "location" => "waroeng",
                "m_w_nama" => "wss malang la sucipto",
                "host" => "10.20.30.129"
            ],
            [
                "m_w_id" => "109",
                "m_w_m_area_id" => "7",
                "location" => "waroeng",
                "m_w_nama" => "wss surabaya rungkut",
                "host" => "10.20.30.130"
            ],
            [
                "m_w_id" => "110",
                "m_w_m_area_id" => "8",
                "location" => "area",
                "m_w_nama" => "kantor area bali",
                "host" => "10.20.30.131"
            ],
            [
                "m_w_id" => "111",
                "m_w_m_area_id" => "8",
                "location" => "waroeng",
                "m_w_nama" => "wss bali batubulan",
                "host" => "10.20.30.132"
            ],
            [
                "m_w_id" => "112",
                "m_w_m_area_id" => "8",
                "location" => "waroeng",
                "m_w_nama" => "wss bali tukad barito",
                "host" => "10.20.30.133"
            ],
            [
                "m_w_id" => "113",
                "m_w_m_area_id" => "8",
                "location" => "waroeng",
                "m_w_nama" => "wss bali uluwatu",
                "host" => "10.20.30.134"
            ],
            [
                "m_w_id" => "114",
                "m_w_m_area_id" => "8",
                "location" => "waroeng",
                "m_w_nama" => "wss bali gatot subroto",
                "host" => "10.20.30.135"
            ],
            [
                "m_w_id" => "115",
                "m_w_m_area_id" => "8",
                "location" => "waroeng",
                "m_w_nama" => "wss bali teuku umar",
                "host" => "10.20.30.136"
            ],
            [
                "m_w_id" => "116",
                "m_w_m_area_id" => "11",
                "location" => "area",
                "m_w_nama" => "kantor area malaysia",
                "host" => "null"
            ],
            [
                "m_w_id" => "117",
                "m_w_m_area_id" => "11",
                "location" => "waroeng",
                "m_w_nama" => "wss ttdi kuala lumpur",
                "host" => "10.20.30.138"
            ],
            [
                "m_w_id" => "118",
                "m_w_m_area_id" => "6",
                "location" => "area",
                "m_w_nama" => "dapur sub area solo",
                "host" => "null"
            ]
        ];

        foreach ($data as $key => $val) {
            DB::table('db_con')->insert([
                'db_con_m_w_id' => $val['m_w_id'],
                'db_con_m_area_id' => $val['m_w_m_area_id'],
                'db_con_location' => $val['location'],
                'db_con_location_name' => $val['m_w_nama'],
                'db_con_data_status' => 'destination',
                'db_con_sync_status' => 'tidak',
                'db_con_host' => $val['host'],
                'db_con_port' => '5432',
                'db_con_dbname' => 'admin_sipedas_v4',
                'db_con_username' => 'admin_root',
                'db_con_password' => Helper::customCrypt('Waroeng@55'),
            ]);
        }
    }
}
