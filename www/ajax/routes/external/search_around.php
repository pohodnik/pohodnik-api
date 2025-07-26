<?php
// overpass_search.php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
header('Content-Type: application/json');

// Параметры запроса
$lat = isset($_GET['lat']) ? floatval($_GET['lat']) : null;
$lon = isset($_GET['lon']) ? floatval($_GET['lon']) : null;
$radius = isset($_GET['radius']) ? intval($_GET['radius']) : 1000; // в метрах

// Валидация входных данных
if (!$lat || !$lon) {
    http_response_code(400);
    echo json_encode(['error' => 'Не указаны координаты']);
    exit;
}

// Функция для получения POI через Overpass API
function getPOIFromOverpass($lat, $lon, $radius) {
    $url = "https://overpass-api.de/api/interpreter";
    
    // Формируем запрос для поиска точек интереса
    $query = "[out:json];
    (
        node(around:{$radius},{$lat},{$lon})[tourism];        // Туристические объекты
        node(around:{$radius},{$lat},{$lon})[historic];       // Исторические места
        node(around:{$radius},{$lat},{$lon})[leisure];        // Места отдыха
        node(around:{$radius},{$lat},{$lon})[natural];        // Природные объекты
        node(around:{$radius},{$lat},{$lon})[amenity=museum]; // Музеи
        node(around:{$radius},{$lat},{$lon})[amenity=theatre];// Театры
    );
    out center;";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "data=" . urlencode($query));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "MyApp/1.0");
    
    $response = curl_exec($ch);
    
    if(curl_errno($ch)) {
        return ['error' => curl_error($ch)];
    }
    
    curl_close($ch);
    
    return json_decode($response, true);
}

try {
    // Получаем данные
    $pois = getPOIFromOverpass($lat, $lon, $radius);
    
    // Обрабатываем ответ
    if(isset($pois['elements']) && count($pois['elements']) > 0) {
        // Форматируем результат в удобный вид
        $result = [];
        foreach($pois['elements'] as $element) {
            $result[] = [
                'id' => $element['id'],
                'type' => $element['type'],
                'lat' => $element['lat'],
                'lon' => $element['lon'],
                'name' => !empty($element['tags']['name']) ? $element['tags']['name'] : $element['tags']['natural'],
                'tags' => $element['tags'],
            ];
        }
        echo json_encode($result, JSON_PRETTY_PRINT);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Объекты не найдены']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Ошибка при получении данных: ' . $e->getMessage()]);
}
