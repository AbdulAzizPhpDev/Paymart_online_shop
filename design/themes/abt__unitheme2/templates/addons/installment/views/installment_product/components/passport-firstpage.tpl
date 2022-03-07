<div class="main__input2">
    <h1 class="main__input-title">first page</h1>
    <form method="post">
        <div class="flex-vertical__centered">
            <div class="main__input-smth">
                <label id="getFileLabel_1" class="getFileLabel" for="getFile2"></label>
                <input type="file" onchange="fileChange('getFileLabel_1')" class="getFiles" id="getFile2"/>
                <div class="fileMain">
                    <label class="getfile" for="getFile2" id="getFile">+</label>
                    <label class="getfile-span" for="getFile2">фото прописки</label>
                </div>
            </div>
        </div>
    </form>
    <div class="btn-otp btn_continue">
        <p id="userNotFound" style="font-weight:bold;"></p>
        <button type="submit" id="sender2" class="btn-otp__item">Продолжить</button>
    </div>
</div>

<script>
    let urlFile = 'https://test.paymart.uz/api/v1/buyer/verify/modify';
    let baseUrlPass = 'http://new-cs-cart.log/index.php?dispatch=register_form.index&id=';
    $('#sender2').on('click', function () {
        console.log(state);
        $("#sender2").addClass("myspinner4");
        let form = new FormData();
        form.append("passport_first_page", state.firstPageFile);
        // form.append("first_page_file", state.firstPageFile);
        // form.append("passport_adress", state.passportAdress);
        setTimeout(function () {
            $("#sender2").removeClass("myspinner4");
        }, 3000);
        // form.append("buyer_id", state.user_id);
        // form.append("api_token", Cookies.get('token'));
        // form.append("buyer_id", Cookies.get('userId'));
        // Cookies.set('token', token);
        // setTimeout(function(){
        //     $( "#sender" ).removeClass( "myspinner" );
        // }, 3000);
        if (form != null) {
            form.append("step", 2);
            form.append("type", 2);
            $.ajax({
                type: 'POST',
                url: urlFile,
                data: form,
                processData: false,
                contentType: false,
                headers: {
                    Authorization: "Bearer" + " " + Cookies.get('token'),
                },
                success: function (response) {
                    if (response.status === 'success') {

                        console.log('fileget', response);
                        // const status = response.data.user_status;
                        const saved = response.response.message[0].text;
                        $("#userNotFound").text(saved);
                        // window.location.href = baseUrl + "otp-card&phone=" + phone
                        window.location.href = baseUrlPass + "passport-selfie"
                        // $(".main__input2").css("display", "none");
                        // $(".main__input3").css("display", "block");
                        // Cookies.set('token', token);
                        // if (status == 1) {
                        //     console.log('status 1')
                        //
                        //     $(".main-otp").css("display", "none");
                        //
                        // }
                        // if(status == 5) {
                        //     console.log('status 5');
                        //
                        //     $(".main-otp").css("display", "none");
                        //     $("#card-form").css("display", "none");
                        //     // $(".second-popup__last").css("display", "block");
                        //     $(".main__input").css("display", "block");
                        //
                        // }
                        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                        //     if (userStatus == 1) {
                        //         console.log('status 1')
                        //         window.location.href = baseUrlPass + "card";
                        //         $("#card-form").css("display", "block");
                        //         $(".main-otp").css("display", "none");
                        //
                        //     }
                        //     if (userStatus == 4) {
                        //         console.log('status 1')
                        //         $(".second-popup").css("display", "block");
                        //         $(".main-otp").css("display", "none");
                        //
                        //     }
                        //     if (userStatus == 5) {
                        //         console.log('status 5');
                        //
                        //         $(".main-otp").css("display", "none");
                        //         $("#card-form").css("display", "none");
                        //         // $(".second-popup__last").css("display", "block");
                        //         $(".main__input").css("display", "block");
                        //
                        //     }
                        // }  else {
                        //     let fileGetWrong = response.response.message[0]?.text;
                        //     $('#userNotFound').text(fileGetWrong);
                        //
                        //
                        // }

                        // }

                    } else {
                        $("#userNotFound").text('iltimos rasm yuklang');
                    }
                }
            })
        }
    })
</script>