//функция для отправки ajax запроса для создания новой ставки
function send_form_to_add_new_bet() {
    let data = {
        post_title: jQuery('#input_post_title').val(),
        post_content: jQuery('#textarea_post_content').val(),
        type_of_bets: jQuery('#select_type_of_bets').val(),
        action: 'add_post_from_ajax'
    }
    if (!data.post_content || !data.post_title){
        errorDuringAddingNewBet();
        return;
    }
    jQuery.ajax({
        url: data_for_ajax.url,
        data: data,
        method: 'POST',
        success: (res)=>{
            if (res[res.length - 1] === '0'){
                res = res.slice(0, res.length - 1);
            }
            res = JSON.parse(res);
            console.log(res);
            if(res.ok){
                let divAfterSuccessSend = document.createElement('DIV');
                divAfterSuccessSend.classList.add('success_send')
                divAfterSuccessSend.innerHTML = '<p>Поздравляем! Вы опубликовали новую ставку</p>';
                jQuery('div.form').html(divAfterSuccessSend);
            } else {
                console.log(res.error);
                errorDuringAddingNewBet();
            }
        },
        error: (err)=>{
            console.log(err);
            errorDuringAddingNewBet();
        }
    });
}

function errorDuringAddingNewBet(){
    let divAfterUnsuccessSend = document.createElement('DIV');
    divAfterUnsuccessSend.classList.add('unsuccess_send')
    divAfterUnsuccessSend.innerHTML = '<p>К содалению, что-то пошло не так...</p>';
    jQuery('div.form').html(divAfterUnsuccessSend);
}


//функция для отправки ajax запроса при нажатии на кнопку Ставка пройдет
function makeBet() {
    let value = +jQuery('#sum_of_bet').val();
    if (!(value >= 100) || !(value <= 1000)){
        jQuery('.bets_post').append('<p>Введите корректное значение</p>');
        return;
    }
    console.log(value);
    let data = {
        post_id: jQuery('input#post_id').val(),
        meta_key: jQuery('input#post_id').val() + '_bet_vote',
        meta_value: value,
        action: 'make_bet_from_ajax'
    }
    if(!data.post_id){
        errorDuringMakingBet();
        return;
    }
    jQuery.ajax({
        url: data_for_ajax.url,
        data: data,
        method: 'POST',
        success: (res)=>{
            if (res[res.length - 1] === '0'){
                res = res.slice(0, res.length - 1);
            }
            res = JSON.parse(res);
            console.log(res);
            if(res.ok){
                let divAfterSuccessSend = document.createElement('DIV');
                divAfterSuccessSend.classList.add('success_send')
                divAfterSuccessSend.innerHTML = '<p>Поздравляем! Вы cделали ставку</p>';
                jQuery('input#sum_of_bet').attr('disabled', "");
                jQuery('button#button_for_bet').attr('disabled', "");
                jQuery('div.bets_post').append(divAfterSuccessSend);
                let dateForCookie = new Date(2031, 0).toUTCString();
                document.cookie = 'bet_post_'+ jQuery('input#post_id').val()+'='+value+';expires='+dateForCookie;
            } else {
                console.log(res.error);
                errorDuringMakingBet();
            }
        },
        error: (err)=>{
            console.log(err);
            errorDuringMakingBet();
        }
    });
}

function errorDuringMakingBet() {
    let divAfterUnsuccessSend = document.createElement('DIV');
    divAfterUnsuccessSend.classList.add('unsuccess_send')
    divAfterUnsuccessSend.innerHTML = '<p>К сожалению, что-то пошло не так...Попробуйте еще раз</p>';
    jQuery('div.bets_post').append(divAfterUnsuccessSend);
}

//обработчики на кнопки
if(jQuery('#button_for_bet_form').length){
    console.log('Script for form has been loaded!!!');
    jQuery(document).on('click','.form #button_for_bet_form', send_form_to_add_new_bet);
}

if(jQuery('#button_for_bet').length){
    console.log('Script for bet button has been loaded!!!');
    jQuery(document).on('click','#button_for_bet', makeBet);
}


