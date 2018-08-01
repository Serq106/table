<!DOCTYPE html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css"/>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" type="text/css"/>

<?php
    function get_color($color){
        foreach ($color as $item){
            print("<option id='color' value='$item'> $item</option>");
        }
        return null;
    }

    function get_size($size){
        foreach ($size as $item){
            print("<option id='size' value='$item'> $item</option>");
        }
        return null;
    }

    function get_kategory($kategory){
        foreach ($kategory as $item){
            print("<option id='kat' value='$item'> $item</option>");
        }
        return null;
    }

    function get_result($size){
        $sizes = str_replace(' ', '', $discriptions = explode(",", $size));
        foreach ($sizes as $item){
            print("<option id='size' value='$item'> $item</option>");
        }
        return null;
    }

?>
<?php

    require __DIR__ . '/../vendor/autoload.php';
    require_once 'pars-table.php';
    require_once 'create_csv.php';
    use ParseCsv\Csv;

    $csv = new Csv();
    $csv->auto('book.csv');
    $csv->encoding('UTF-8');
    $d = count($csv->data);
    $data = print_parent($csv);

    $sizes = array('39', '40', '40.5', '41', '41.5', '42', '42.5', '43', '43.5', '44',
        '45', '46', '48', '50', '52', '54', '56', '58', '60', '62');

    $colors = array('Коричневый', 'Черный');

    $kategory =  array('Брюки', 'Галстуки', 'Джемпера', 'Костюмы', 'Куртки', 'Обувь', 'Пальто', 'Перчатки',
        'Пиджаки', 'Платочки', 'Портмоне', 'Ремни', 'Рубашки', 'Сумки', 'Шарфы');

    $exception = array('ID', 'Категория', 'Бренд', 'Наименование', 'Артикул',  'Цвет',
        'Цена', 'Цена со скидкой', 'Размер','Количество','Описание', 'Фото');

    $dom = array('ID', 'Артикул', 'Цвет', 'Цена', 'Цена со скидкой', 'Размер');

?>

<link href="../css/style.css" rel="stylesheet" media="all">

    <!--BEGIN Формирование загаловка файла-->
        <?php create_title_csv($csv->titles);?>
    <!--END-->

