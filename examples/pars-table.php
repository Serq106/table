<?php

    /*Формирование данных для вывода дочерних элементов*/
    function print_child($csv, $id_parent, $article){
        $i = 0;
        foreach ($csv->data as $key => $row){
            if($row['Родительский'] ==  $id_parent){
                $data[$i] = array(
                    "ID" => $row['Артикул'],
                    "Артикул" => $article,
                    "Цвет" => print_attr($row, 'pa_цвет'),
                    "Цена" => $row['Базовая цена'],
                    "Цена со скидкой" => $row['Цена распродажи'],
                    "Размер" => print_attr($row, 'pa_размер'),
                );
            }
            $i++;
        }
        return $data;
    }

    /*Формирование данных для вывода родительского элемента*/
    function print_parent($csv){
        $i = 0;
        foreach ($csv->data as $key => $row){
            if($row['Родительский'] == null){
                $data[$i] = array(
                    "ID" => $row['Артикул'],
                    "Категория" => $row['Категории'],
                    "Бренд" => $row['Имя'],
                    "Наименование" => $row['Мета: _custom_name'],
                    "Артикул" => print_article($row['Описание']),
                    "Цвет" => print_attr($row, 'Цвет'),
                    "Цена" => print_child_price($csv, $row['Артикул'], 'Базовая цена'),
                    "Цена со скидкой" => print_child_price($csv, $row['Артикул'], 'Цена распродажи'),
                    "Размер" => print_attr($row, 'Размер'),
                    "Количество" => $row['Запасы'],
                    "Описание" => $row['Описание'],
                    "Фото" => $row['Изображения']
                );
                $i++;
            }
        }
        return $data;
    }

    /*определение в какой калонке находиться какой атрибут*/
    function print_attr($row, $text_attr){
        if($row['Имя атрибута 2'] == $text_attr){
            $name = 'Значение(-я) аттрибута(-ов) 2';
        } else if($row['Имя атрибута 1'] == $text_attr){
            $name = 'Значение(-я) аттрибута(-ов) 1';
        }
        return $row[$name];
    }

    /*Из поле "Описание" извлекаем "Артикул"*/
    function print_article($discription){
        $text_article = array('Артикул:', 'Артикул');
        $discriptions = explode(" ", $discription);
        for($i = 0; $i < count($discriptions); $i++){
            $flag = strpos($discriptions[$i], 'Артикул');
            if($flag || $discriptions[$i] == 'Артикул' || $discriptions[$i] == 'Артикул:'){
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

    /*Формирвоание массива цен*/
    function print_child_price($csv, $id_tovar, $name){
        $prices = array();
        foreach ($csv->data as $key => $row){
            if ($id_tovar == $row['Родительский']){
                array_push($prices, $row[$name]);
            }
        }
        return print_min_max($prices);
    }

    /*Для родительского элемента формирование формата вывода*/
    function print_min_max($prices){
        if($prices != null){
            $min  = min($prices);
            $max  = max($prices);
            $min_max = $min . ' - ' . $max;
            return $min_max;
        } else
            return null;

    }

?>