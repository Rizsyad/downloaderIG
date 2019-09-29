<?php
system ("clear");

$white = "\e[97m";
$black = "\e[30m\e[1m";
$yellow = "\e[93m";
$orange = "\e[38;5;208m";
$blue   = "\e[34m";
$lblue  = "\e[36m";
$cln    = "\e[0m";
$green  = "\e[92m";
$fgreen = "\e[32m";
$red    = "\e[91m";
$magenta = "\e[35m";
$bluebg = "\e[44m";
$lbluebg = "\e[106m";
$greenbg = "\e[42m";
$lgreenbg = "\e[102m";
$yellowbg = "\e[43m";
$lyellowbg = "\e[103m";
$redbg = "\e[101m";
$grey = "\e[37m";
$cyan = "\e[36m";
$bold   = "\e[1m";

echo "$cyan
 __                      _                 _           _ ____
|  _ \  _      _ | | _ _  | | _ _ __|_ _/ ___|
| | | |/ _ \ \ /\ / | '_ \| |/ _ \ / _` |/ _` |/ _ | '__ | | |  _
| |_| | (_) \ V  V /| | | | | (_) | (_| | (_| |  __| |   | | |_| |
|____/ \___/ \_/\_/ |_| |_|_|\___/ \__,_|\__,_|\___|_|  |___\____|
$cln        $fgreen    By Rizsyad AR $cln \e[96m
==================================================================

";

function get_image($url_toget)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://instapick.net/instagram-service.php");
    curl_setopt($ch, CURLOPT_USERAGENT, "indscbot");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "url=".$url_toget);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);

    curl_close($ch);

    return $result;
}

echo "$bold $lblue [?] Masukan URL Instagram yang ingin didownload: ".$cln;
$urls = trim(fgets(STDIN, 1024));

echo "$bold $yellow [!] Sedang mencari media target... \n".$cln;

sleep(4);

$json_decode = json_decode(get_image($urls));

if ($json_decode->status != "success") { echo "$bold $red [-] Gagal mendapatkan media target... \n".$cln; exit(); }

echo "$bold $green [+] Berhasil mendapatkan media target... \n".$cln;
sleep(2);
echo "$bold $yellow [!] Sedang mengambil informasi target... \n".$cln;
sleep(3);
echo "$blod $green [+] Berhasil mendapatkan informasi target... \n\n".$cln;
sleep(2);

echo "$bold $white Username: $magenta ".$json_decode->username."\n".$cln;
echo "$bold $white Nama:  $magenta".$json_decode->full_name."\n\n".$cln;

$no = 0;
$medias = [];

foreach ($json_decode->medias as $media) {
    $no++;
    echo $bold.$white.$no.".  $magenta".$media[0]." $yellow [".$media[1]."]".$cln."\n\n";
    array_push($medias, $media[0]);
}

echo "$bold $lblue [?] Masukan nomer yang ingin didownlod ex. (1) or (1,2) to multiple: ".$cln;
$download_media = trim(fgets(STDIN, 1024));

$array_media = explode(",", $download_media);

echo "$bold $yellow [!] Sedang mendownload media... \n".$cln;
sleep(4);

foreach ($array_media as $key => $value) {
    if(!$preg_match = preg_match_all('/(.*)\.(.*)\?/si', $medias[$value-1], $matches)) { echo "$bold $red [-] Gagal untuk mendownload media... \n".$cln; exit(); }
    system("curl -s -o "."media-".uniqid().".".$matches[2][0]. " " .$medias[$value-1]);
}

echo "$bold $green [+] Download telah selesai \n\n".$cln;