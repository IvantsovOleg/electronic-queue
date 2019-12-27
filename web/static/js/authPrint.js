function handlerauth(keyid, namequeue) {
    var keyIdBadAuth = keyid;

    var namequeue = namequeue;

    this.bindAuthHandler = function () {

// �� ��������� ����� ����� ������� ��������
       // $("#p_direct_num input[type='text']:first").focus();


        // ���� ��������� ���� � ������
        $(".user_rec_block input[type='text']").focus(function () {
            var hid = $(this).attr('class');
            $("#active_field").val(hid);
            $(".user_rec_block_table tr").removeClass("selected_tr");
            $(".user_rec_block input[type='text']." + hid).parent().parent().addClass("selected_tr");
        });

        $(".helper_for_patient").hide();
        $(".kdc").hide();

        function next_field() {
            var fields = [];
            $(".user_rec_block input[type='text']").each(function (i) {
                fields[i] = $(this).val();
            });

            var hid = $("#active_field").val();
            var focus_val = $(".user_rec_block input[type='text']:last").attr('class');
            if (focus_val == hid) {
                $(".user_rec_block_table tr").removeClass("selected_tr");
                $(".user_rec_block input[type='text']:first").parent().parent().addClass("selected_tr");
                $(".user_rec_block input[type='text']:first").focus();
                var new_focus = $(".user_rec_block input[type='text']:first").attr('class');
                $("#active_field").val(new_focus);
            }
            else {
                $(".user_rec_block input[type='text']." + hid).parent().parent().next().children().children("input").focus();
                $(".user_rec_block_table tr").removeClass("selected_tr");
                $(".user_rec_block input[type='text']." + hid).parent().parent().next().addClass("selected_tr");
            }
        }


        // ������� ������
        function erase_symbol() {
            var hid = $("#active_field").val();
            var er_val = $(".user_rec_block input[type='text']." + hid).val();
            $(".user_rec_block input[type='text']." + hid).val(er_val.substring(0, er_val.length - 1));
            $(".user_rec_block input[type='text']." + hid).focus();

            var er_val2 = $(".user_rec_block input[type='text']." + hid).val();
            if (er_val2 == '') {
                $(".keyboard_control_buttons .not_ready img").remove();
                $(".keyboard_control_buttons .not_ready").append("<img src='static/img/not_ready.png'>");
            }
            if (er_val2.length < 10 && hid == 'birthday') {
                $(".keyboard_control_buttons .not_ready img").remove();
                $(".keyboard_control_buttons .not_ready").append("<img src='static/img/not_ready.png'>");
            }
        }

        // ��� ������� �� ������ "�������"
        $(".backspace").click(function () {
            erase_symbol();
        });

// ������ ���������� �����, ������� ���
        function cancel_entering() {
            $(".user_rec_block input[type='text']").val('');
            $(".user_rec_block input[type='text']:first").focus();
            var hid = $(".user_rec_block input[type='text']:first").attr('class');
            $("#active_field").val(hid);
            $(".user_rec_block_table tr").removeClass("selected_tr");
            $(".user_rec_block input[type='text']:first").parent().parent().addClass("selected_tr");

            $(".keyboard_control_buttons .not_ready img").remove();
            $(".keyboard_control_buttons .not_ready").append("<img src='static/img/not_ready.png'>");
        }

        // ����� �������

        // ��������� ����:
        $(".next_field").mouseup(function () {
            $(this).children('img').remove();
            $(this).append("<img src='static/img/next_field.png'>");
        });
        $(".next_field").mousedown(function () {
            next_field();
            $(this).children('img').remove();
            $(this).append("<img src='static/img/next_field_in.png'>");
        });
        $(".next_field").mouseout(function () {
            $(this).children('img').remove();
            $(this).append("<img src='static/img/next_field.png'>");
        });

        // ������:
        $(".cancel").mouseup(function () {
            $(this).children('img').remove();
            $(this).append("<img src='static/img/cancel.png'>");
        });
        $(".cancel").mousedown(function () {
            $(this).children('img').remove();
            $(this).append("<img src='static/img/cancel_in.png'>");
            cancel_entering();
        });
        $(".cancel").mouseout(function () {
            $(this).children('img').remove();
            $(this).append("<img src='static/img/cancel.png'>");
        });


        $(".ajaxwait, .ajaxwait_image").hide();


        function press_key(symb) {
            // ������, ����� ���� ������ � ������ � �������� � ���� ������
            var hid = $("#active_field").val();

            if (hid != 'birthday') {
                var text_val = $(".user_rec_block input[type='text']." + hid).val();
                $(".user_rec_block input[type='text']." + hid).val(text_val + symb);
                $(".user_rec_block input[type='text']." + hid).focus();
            }
            else {
                var text_val1 = $(".user_rec_block input[type='text']." + hid).val();
                // ���� ����� - ������
                if (symb.match(/^[0-9]$/)) {
                    var tv_length = text_val1.length;
                    if (tv_length != 2 && tv_length != 5 && tv_length < 10) {
                        $(".user_rec_block input[type='text']." + hid).val(text_val1 + symb);
                        $(".user_rec_block input[type='text']." + hid).focus();
                    }
                    // ������ �����, ���� ������, ����� �� �����
                    var text_val2 = $(".user_rec_block input[type='text']." + hid).val();
                    var tv_length2 = text_val2.length;
                    if (tv_length2 == 2 || tv_length2 == 5) {
                        $(".user_rec_block input[type='text']." + hid).val(text_val2 + ".");
                        $(".user_rec_block input[type='text']." + hid).focus();
                    }
                }
            }
        }

        function latin() {
            var focus_field = $("#active_field").val();

            var butt = $(".latin input").val();
            // alert(butt);
            if (butt == '���') {
                $(".keyboard_table_lat").remove();
                $(".keyboard_symbols_buttons").load('smarty/templates/keyboard_rus.tpl');
            }
            else {
                $(".keyboard_table_rus").remove();
                $(".keyboard_symbols_buttons").load('smarty/templates/keyboard_lat.tpl');
            }
            $("." + focus_field).focus();
            $("." + focus_field).parent().parent().addClass("selected_tr");
        }


        // ��� ������� �� ����-������
        $(".key_yellow_button").not(".latin").click(function () {
            //var symb = $(this).children('input').val();
            //press_key(symb);
        });

        $(".latin").click(function () {
            latin();
        });

        // ������ ��������
        $(".key_yellow_button").not(".latin").mouseup(function () {
            var symb = $(this).children('input').val();
            press_key(symb);
        });


        // especially for lat & space
        $(".probel").mousedown(function () {
            $(this).removeClass("probel");
            $(this).addClass("probel_green");
        });
        // ������ ��������
        $(".probel").mouseup(function () {
            $(this).removeClass("probel_green");
            $(this).addClass("probel");
        });

        // ������ ��������
        $(".probel").mouseout(function () {
            $(this).removeClass("probel_green");
            $(this).addClass("probel");
        });

        $(".latin").mousedown(function () {
            $(this).removeClass("latin");
            $(this).addClass("latin_green");
        });
        // ������ ��������
        $(".latin").mouseup(function () {
            $(this).removeClass("latin_green");
            $(this).addClass("latin");
        });

        // ������ ��������
        $(".latin").mouseout(function () {
            $(this).removeClass("latin_green");
            $(this).addClass("latin");
        });

        var objectSelector = {
            fio: $('#p_direct_num'),
            p_birthdate:$('#p_birthdate'),
            maskFio: function (objectSelector) {
                var value = objectSelector.fio.val();
                if (value.length > 3) {
                    objectSelector.fio.val(value.substring(0, 3));
                }
            }
        };



        // =======	��������� � ����������� ������ "������"
        $(".key_yellow_button, .backspace, .cancel").click(function () {

            objectSelector.maskFio(objectSelector);

            var emp = 0;
            var bd = 0;

            $("input[type='text']").not('.notRequered').each(function (i) {
                if ($(this).val() == '') {
                    emp += 1;
                }
            });
            var bd_text = $(".birthday").val();
            var bd_text_length = bd_text.length;
            if (bd_text_length == 10)
                bd += 1;
            else
                bd -= 1;
            if (emp > 0 && bd == 0) {
                $(".keyboard_control_buttons .not_ready img").remove();
                $(".keyboard_control_buttons .not_ready").append("<img src='static/img/not_ready.png'>");
            }
            if (emp == 0 && bd > 0) {
                $(".keyboard_control_buttons .not_ready img").remove();
                $(".ajaxwait, .ajaxwait_image").show();
                $(".keyboard_control_buttons .not_ready").append("<img class='ready' src='static/img/ready.png'>");
                $(".ajaxwait, .ajaxwait_image").hide();
            }
        });

        // ������� ������ "������":
        /*$(".not_ready").mousedown(function () {
         if ($(".ready").length > 0) {
         //	$(this).children('img').remove();
         //$(this).append("<img class='ready' src='static/img/ready.png'>");
         }
         });*/


        function tryToMake() {

        }

        // ajax-�������� ������������ ������ ������������
        $(".not_ready").click(function () {
            if (true /*$(".ready").length > 0*/) {
                //$("#userdata").submit();

                var ser_fio = $('.seria').length;		// �������� �� �����-�����/���
                var userdata = [];
                var pat_numbers = $("#pat_numbers").val();
                var userdataTest = {};
                $('#userdata input[type="text"]').not('.notRequered').each(function (i) {
                    userdata[i] = $(this).val();
                });

                var dayweek = $('.dayweek').val();
                var date_str = $('.date_str').val();
                var numbid = $('.numbid').val();
                var dat = $('.dat').val();

                var namequeue = '<?=$namequeue?>';
                //var dopinfo = '<?=$dopinfo?>';

                // ���������� �� ��������


                //  window.location.href = 'index.php?r=site/ajaxauthpatient&userdata=' + userdata + '&ser_fio=' + ser_fio + '&dayweek=' + dayweek + '&date_str=' + date_str + '&dat=' + dat + '&numbid=' + '&pat_numbers=' + pat_numbers+ '&namequeue=' + namequeue;

                $.ajax({
                    type: "POST",
                    url: "index.php?r=site/ajaxauthpatient",
                    dataType: 'JSON',
                    data: {
                        userdata: userdata,
                        ser_fio: ser_fio,
                        dayweek: dayweek,
                        date_str: date_str,
                        dat: dat,
                        numbid: numbid,
                        pat_numbers: pat_numbers
                    },
                    success: function (data) {

                       /* console.log(data);
                        console.log(data.data[0].TALON_ID);*/

                        if (data.data[0].TALON_ID < (-2)) {
                            window.location.href = 'index.php?r=site/printnumber&keyid=' + keyIdBadAuth + '&namequeue=xxx';
                        }
                        if (data.data[0].TALON_ID < (-1)) {
                            $('.lastname').removeClass("notRequered");
                            $('.numberDirection').css('visibility', 'visible');
                            $('#p_device_id').val('');

                        }
                        if (data.data[0].TALON_ID > (-1)) {
                            window.location.href = 'index.php?r=site/renderafterauth';
                        }
                    }
                });
            }
        });
        $(".not_ready").mouseout(function () {
            if ($(".ready").length > 0) {
                $(this).children('img').remove();
                $(this).append("<img class='ready' src='static/img/ready.png'>");
            }
        });

        objectSelector.fio.focus();


    }


}



