<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css" integrity="sha256-O8SsQwDg1R10WnKJNyYgd9J3rlom+YSVcGbEF5RmfFk=" crossorigin="anonymous">

    <title><?= $this->renderSection("title") ?></title>

</head>
<body>

<section>

    <?= $this->renderSection("content") ?>

</section>


</body>
</html>
