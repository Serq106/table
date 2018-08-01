<?php
$kategory = $_POST['kategory'];
$brand = $_POST['brand'];
$name = $_POST['name'];
$color = $_POST['color'];
$size = $_POST['size'];
$count = $_POST['count'];
$discription = $_POST['discription'];
$photo = $_POST['photo'];

require __DIR__ . '/../vendor/autoload.php';
use ParseCsv\Csv;

$csv = new Csv();
$csv->auto('book.csv');

$dom = array('ID', 'Артикул', 'Цвет', 'Цена', 'Цена со скидкой', 'Размер');

create_title_csv($csv->titles);
$article = create_article();
create_add_data_csv($csv->titles, $article, $kategory, $brand, $name, $color, $size, $count, $discription, $photo);

function create_title_csv($title){
    $str = '';
    foreach ($title as $value){
        $str .= $value.',';
    }
    $str = substr($str,0,-1);
    $str .= "\n";
    file_put_contents('add.csv', $str);
    return null;
}

function create_article(){
    $date_today = date("m.d.y");
    $today = date("H:i:s");
    $art = preg_replace('/[^0-9]/', '', $date_today.''.$today);

    return $art;
}

function get_result($size){
    $sizes = str_replace(' ', '', $discriptions = explode(",", $size));
    $option = '';
    foreach ($sizes as $item){
        $option .= ("<option id='size' value='$item'> $item</option>");
    }
    return $option;
}

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

function create_add_data_csv($csv_title, $article, $kategory, $brand, $name, $color, $size, $count, $discription, $photo){
    $date_today = date("m.d.y");
    $size = str_replace(' ', '', $size);
    $today[1] = date("H:i:s"); //присвоит 1 элементу массива 18:32:17
    $csv_data = array(
        'ID' => null,
        'Тип'=> 'variable',
        'Артикул' =>  $article,
        'Имя' => $brand,
        'Мета: _custom_name' => $name,
        'Опубликован' => 1,
        'рекомендуемый?' => 0,
        'Видимость в каталоге' => 'visible',
        'Описание' => '"'.$discription.'"' ,
        'Статус налога' => 'taxable',
        'В наличии?' => 1,
        'Запасы' => $count,
        'Задержанный заказ возможен?' => 0,
        'Продано индивидуально?' => 0,
        'Разрешить отзывы от клиентов?' => 0,
        'Категории' => $kategory,
        'Позиция' => 0,
        'Имя атрибута 1' => 'Цвет',
        'Значение(-я) аттрибута(-ов) 1' =>'"'.$color.'"',
        'Видимость атрибута 1' => 0,
        'Глобальный атрибут 1' => 1,
        'Имя атрибута 2' => 'Размер',
        'Значение(-я) аттрибута(-ов) 2' => '"'.$size .'"',
        'Видимость атрибута 2' => 0,
        'Глобальный атрибут 2' => 1,
    );
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
foreach ($dom as $value) {
    $child_title .= '<th>' . $value . '</th>';
}
$child_id = 'child_item' . $article;


$shild = ('
            <div class="children-table" id='.$child_id.'>
                <table border="0" cellspacing="1" cellpadding="3">
                    <tr>'. $child_title .'</tr>
                    <tr>
                        <td><input type="submit" id="'.$child_id.'" class="btne" value="+"></td>
                        <input id="'.$child_id.'" class="child_name" type="hidden" name="name" value="'.$brand.'">
                        <input id="'.$child_id.'" class="sizes" type="hidden" name="sizes" value="'.$size.'">
                        <input id="'.$child_id.'" class="art" type="hidden" name="art" value="'.print_article($discription).'">
                        <td><input id="'.$child_id.'" class="article" type="hidden" name="article" value="'.$article.'">'.print_article($discription).'</td>
                        <td><input id="'.$child_id.'" class="color"  type="hidden" name="colot" value="'.$color.'">'.$color.'</td>
                        <td><input id="'.$child_id.'" class="price" type="text" name="price" placeholder="Цена"/></td>
                        <td><input id="'.$child_id.'" class="price-diskont" type="text" name="price-diskont" placeholder="Цена распродажи"/></td>
                        <td>
                            <select id="child_size" name="size">
                                <option  selected="selected"> Размер</option>
                                '.get_result($size).'
                            </select>
                        </td>
                    </tr>
                </table>
            </div>');


$articleses = array($article, $kategory, $brand, $name, print_article($discription), $color, $size, $count, $discription, 'dsd', $shild);
echo json_encode($articleses);

?>

