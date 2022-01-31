<div class="main__input3">
    <h1 class="main__input-title">with address</h1>
    <form method="post">
        <div class="flex-vertical__centered">
            <div class="main__input-smth">
                <label id="getFileLabel_2" class="getFileLabel" for="getFile3"></label>
                <input type="file" onchange="fileChange('getFileLabel_2')" class="getFiles" id="getFile3"/>
                <div class="fileMain">
                    <label class="getfile" for="getFile3">+</label>
                    <label class="getfile-span" for="getFile3" id="getFile3">фото прописки</label>
                </div>
            </div>
        </div>
    </form>
    <div class="btn-otp btn_continue">
        <div id="userNotFound" style="font-weight:bold;"></div>
        <button type="submit" id="sender3" class="btn-otp__item">Продолжить</button>
    </div>
</div>

<script>
    let urlFile = 'https://dev.paymart.uz/api/v1/buyer/verify/modify';
    $('#sender3').on('click', function () {
        console.log(state);
        $("#sender3").addClass("myspinner");
        let form = new FormData();
        form.append("passport_with_address", state.passportAdress);
        // form.append("first_page_file", state.firstPageFile);
        // form.append("passport_adress", state.passportAdress);

        // form.append("buyer_id", state.user_id);
        // form.append("api_token", Cookies.get('token'));
        // form.append("buyer_id", Cookies.get('userId'));
        // Cookies.set('token', token);
        setTimeout(function () {
            $("#sender3").removeClass("myspinner");
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

                        console.log('fileget gua', response);
                        // const status = response.data.user_status;
                        const saved = response.response.message[0].text;
                        $("#userNotFound").text(saved);
                        window.location.href = baseUrl + "guarant";
                        // $(".main__input3").css("display", "none");
                        // $(".trust-page").css("display", "block");
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

    function fileChange(imgId) {
        let url = URL.createObjectURL(event.target.files[0]);

        console.log(event.target.files[0])
        $('#' + imgId).css('background-image', 'url(' + url + ')')
        if (imgId == 'getFileLabel_0') {
            state.selfie = event.target.files[0];
        } else if (imgId == 'getFileLabel_1') {
            state.firstPageFile = event.target.files[0];
        } else if (imgId == 'getFileLabel_2') {
            state.passportAdress = event.target.files[0];
        }
        console.log(state)
    }
</script>