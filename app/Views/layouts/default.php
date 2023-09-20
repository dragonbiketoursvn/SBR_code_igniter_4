<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css" integrity="sha256-O8SsQwDg1R10WnKJNyYgd9J3rlom+YSVcGbEF5RmfFk=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        button.is-available {
            color: white;
            background-color: #1105fa;
        }

        button.is-available:hover {
            color: white;
            background-color: #bdbaff;
        }

        button {
            z-index: 1;
        }

        .table th {
            background: #20e5e8;
            color: #ffffff;
            z-index: 2;
        }

        .table.sticky th {
            position: sticky;
            top: 0;
        }

        .photos {
            width: 30%;
            height: auto;
        }

        .photoCaption {
            width: 100%;
            background: yellow;
            text-align: center;
        }

        .hidden {
            display: none !important;
        }

        .photoSection {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin: 15px;
            background-color: #dddddd;
        }

        .deleteButton,
        .selectButton,
        .deselectButton {
            cursor: default;
            background: yellow;
            text-align: center;
            position: absolute;
            bottom: 0%;
            width: 100%;
        }

        .photoBox {
            width: 350px;
            height: 225px;
            overflow: hidden;
            position: relative;
            border: 1px solid #333333;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            background-color: #ffffff;
            margin: 5px;
        }

        .photoCaption {
            position: absolute;
            top: 0%;
        }

        .photoImage {
            flex-grow: 1;
            object-fit: cover;
        }

        .selectPhoto {
            border: 1px solid grey;
            padding: 5px;
            border-radius: 20px;
            cursor: default;
        }

        input[type="file"] {
            height: 0px;
            padding: 0px;
            opacity: 0px;
            display: none;
        }

        .mailForm {
            display: flex;
            flex-direction: column;
            max-width: 600px;
            padding: 5px;
            background-color: #999999;
            position: fixed;
            bottom: 5px;
        }

        .mailForm .customerSelect {
            width: 100%;
            display: flex;
            justify-content: left;
            margin: 5px;
        }

        .mailForm .messageBox {
            width: 98%;
            margin-top: 5px;
        }

        .mailForm label {
            margin-right: 20px;
        }

        .mailForm input {
            width: 98%;
        }

        .mailForm .buttons {
            display: flex;
            justify-content: space-between;
        }

        .mailForm button {
            flex-grow: 1;
            margin: 5px;
            padding: 2px;
        }

        .mailForm #sendButton {
            background-color: green;
            color: #dddddd;
        }

        .mailForm #mailCancelButton {
            background-color: red;
            color: #dddddd;
        }

        #filterBar {
            position: fixed;
            top: 5px;
            left: 15px;
            z-index: 1;
        }

        #filterBarSpacer {
            width: 100%;
            height: 20px;
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
    <script src="<?= site_url('js/Forms/sanitization.js') ?>"></script>

</body>

</html>