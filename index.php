<?php
$f_name = 'countries.txt';
$search_key = 'Россия';

function binarySearchInFile($f_name, $search_key, $route = false)
{
    if ($route) {
        $f_name = $route.'\\'.$f_name;
    } else {
        $f_name = __DIR__ .'\\'.$f_name;
    }

    try {
        $file = new SplFileObject($f_name);
        $l_board = 0;
        $file->seek($file->getSize());
        $r_board = $file->key();
        
        while (true) {
            $current_elem = floor(($l_board + $r_board) / 2);
            $file->seek($current_elem);
            list($key) = explode("\t", $file->current());

            switch (strnatcmp($search_key, $key)) {
                case -1:
                    $r_board = $current_elem - 1;
                    break;
                case 1:
                    $l_board = $current_elem + 1;
                    break;
                case 0:
                    $file->seek($current_elem);
                    list(, $val) = explode("\t", $file->current());
                
                    return $val;    
            }
    
            if ($l_board > $r_board) {
                return 'undef';
            }
        }
    } catch (Exception $e) {
        if ($e instanceof RuntimeException) {
            echo 'Ошибка открытия файла!';
        } else {
            echo "Ошибка: {$e->getMessage()}";
        }

        exit;
    }
}

$time = microtime(true);
$res = binarySearchInFile($f_name, $search_key);
$time = round(microtime(true) - $time, 3);

echo "<b>Ключ поиска</b>: $search_key<br /> <b>Результат поиска</b>: $res<br /> <b>Время поиска:</b> ".$time.' с.';