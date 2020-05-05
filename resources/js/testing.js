let tabs = $('#pills-tab').children();

$('#previous').on('click', function(){
    for (let i = 0; i < tabs.length; i++) {
        if ($(tabs[i]).hasClass('active')) {
            $(tabs[i - 1]).tab('show');
            break;
        }
    }
});

$('#next').on('click', function(){
    for (let i = 0; i < tabs.length; i++) {
        if ($(tabs[i]).hasClass('active')) {
            $(tabs[i + 1]).tab('show');
            break;
        }
    }
});

$('form').on('submit', function(){
    return confirm('Завершити тестування?');
});