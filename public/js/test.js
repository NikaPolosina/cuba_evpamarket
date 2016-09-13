

$(document).ready(function(){
    CModal = function (id) {
        var self = this;

        var _m = null;
        var el = $('#' + id);

        this.show = function () {
            _m = el.modal('show');
            _m.one('shown.bs.modal', function () {
                var promise = new Promise(function (res, rej) {
                    self.confirm = res;
                });

                promise.then(function (res) {
                    _m.modal('hide');
                    res();
                });

            });
        };

    };




});




    /**
     * Show modal window with current product
     * */
    $('#modal_delete').find('button.destroy').on('click', function () {
        console.log('true');
        $('#modal_delete').click();


    })
    $('#modal_delete').find('button.nothing').on('click', function () {
        console.log('false');

    })


