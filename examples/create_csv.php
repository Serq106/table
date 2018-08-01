<?php


    /*Создание CVS Файла*/
    function create_title_csv($data){
        $str = '';
        foreach ($data as $value){
            $str .= $value.',';
        }
        $str = substr($str,0,-1);
        $str .= "\n";
        file_put_contents('my_csv_file.csv', $str);
        return null;
    }

    function create_header_csv($data, $title){
        $str = '';
        $csv_data = array(
            'ID' => null,
            'Тип'=> 'variable',
            'Артикул' => $data['ID'],
            'Имя' => $data['Бренд'],
            'Опубликован' => 1,
            'рекомендуемый?' => 0,
            'Видимость в каталоге' => 'visible',
            'Описание' => '"'.$data['Описание'].'"' ,
            'Статус налога' => 'taxable',
            'В наличии?' => 1,
            'Запасы' => $data['Количество'],
            'Задержанный заказ возможен?' => 0,
            'Продано индивидуально?' => 0,
            'Разрешить отзывы от клиентов?' => 0,
            'Категории' => $data['Категория'],
            'Позиция' => 0,
            'Имя атрибута 1' => 'Цвет',
            'Значение(-я) аттрибута(-ов) 1' => $data['Цвет'],
            'Видимость атрибута 1' => 0,
            'Глобальный атрибут 1' => 1,
            'Имя атрибута 2' => 'Размер',
            'Значение(-я) аттрибута(-ов) 2' => $data['Размер'],
            'Видимость атрибута 2' => 0,
            'Глобальный атрибут 2' => 1,

        );
        foreach ($title as $row){
            if($row == 'Значение(-я) аттрибута(-ов) 2'){
                $str .= '"'.$csv_data[$row].'"'.',';
            } else
                $str .=$csv_data[$row].',';
        }
        $str = substr($str,0,-1);
        $str .= "\n";
        file_put_contents('my_csv_file.csv', $str, FILE_APPEND);

        return null;
    }

    function create_child_csv($data, $title, $name, $article, $size){
        $str = '';
        $sizes = str_replace(' ', '', $discriptions = explode(",", $size));
        $csv_data = array(
            'ID' => null,
            'Тип'=> 'variation',
            'Артикул' => $data['ID'],
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
            'Цена распродажи' => $data['Цена со скидкой'],
            'Базовая цена' => $data['Цена'],
            'Родительский' => $article,
            'Позиция' => 0,
            'Имя атрибута 1' => 'pa_цвет',
            'Значение(-я) аттрибута(-ов) 1' => $data['Цвет'],
            'Видимость атрибута 1' => 0,
            'Глобальный атрибут 1' => 2,
            'Имя атрибута 2' => 'pa_размер',
            'Значение(-я) аттрибута(-ов) 2' => $data['Размер'],
            'Видимость атрибута 2' => 0,
            'Глобальный атрибут 2' => 1,
        );

        $csv_data['Имя'] = '"'.$name.' - '. $data['Цвет'] .', '. $data['Размер'].'"';

        for($i = 0; $i < count($sizes); $i++){
            if($sizes[$i] == $csv_data['Значение(-я) аттрибута(-ов) 2']){
                $csv_data['Глобальный атрибут 2'] = $i + 2;
            }
        }

        foreach ($title as $row){
           $str .=$csv_data[$row].',';
        }
        $str = substr($str,0,-1);
        $str .= "\n";
        file_put_contents('my_csv_file.csv', $str, FILE_APPEND);

        return null;
    }

?>