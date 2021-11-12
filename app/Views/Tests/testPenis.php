<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Penis</title>
</head>

<body>
    <table style="border: 2px black solid;">
        <tr>
            <?php foreach ($fieldData as $field) : ?>
                <th style="border: 2px black solid;" class="<?= $field->type_name ?>"><?= strtoupper(str_replace('_', ' ', $field->name)) ?></th>
            <?php endforeach; ?>
        </tr>
    </table>
</body>

</html>