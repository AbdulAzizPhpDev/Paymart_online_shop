<div class="main__input">
    <h1 class="main__input-title">selfie</h1>
    <form method="post">
        <div class="flex-vertical__centered">
            <div class="main__input-smth">
                <label id="getFileLabel_0" class="getFileLabel" for="getFile1"></label>
                <input type="file" onchange="fileChange('getFileLabel_0')" class="getFiles" id="getFile1"/>
                <div class="fileMain">
                    <label class="getfile" for="getFile1" id="getFile1">+</label>
                    <label class="getfile-span" for="getFile1">фото прописки</label>
                </div>
            </div>
        </div>
    </form>
    <div class="btn-otp btn_continue">
        <p id="userNotFound" style="font-weight:bold;"></p>
        <button type="submit" id="sender" class="btn-otp__item">Продолжить</button>
    </div>
</div>


<script>

    let urlFile = 'https://dev.paymart.uz/api/v1/buyer/verify/modify';

    $('#sender').on('click', function () {
        console.log(state);
        $("#sender").addClass("myspinner4");
        let form = new FormData();
        form.append("passport_selfie", state.selfie);
        // form.append("first_page_file", state.firstPageFile);
        // form.append("passport_adress", state.passportAdress);

        // form.append("buyer_id", state.user_id);
        // form.append("api_token", Cookies.get('token'));
        // form.append("buyer_id", Cookies.get('userId'));
        // Cookies.set('token', token);
        setTimeout(function () {
            $("#sender").removeClass("myspinner4");
        }, 3000);
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
                        $("#userNotFound").text(saved)
                        window.location.href = baseUrl + "passport-adress"
                        // $(".main__input").css("display", "none");
                        // $(".main__input2").css("display", "block");
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
                    } else {
                        let fileGetWrong = response.response.message[0]?.text;
                        $('#userNotFound').text(fileGetWrong);

                    }

                }
            })
        } else {
            $("#userNotFound").text('iltimos rasm yuklang');
        }
    })
</script>