
$("input, textarea, select").prop('disabled', true);

$(window).on('load', function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var idOfEmployee = window.location.href.substr(window.location.href.lastIndexOf('/') + 1);

    $.ajax({
        'url': `${idOfEmployee}/getData`,
        'type': 'POST',
        'data': '',
        'success': function (data) {
            for (let key in data) {
                for (let i = 0; i < data[key].length; i++) {
                    for (let attribute in data[key][i]) {
                        $(`.${key} .popUp`).eq(i).find(`form`).eq(1).find(`[name=${attribute}]`).val(data[key][i][attribute]).prop('title', data[key][i][attribute]);
                    }
                }
            }


        },
        'error': function (data) {
            console.log(data);
        }
    });
});

// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher('ff8fb4da7c75accfef74', {
    cluster: 'eu'
});

var channel = pusher.subscribe('channel-WatchingEmployee');
channel.bind('WatchingEmployee', function (data) {
    let sheet_name = data.sheet_name;
    let sheet_item = data.sheet_item;
    let attribute = data.attribute;
    let value = data.value;

    for (let i = 0; i < attribute.length; i++) {
        $(`.${sheet_name} .popUp`).eq(sheet_item - 1).find(`form`).eq(1).find(`[name=${attribute[i]}]`).val((value[i] == null) ? '' : value[i]);
    }

});







