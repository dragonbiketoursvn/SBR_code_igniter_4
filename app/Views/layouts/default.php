<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css" integrity="sha256-O8SsQwDg1R10WnKJNyYgd9J3rlom+YSVcGbEF5RmfFk=" crossorigin="anonymous">

    <style>
    button.is-available {color: white; background-color: #1105fa;}
    button.is-available:hover {color: white; background-color: #bdbaff;}

    button {z-index: 1;}

    .table th {
        background: #20e5e8;
        color: #ffffff;
        z-index: 2;
    }

    .table.sticky th {
        position: sticky;
        top: 0;
    }

    </style>

    <title>
      <?= $this->renderSection("title") ?>
    </title>

</head>
<body>

<section>

    <?= $this->renderSection("content") ?>

</section>


</body>
</html>
