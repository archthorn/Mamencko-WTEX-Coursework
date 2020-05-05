function add(identifier) {
    if($('#question-new').length){
        $('#warning').html(`<div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
                                Збережіть попереднє запитання перш ніж створити нове!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>`);
        return;
    }

    let token = $('meta[name="csrf-token"]').attr('content');
    let route = $(identifier).data('route');
    let str = `<div class="tab-pane fade" id="question-new" role="tabpanel">
                    <form method="POST" action="${route}">
                        <input type="hidden" name="_token" value="${token}">
                        <div class="form-group">
                            <label for="text-new">Текст запитання:</label>
                            <textarea class="form-control" name="text" id="text-new" rows="3"></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-6 col-md-7 col-lg-8">
                                <label for="type-new">Тип запитання:</label>
                                <select class="form-control" name="type" id="type-new" data-id="new" onchange="typeSelect(this)">
                                    <option value="oneAnswer">Одна правельна відповідь</option>
                                    <option value="fewAnswers">Декілька правельних відповідей</option>
                                    <option value="writeAnswer">Записати відповідь</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6 col-md-5 col-lg-4">
                                <label for="answersCount-new">Кількість відповідей:</label>
                                <select class="form-control" id="answersCount-new" data-id="new" onchange="answersSelect(this)">
                                    <option>...</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                </select>
                            </div>
                        </div>
                        <div id="answers-block-new"> </div>
                        <button type="submit" class="btn btn-outline-primary">Зберегти</button>
                        <button type="button" class="btn btn-danger" data-id="new" onclick="removeQuestion(this)"">Видалити запитання</button>
                    </form>
                </div>`;
    $('#v-pills-tab').append(`<a class="nav-link" id="question-tab-new" data-toggle="pill" href="#question-new" role="tab">Нове питання</a>`);
    $('#v-pills-tabContent').append(str);
    $(`#question-tab-new`).tab('show');
}

function removeQuestion(identifier) {
    let id = $(identifier).data('id');
    $(`#question-tab-${id}`).remove();
    $(`#question-${id}`).remove();
}

function typeSelect(identifier) {
    let id = $(identifier).data('id');
    if($(`#type-${id}`).val() == 'writeAnswer'){
        $(`#answersCount-${id}`).prop('disabled', true);
        $(`#answers-block-${id}`).empty();
        $(`#answers-block-${id}`).append(`<div class="form-group"><label for="answer-1">Текст відповіді:</label> <input type="text" class="form-control" id="answer-1" name="answers[]" placeholder="Введіть відповідь"> </div>`);
    }
    else{
        $(`#answersCount-${id}`).prop('disabled', false);
        answersSelect(identifier);
    }
}

function answersSelect(identifier) {
    let id = $(identifier).data('id');
    $(`#answers-block-${id}`).empty();
    for (let i = 0; i < $(`#answersCount-${id}`).val(); i++) {
        if($(`#type-${id}`).val() == 'oneAnswer'){
            let radio = `<div class="input-group-append"> <div class="input-group-text"> <input type="radio" name="right-answers[]" value="${i}"> </div> </div>`
            $(`#answers-block-${id}`).append(`<div class="form-group"><label for="answer-${i}">Текст відповіді №${i+1}:</label> <div class="input-group"> <input type="text" class="form-control" id="answer-${i}" name="answers[]" placeholder="Введіть відповідь"> ${radio} </div></div>`);
        }
        else if($(`#type-${id}`).val() == 'fewAnswers'){
            let checkbox = `<div class="input-group-append"> <div class="input-group-text"> <input type="checkbox" name="right-answers[]" value="${i}"> </div> </div>`;
            $(`#answers-block-${id}`).append(`<div class="form-group"><label for="answer-${i}">Текст відповіді №${i+1}:</label> <div class="input-group"> <input type="text" class="form-control" id="answer-${i}" name="answers[]" placeholder="Введіть відповідь"> ${checkbox} </div></div>`);
        }
    }
}