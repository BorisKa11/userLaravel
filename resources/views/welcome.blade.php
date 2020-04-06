<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="//fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="//stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: Verdana, sans-serif;
                font-weight: 100;
                margin: 0;
            }

            .position-ref {
                position: relative;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            
            .form {padding: 20px 40px;}
        </style>
    </head>
    <body>
            <div class="content">
                <div class="row">
                    <div class="col-xs-12 col-md-6 left">
                        <form action="/add/contact" method="post" class="form" id="addForm">
                            <h2>Добавить клиента</h2>
                            <div class="form-group">
                                <input type="radio" id="source1" checked name="source" value="1" />
                                <label for="source1">source #1</label>
                                <input type="radio" id="source2" name="source" value="2" />
                                <label for="source2">source #2</label>
                                <button type="button" class="addClient pull-right btn btn-link"><i class="glyphicon glyphicon-plus"></i> добавить клиента</button>
                            </div>
                            <div id="errorAdd"></div>
                            <div id="lines"></div>
                            <button class="pull-right btn btn-primary" type="submit"><i class="glyphicon glyphicon-floppy-save"></i> Сохранить</button>
                        </form>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <form action="/add/contact" method="post" class="form form-inline" data-action="search" id="searchForm">
                            <h2>Поиск клиентов</h2>
                            <div class="form-group">
                                <label for="search">Найти</label>
                                <input type="text" class="form-control" id="search" name="search" placeholder="введите имя, телефон, emeail">
                            </div>
                            <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i> Поиск</button>
                        </form>
                        <div id="searchResults"></div>
                    </div>
                </div>
            </div>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script type="text/javascript" src="//stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
        <script type="text/javascript" src="/js/js.js?{{ time() }}"></script>
        <style type="text/css">
            .error {margin: 10px 20px;color: red;}
            label {margin-right: 10px;}
            .newLine {font-size: 0.9em;margin-bottom: 10px;}
            .removeLine {position: absolute;top: 0px;right: 5px;padding: 4px;cursor: pointer;}
            #errorAdd {display: none;}
            .success {margin: 10px 20px;color: green;}
        </style>
    </body>
</html>
