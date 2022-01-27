(function (_, $) {
    console.log("success")

    // $(document).ready(function () {
    //     console.log("success")
    // });
    // $.ceEvent('on', '.auth_popup', function (context) {
    //
    //     console.log("success")
    // });
    $(_.doc).on('click', '#test', function (event) {
        $.ceAjax('request', fn_url('profiles.confirm'), {
            data: {
                phone: 6546546546546, result_ids: 'jdshfkjshfj'
            },
        });
    });

})(Tygh, Tygh.$);

