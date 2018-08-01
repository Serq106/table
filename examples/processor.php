<?php
    $article = $_POST['article'];
    $color = $_POST['color'];
    $price = $_POST['price'];
    $price_diskont = $_POST['price-diskont'];
    $size = $_POST['size'];
    $name = $_POST['name'];
    $sizes = $_POST['sizes'];
    $art = $_POST['art'];

    require __DIR__ . '/../vendor/autoload.php';
    use ParseCsv\Csv;

    $csv = new Csv();
    $csv->auto('book.csv');

    create_title_csv($csv->titles);
    create_add_data_csv($csv->titles, $article, $color, $price, $price_diskont, $size, $name, $sizes);


    function create_title_csv($title){
        $str = '';
        foreach ($title as $value){
            $str .= $value.',';
        }
        $str = substr($str,0,-1);
        $str .= "\n";
        file_put_contents('add.csv', $str, FILE_APPEND);
        return null;
    }

    function create_article(){
        $date_today = date("m.d.y");
        $today = date("H:i:s");
        $art = preg_replace('/[^0-9]/', '', $date_today.''.$today);

        return $art;
    }


    function create_add_data_csv($csv_title, $article, $color, $price, $price_diskont, $size, $name, $sizes){
        $date_today = date("m.d.y");
        $size = str_replace(' ', '', $size);
        $today[1] = date("H:i:s"); //присвоит 1 элементу массива 18:32:17
        $csv_data = array(
            'ID' => null,
            'Тип'=> 'variation',
            'Артикул' => create_article(),
            'Имя' => $name .' - ',
            'Опубликован' => 1,
            'рекомендуемый?' => 0,
            'Видимость в каталоге' => 'visible',
            'Статус налога' => 'taxable',
            'Налоговый класс' => 'parent',
            'В наличии?' => 1,
            'Задержанный заказ возможен?' => 0,
            'Продано индивидуально?' => 0,
            'Разрешить отзывы от клиентов?' => 0,
            'Цена распродажи' => $price_diskont,
            'Базовая цена' => $price,
            'Родительский' => $article,
            'Позиция' => 0,
            'Имя атрибута 1' => 'pa_цвет',
            'Значение(-я) аттрибута(-ов) 1' => $color,
            'Видимость атрибута 1' => 0,
            'Глобальный атрибут 1' => 2,
            'Имя атрибута 2' => 'pa_размер',
            'Значение(-я) аттрибута(-ов) 2' => $size,
            'Видимость атрибута 2' => 0,
            'Глобальный атрибут 2' => 1,
        );
        $csv_data['Имя'] = '"'.$name.' - '. $color .', '. $size.'"';
        $sizese = str_replace(' ', '', $discriptions = explode(",", $sizes));
        for($i = 0; $i < count($sizese); $i++){
            if($sizese[$i] == $csv_data['Значение(-я) аттрибута(-ов) 2']){
                $csv_data['Глобальный атрибут 2'] = $i + 2;
            }
        }
        $str = '';
        foreach ($csv_title as $row){
            $str .=$csv_data[$row].',';
        }
        $str = substr($str,0,-1);
        $str .= "\n";
        file_put_contents('add.csv', $str, FILE_APPEND);
        file_put_contents('book.csv', $str, FILE_APPEND);

        return null;
    }

    function print_article($discription){
        $text_article = array('Артикул:', 'Артикул');
        $discriptions = explode(" ", $discription);
        for($i = 0; $i < count($discriptions); $i++){
            $flag = strpos($discriptions[$i], 'Артикул');
            if($flag){
                $article_ar = $discriptions[$i + 1];
                $i = count($discriptions);
            }
        }
        for($i = 0; $i < strlen($article_ar); $i++){
            if(is_numeric($article_ar[$i])){
                $article = substr($article_ar, 0, $i + 1);
            } else {
                $article = substr($article_ar, 0, $i);
                $i = strlen($article_ar);
            }
        }
        return $article;
    }
    $articleses = array(create_article(), $art, $color, $price, $price_diskont, $size);
    echo json_encode($articleses);

?>