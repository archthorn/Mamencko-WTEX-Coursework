let i = 0;

function addTest(){
    let btn = `<div class="input-group-append"><button type="button" class="btn btn-outline-secondary" data-test-id="${i}" onclick="removeTest(this)">Видалити тест</button></div>`;
    let input = `<input type="text" class="form-control" id="test-${i}" name="test[${-i-1}]" placeholder="Введіть назву теста">`;

    $('#tests-form').append(`<div class="container my-3 input-group" id=${i}> ${input + btn} </div>`);
    i++;
}

function removeTest(identifier){
    let index = $(identifier).data('test-id');
    $(`#${index}`).remove();
}