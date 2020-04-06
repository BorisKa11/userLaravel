(function(js, $, undefined) {
    "use strict";
    js.store = js.store || {
        url: 'api/contacts'
    };
    js.help = js.help || {
        setMask: function(o) {
            o.attr('placeholder','+7 (123) 456-78-90').mask('+7 (999) 999-99-99');
        },
        render: function(res) {
            var a = [];
            a.push('<table class="table table-stripped">');
            a.push('<tr><th>Имя</th><th>email</th><th>Телефон</th><th>source_id</th></tr>');
            for(var i in res) {
                a.push('<tr>');
               a.push('<td>');
                a.push(res[i].name);
                a.push('</td>');
                a.push('<td>');
                a.push(res[i].email);
                a.push('</td>');
                a.push('<td>');
                a.push(res[i].phone);
                a.push('</td>');
                a.push('<td>');
                a.push(res[i].source_id);
                a.push('</td>');                
                a.push('</tr>');
            }
            a.push('</table>');
            return a.join('');
        },
        addLine: function() {
            var a = [], rand = Math.round(Math.random() * 1000);
            a.push('<div class="newLine row position-ref" id="line'+rand+'">');
            a.push('<div class="col-xs-12 col-md-4 lineDiv">');
            a.push('<label for="name'+rand+'" >Имя</label>');
            a.push('<input type="text" class="form-control" id="name'+rand+'" name="name" placeholder="введите имя" />');
            a.push('</div><div class="col-xs-12 col-md-4 lineDiv">');
            a.push('<label for="email'+rand+'" >Email</label>');
            a.push('<input type="email" class="form-control" id="email'+rand+'" name="email" placeholder="введите email" />');
            a.push('</div><div class="col-xs-12 col-md-4 lineDiv">');
            a.push('<label for="phone'+rand+'" >Телефон</label>');
            a.push('<input type="text" class="form-control" id="phone'+rand+'" name="phone" placeholder="введите телефон" />');
            a.push('</div>');
            a.push('<a class="removeLine" data-id="'+rand+'"><i data-toggle="tooltip" title="удалить" class="glyphicon glyphicon-remove text-danger"></i></a>');
            a.push('</div>');
            $(a.join('')).appendTo($('#lines'));
            js.help.setMask($('#phone'+rand));
            $('#line'+rand+' .removeLine:first').find('i:first').tooltip();
        },
        removeLine: function(id) {
            var size = $('.newLine').length;
            
            $('#lines .error').stop().remove();
            if (size == 1) {
                $('#lines').prepend($('<div class="error">Нельзя удалить единственную строку</div>'));
                $('#lines .error').delay(2500).slideUp(150, function() {
                    $(this).remove();
                });
                return ;
            }
            if (!confirm('Точно удалить данные выбранную строку?')) {return ; }
            console.log($('#line'+id).length);
            $('#line'+id).slideUp(150, function() {
                $(this).remove();
            });
        }
    };
    js.controller = js.controller || {
        search: function() {
            $.ajax({
                type: "POST",
                url: js.store.url+"/search",
                dataType: 'JSON',
                data: $('#searchForm').serialize(),
                success: function(data) {
                    if(data.status === 0) {
                        var a = [];
                        for(var i in data.errors.search) {
                            a.push('<div class="error">');
                            a.push(data.errors.search[i]);
                            a.push('</div>');
                        }
                        $('#searchResults').html(a.join(''));
                    } else {
                        $('#searchResults').html(js.help.render(data.result));
                    }
                }
            });
        },
        add: function() {
            $('.newLine .lineDiv').removeClass('has-error');
            var items = [];
            $('.newLine').each(function() {
                items.push({
                    name: $(this).find('input[name="name"]:first').val(),
                    email: $(this).find('input[name="email"]:first').val(),
                    phone: $(this).find('input[name="phone"]:first').val()
                });
            });
            $('#errorAdd').stop().html('');
            $.ajax({
                type: "POST",
                url: js.store.url+"/add",
                dataType: 'JSON',
                data: {source_id: $('input[name="source"]:checked').val(), items: items},
                success: function(data) {
                    if(data.status === 0) {
                        var err = data.errors;
                        if (data.errors instanceof Object) {
                            for(var i in data.errors) {
                                var split = i.split('.');
                                var field = split[2];
                                var eq = split[1];
                                if (field == 'name')
                                    $('.newLine').eq(eq).find('.lineDiv').eq(0).addClass('has-error');
                                if (field == 'email')
                                    $('.newLine').eq(eq).find('.lineDiv').eq(1).addClass('has-error');
                                if (field == 'phone')
                                    $('.newLine').eq(eq).find('.lineDiv').eq(2).addClass('has-error');
                            }
                        } else {
                            $('#errorAdd').html('<div class="error">' + data.errors + '</div>').slideDown(150, function() {
                                $(this).delay(2500).slideUp(150);
                            });
                        }
                    } else {
                        var a = [];
                        for(var i in data.success) {
                            a.push('<div class="success">' + data.success[i] + '</div>');
                        }
                        $('#errorAdd').html(a.join('')).slideDown(150, function() {
                            $(this).delay(2500).slideUp(150);
                        });
                        $('#addForm')[0].reset();
                    }
                }
            });
        }
    };
    js.view = js.view || {
        init: function() {
            $('body').on('submit', '.form', function(e) {
                e.preventDefault();
                if ($(this).data('action') === 'search')
                    js.controller.search();
                else
                    js.controller.add();
            });
            $('body').on('click', '.removeLine', function(e) {
                e.preventDefault();
                js.help.removeLine($(this).data('id'));
            });
            $('.addClient:first').on('click', function() {
                js.help.addLine();
                $(this).blur();
            });
            $('.js-masked-phone').each(function() {
                js.help.setMask($(this));
            });
            js.help.addLine();
            
        }
    };
    $(document).ready(function() {
        js.view.init();
    });
})(window.js = window.js || {}, jQuery);
