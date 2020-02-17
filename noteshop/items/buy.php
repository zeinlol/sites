<meta charset="utf-8">
<?php
$item = $_POST['itemname'];
$name = $_POST['name'];
$email = $_POST['email'];
$tel = $_POST['phone'];
$text = $_POST['text'];
echo "Спасибо,".$name.". Мы скоро свяжемся с вами :)";
mail("zeintopchanel@gmail.com", "Заказ", "Продукт:.$item\n"."Имя:.$name\n"."Почта:.$email\n"."Телефон:.$tel\n"."Сообщение:.$text\n")
?> 
