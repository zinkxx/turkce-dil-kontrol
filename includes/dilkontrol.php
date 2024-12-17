<?php
// LanguageTool API kullanarak Türkçe dil kontrolü
function turkce_dilkontrol_analyze($content) {
    $api_url = 'https://api.languagetool.org/v2/check';

    // API'ye gönderilecek veriler
    $data = array(
        'text' => $content,
        'language' => 'tr'
    );

    // cURL ile API isteği
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

    $response = curl_exec($ch);
    curl_close($ch);

    // Yanıtı kontrol et
    if ($response) {
        $result = json_decode($response, true);
        if (!empty($result['matches'])) {
            $errors = array();
            foreach ($result['matches'] as $match) {
                $errors[] = "Hata: " . $match['message'] . " (Konum: " . $match['offset'] . ")";
            }
            return implode("\n", $errors);
        } else {
            return "Hiçbir hata bulunamadı.";
        }
    } else {
        return "API ile iletişim kurulamadı. Lütfen daha sonra tekrar deneyin.";
    }
}
