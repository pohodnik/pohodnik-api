<?php
    if (isset($_GET['id_hiking'])) {
        $id_hiking = intval($_GET['id_hiking']);
        include("../blocks/db.php"); //подключение к БД


echo '
<html>
    <head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Погода</title>
        <style>
            body{font-family: Roboto, Arial; font-size: 12px;}
            table {width:100%; margin-bottom:1em; border-collapse: collapse;}
            table, td, th  { border: 1px solid #000000; text-align: center}
            .hourly tr>td { text-align: right; padding-right: 3px }
        </style>
    </head>
    <body>
';

        $days = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда','Четверг', 'Пятница', 'Суббота'];
        $q = $mysqli -> query("SELECT * FROM hiking_weather WHERE id_hiking = {$id_hiking} GROUP BY date");
        while ($r = $q -> fetch_assoc()) {
            extract($r);
            $forecastObj = json_decode($forecast, true);
            $temp = $forecastObj['temp'];
            $feels_like = $forecastObj['feels_like'];
            $rusDate = date('d.m.Y', $forecastObj['dt']);
            $pop = ($forecastObj['pop'] * 100);

            $t1 = date("H:i", $forecastObj['sunrise'] );
            $t2 = date("H:i", $forecastObj['sunset'] );
            $hourly = json_decode($hourly_forecast, true);;

            echo "<h2>
                {$rusDate} {$days[ date("w", $forecastObj['dt'] )]}  <small><sup>{$t1}</sup>☼<sub>{$t2}</sub></small>
                <small><a href=\"geo:{$lat},{$lon}\">{$name}</a></small>
            </h2>";

            echo "<table>";
            echo "
            <tr>
                <td rowspan=2></td><td colspan=4>Температура, °C ({$temp['min']}-{$temp['max']})</td></td>
            </tr>
            <tr>
                <td>ночь</td>
                <td>утро</td>
                <td>день</td>
                <td>вечр</td>
            </tr>
            <tr>
                <td>факт</td>
                <td>{$temp['night']}</td>
                <td>{$temp['morn']}</td>
                <td>{$temp['day']}</td>
                <td>{$temp['eve']}</td>
            </tr>
            <tr>
                <td>ощущ</td>
                <td>{$feels_like['night']}</td>
                <td>{$feels_like['morn']}</td>
                <td>{$feels_like['day']}</td>
                <td>{$feels_like['eve']}</td>
            </tr>
    ";
            echo "</table>";


            echo "<table>";
            echo "
            <tr>
                <td colspan=3>Ветер</td>
                <td colspan=2>Осадки</td>
                <td rowspan=2>Влаж</td>
                <td rowspan=2>Облач</td>
                <td>Давл</td>
            </tr>
            <tr>
                <td>скор</td>
                <td>порыв</td>
                <td>напр</td>
                <td>мм</td>
                <td>%</td>
                <td>гПа</td>
            </tr>
            <tr>
                <td>{$forecastObj['speed']}</td>
                <td>{$forecastObj['gust']}</td>
                <td>{$forecastObj['deg']}°</td>
                <td>{$forecastObj['rain']}</td>
                <td>{$pop}</td>
                <td>{$forecastObj['humidity']}%</td>
                <td>{$forecastObj['clouds']}%</td>
                <td>{$forecastObj['pressure']}</td>
            </tr>
    ";
            echo "</table>";


            if (isset($hourly) && !empty($hourly)) {

                echo '<h3>Почасовой прогноз</h3>';
                echo "<table class='hourly'>
                <tr>
                    <td></td>
                ";

                for ($i=0; $i < 12; $i++){
                    $h = $hourly[$i];
                    echo '<th width="7%">'.$h['time'].'</th>';
                }
            echo '</tr>';
                
            echo "<tr><td>🌡,°C</td>";

                for ($i=0; $i < 12; $i++){
                    $h = $hourly[$i];
                    echo '<td>'.round($h['temp']).'</td>';
                }
            echo '</tr>';

            echo "<tr><td>☂,мм</td>";

            for ($i=0; $i < 12; $i++){
                $h = $hourly[$i];
                echo '<td>'.(is_array($h['rain'])?round($h['rain']['1h'],1):0).'</td>';
            }
            echo '</tr>';

            echo "<tr><td>☂,%</td>";

            for ($i=0; $i < 12; $i++){
                $h = $hourly[$i];
                echo '<td>'.($h['pop']*100).'</td>';
            }
            echo '</tr>';

            echo "<tr><td>🚩,м/с</td>";

            for ($i=0; $i < 12; $i++){
                $h = $hourly[$i];
                echo '<td>'.round($h['wind_speed']).'</td>';
            }
            echo '</tr>';    
            
            
            echo "<tr><td>🚩,°</td>";

            for ($i=0; $i < 12; $i++){
                $h = $hourly[$i];
                echo '<td>'.($h['wind_deg']).'</td>';
            }
            echo '</tr>';

                            
            echo "<tr><td>☁,%</td>";

            for ($i=0; $i < 12; $i++){
                $h = $hourly[$i];
                echo '<td>'.($h['clouds']).'</td>';
            }
            echo '</tr>';  

            echo "
                </tr>
            </table>";

                echo "<table class='hourly'>
                    <tr>
                        <td></td>
                    ";

                    for ($i=12; $i < 24; $i++){
                        $h = $hourly[$i];
                        echo '<th  width="7%">'.$h['time'].'</th>';
                    }
                echo '</tr>';
                    
                echo "<tr><td>🌡,°C</td>";

                    for ($i=12; $i < 24; $i++){
                        $h = $hourly[$i];
                        echo '<td>'.round($h['temp']).'</td>';
                    }
                echo '</tr>';

                echo "<tr><td>☂,мм</td>";

                for ($i=12; $i < 24; $i++){
                    $h = $hourly[$i];
                    echo '<td>'.(is_array($h['rain'])?round($h['rain']['1h'],1):0).'</td>';
                }
                echo '</tr>';

                echo "<tr><td>☂,%</td>";

                for ($i=12; $i < 24; $i++){
                    $h = $hourly[$i];
                    echo '<td>'.($h['pop']*100).'</td>';
                }
                echo '</tr>';

                echo "<tr><td>🚩,м/с</td>";

                for ($i=12; $i < 24; $i++){
                    $h = $hourly[$i];
                    echo '<td>'.round($h['wind_speed']).'</td>';
                }
                echo '</tr>';    
                
                
                echo "<tr><td>🚩,°</td>";

                for ($i=12; $i < 24; $i++){
                    $h = $hourly[$i];
                    echo '<td>'.($h['wind_deg']).'</td>';
                }
                echo '</tr>';

                                
                echo "<tr><td>☁,%</td>";

                for ($i=12; $i < 24; $i++){
                    $h = $hourly[$i];
                    echo '<td>'.($h['clouds']).'</td>';
                }
                echo '</tr>';  

                echo "
                    </tr>
                </table>";

                echo '<details><summary>fc</summary><pre>';
                print_r($hourly);
                echo '</pre></details>';
            }

            


        }
    }