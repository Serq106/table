<?php

    $article = $_POST['article'];
    $art = $_POST['art'];
    $color = $_POST['color'];
    $price = $_POST['price'];
    $price_diskont = $_POST['price-diskont'];
    $sizes = $_POST['sizes'];

    function get_result($size){
        $sizes = str_replace(' ', '', $discriptions = explode(",", $size));
        $option = '';
        foreach ($sizes as $item){
            $option .= ("<option id='size' value='$item'> $item</option>");
        }
        return $option;
    }

    $child_edit = ('
        <tr>
            <td>'.$article.'</td>
            <td>'.$art.'</td>
            <td>'.$color.'</td>
            <td><input class="price" type="text" name="price" value="'.$price.'"></td>
            <td><input class="price-diskont" type="text" name="price" value="'.$price_diskont.'"></td>
            <td>
                <select id="child_size" name="size">
                    <option  selected="selected"> Размер</option>
                    '.get_result($sizes).'
                </select>
            </td>
            <td><button class="child_edit" id="child_save'.$article.'">Сохранить</button></td>
        </tr>
    ');

    $articleses = array($child_edit);
    echo json_encode($articleses);


?>