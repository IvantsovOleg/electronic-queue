<script type="text/javascript" src="static/js/authPrint.js"></script>

<script>
    $(document).ready(function () {
        var objectAuth = new handlerauth(<?=$keyid?>, 'xxx');
        objectAuth.bindAuthHandler();
    });


</script>

<script type="text/javascript" src="static/js/keyboard.js"></script>
<a class="classButtom orangeButtom buttomBack" href="/kiosk_queue/web">Назад</a>
<div class="user_rec_block">
    <input type="hidden" id="active_field" value="lastname">
    <input type="hidden" id="pat_numbers" value="">

    <form method="post" name="userdata" id="userdata">
        <table class="user_rec_block_table">
            <tbody>

            <tr class="selected_tr">
                <td>
                    <span>Инициалы (ФИО):</span>
                </td>
                <td>
                    <input onkeydown="return false;" autocomplete="off" type="text" maxlength="3" placeholder="Ф.И.О"
                           class="firstname" id="p_direct_num" name="firstname">
                </td>
            </tr>
            <!--<tr>
                <td>
                    <span>Отчество:</span>
                </td>
                <td>
                    <input onkeydown="return false;" autocomplete="off" type="text" class="secondname"
                           name="secondname">
                </td>
            </tr>-->
            <tr>
                <td>
                    <span>Дата рождения:</span> <!-- сделать маску -->
                </td>
                <td>
                    <input onkeydown="return false;" autocomplete="off" placeholder=" дд.мм.гггг" type="text"
                           class="birthday" id="p_birthdate" name="birthday">
                </td>
            </tr>
            <tr class="numberDirection">
                <td colspan="1">
                    <span>Заполните поле "Номер направления"</span>
                </td>

            </tr>
            <tr class="numberDirection">

                <td>
                    <span>Номер направления\Записи:</span>
                </td>
                <td>
                    <input onkeydown="return false;" autocomplete="off" type="text" class="lastname notRequered"
                           id="p_device_id" name="lastname">
                </td>
            </tr>

            </tbody>
        </table>
        <input type="hidden" name="dayweek" class="dayweek" value="вторник">
        <input type="hidden" name="date_str" class="date_str" value="12 января">
        <input type="hidden" name="dat" class="dat" value="09:00">
        <input type="hidden" name="numbid" class="numbid" value="1121749">
    </form>
</div>


<div class="keyboard">
    <div class="keyboard_symbols_buttons">
        <table class="keyboard_table_rus">
            <tr>
                <td>
                    <div class="key_yellow_button">
                        <span>1</span>
                        <input type="hidden" value="1">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>2</span>
                        <input type="hidden" value="2">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>3</span>
                        <input type="hidden" value="3">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>4</span>
                        <input type="hidden" value="4">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>5</span>
                        <input type="hidden" value="5">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>6</span>
                        <input type="hidden" value="6">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>7</span>
                        <input type="hidden" value="7">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>8</span>
                        <input type="hidden" value="8">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>9</span>
                        <input type="hidden" value="9">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>0</span>
                        <input type="hidden" value="0">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>-</span>
                        <input type="hidden" value="-">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>/</span>
                        <input type="hidden" value="/">
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="key_yellow_button">
                        <span>Й</span>
                        <input type="hidden" value="Й">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>Ц</span>
                        <input type="hidden" value="Ц">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>У</span>
                        <input type="hidden" value="У">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>К</span>
                        <input type="hidden" value="К">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>Е</span>
                        <input type="hidden" value="Е">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>Н</span>
                        <input type="hidden" value="Н">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>Г</span>
                        <input type="hidden" value="Г">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>Ш</span>
                        <input type="hidden" value="Ш">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>Щ</span>
                        <input type="hidden" value="Щ">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>З</span>
                        <input type="hidden" value="З">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>Х</span>
                        <input type="hidden" value="Х">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>Ъ</span>
                        <input type="hidden" value="Ъ">
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="key_yellow_button">
                        <span>Ф</span>
                        <input type="hidden" value="Ф">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>Ы</span>
                        <input type="hidden" value="Ы">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>В</span>
                        <input type="hidden" value="В">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>А</span>
                        <input type="hidden" value="А">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>П</span>
                        <input type="hidden" value="П">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>Р</span>
                        <input type="hidden" value="Р">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>О</span>
                        <input type="hidden" value="О">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>Л</span>
                        <input type="hidden" value="Л">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>Д</span>
                        <input type="hidden" value="Д">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>Ж</span>
                        <input type="hidden" value="Ж">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>Э</span>
                        <input type="hidden" value="Э">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>Ё</span>
                        <input type="hidden" value="Ё">
                    </div>
                </td>
            </tr>
        </table>
        <table class="kb_con">
            <tr>
                <td>
                    <div class="key_yellow_button">
                        <span>Я</span>
                        <input type="hidden" value="Я">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>Ч</span>
                        <input type="hidden" value="Ч">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>С</span>
                        <input type="hidden" value="С">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>М</span>
                        <input type="hidden" value="М">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>И</span>
                        <input type="hidden" value="И">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>Т</span>
                        <input type="hidden" value="Т">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>Ь</span>
                        <input type="hidden" value="Ь">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>Б</span>
                        <input type="hidden" value="Б">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button">
                        <span>Ю</span>
                        <input type="hidden" value="Ю">
                    </div>
                </td>
                <td>
                    <div class="key_yellow_button probel">
                        <span>пробел</span>
                        <input type="hidden" value=" ">
                    </div>
                </td>
                <!--<td>
                    <div class="key_yellow_button latin">
                        <span>лат</span>
                        <input type="hidden" value="лат">
                    </div>
                </td>-->
            </tr>
        </table>
    </div>
    <div class="keyboard_control_buttons">
        <div class="next_field">
            <img src="static/img/next_field.png">
        </div>
        <div class="not_ready">
            <img src="static/img/not_ready.png">
        </div>
        <div class="cancel">
            <img src="static/img/cancel.png">
        </div>

    </div>
    <div class="backspace">
        стереть

    </div>

</div>