<div class="rTable">

    <!--BEGIN Вывод заголовка таблицы-->
    <div class="rTableRow">
        <?php foreach ($exception as $value): ?>
            <div class="rTableHead">
                <?php echo $value; ?>
            </div>
        <?php endforeach; ?>

    </div>
    <!--END-->
    <div class="rTableRow" id="add_perent">
        <div class="rTableCell"><input type="submit" id="parent" class='btne_parent' value="+"></div>
        <div class="rTableCell" id="kat">
            <select id="example-getting-started-kategory" class="kategory" name="kategory" multiple="multiple">
                <option  selected='selected'> Категория</option>
                <?php get_kategory($kategory);?>
            </select>
        </div>
        <div class="rTableCell"><input class="brand"  type="text" name="brand" placeholder="Бренд"></div>
        <div class="rTableCell"><input class="name" type='text' name="name" placeholder="Наименование"/></div>
        <div class="rTableCell"></div>
        <div class="rTableCell">
            <select id="color" name="color">
                <option  selected='selected'> Цвет</option>
                <?php get_color($colors);?>
            </select>
        </div>
        <div class="rTableCell"><input class="name" type='text' name="name" placeholder="Цена"/></div>
        <div class="rTableCell"><input class="name" type='text' name="name" placeholder="Цена со скидкой"/></div>
        <div class="rTableCell" id="size"><div class="selected"></div>
            <select id="example-getting-started-size" class="size" multiple="multiple">
                <?php get_size($sizes);?>
            </select>
        </div>
        <div class="rTableCell"><input class="count" type='text' name="count" placeholder="Количество"/></div>
        <div class="rTableCell"><input class="discription" type='text' name="discription" placeholder="Описание"/></div>
        <div class="rTableCell">
            <form action="upload.php" method="post" target="hiddenframe" enctype="multipart/form-data" onsubmit="hideBtn();">
                <input class="photo" type="file" id="userfile" name="userfile" />
                <input type="submit" name="upload" id="upload" value="Загрузить" />
            </form>
        </div>
    </div>
    <!--BEGIN Вывод всех данных таблицы-->
    <?php foreach ($data as  $rows): ?>
        <?php $class_tovar = 'item'.$rows['ID']?>
        <?php $color = $rows['Цвет'] ?>
        <?php $size = $rows['Размер'] ?>
        <?php $article = $rows['Артикул'] ?>
        <?php $ID = $rows['ID'] ?>
        <?php $name = $rows['Бренд']; ?>
        <!--BEGIN Вывод родителей-->

        <?php print('<div class="rTableRow" id='.$class_tovar.'>') ?>

            <?php for($i = 0; $i < count($exception); $i++): ?>
                <div class="rTableCell">
                    <?php
                        if($exception[$i] == 'Фото'){
                            $results = explode(",", $rows[$exception[$i]]);
                            foreach ($results as $result )
                                print('<img src='.$result.' ><div><button class="edit">edit</button></div>');
                        } else {
                            echo $rows[$exception[$i]];
                        }
                    ?>
                </div>
            <?php endfor; ?>
        </div>
        <!--END-->
        <?php create_header_csv($rows, $csv->titles)?>
        <!--BEGIN Вывод дочерних элементов-->

        <?php $data_child = print_child($csv,  $rows['ID'], $article) ?>
        <?php if($data_child != null): ?>
            <?php print('<div class="children-table" id='.'child_'.$class_tovar.'>') ?>
                <table border="0" cellspacing="1" cellpadding="3">
                    <tr>
                        <?php foreach ($dom as $value): ?>
                            <th><?php echo $value; ?></th>
                        <?php endforeach; ?>
                        <th>Редактировать</th>
                    </tr>
                    <?php foreach ($data_child as $rows_child): ?>
                        <tr>
                            <?php for($j = 0; $j < count($dom); $j++):?>
                                <td> <?php echo  $rows_child[$dom[$j]]?></td>
                            <?php endfor; ?>
                            <td><button class="child_edit" id="child_edit<?php echo $rows_child['ID']?>">Редактировать</button></td>

                        </tr>
                        <?php create_child_csv($rows_child, $csv->titles, $rows['Бренд'], $rows['ID'], $rows['Размер']) ?>
                    <?php endforeach;?>

                    <tr>
                        <td><input type="submit" id="child_<?php echo $class_tovar?>" class='btne' value="+"></td>
                        <input id="child_<?php echo $class_tovar?>" class="child_name" type='hidden' name="name" value=<?php print($name);?>>
                        <input id="child_<?php echo $class_tovar?>" class="sizes" type='hidden' name="sizes" value="<?php echo($size);?>">
                        <input id="child_<?php echo $class_tovar?>" class="art" type='hidden' name="art" value="<?php print($article);?>">
                        <td><input id="child_<?php echo $class_tovar?>" class="article" type='hidden' name="article" value=<?php print($ID);?>><?php print($article);?></td>
                        <td><input id="child_<?php echo $class_tovar?>" class="color"  type="hidden" name="colot" value=<?php print ($color); ?>><?php print ($color); ?></td>
                        <td><input id="child_<?php echo $class_tovar?>" class="price" type='text' name="price" placeholder="Цена"/></td>
                        <td><input id="child_<?php echo $class_tovar?>" class="price-diskont" type='text' name="price-diskont" placeholder="Цена распродажи"/></td>
                        <td>
                            <select id="child_size" name="size">
                                <option  selected='selected'> Размер</option>
                                <?php get_result($size);?>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
         <?endif;?>
        <!--END-->

    <?php endforeach; ?>
    <!--END-->

</div>
<script src="../js/script.js"></script>