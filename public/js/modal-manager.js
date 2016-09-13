CModal = function (params) {
  var self = this;
  var _m = null;
  var modalId = 'CModal_'+Date.now();


  var modalTitle = params.title || 'Confirm action';
  var modalBody = params.body || 'Are you sure?';
  var confirmBtn = params.confirmBtn || 'Save changes';
  var cancelBtn = params.cancelBtn || 'Cancel';
  var action = params.action || function(){};


  var modalHtml = '<div class="modal fade" tabindex="-1" role="dialog" id="'+modalId+'">'+
      '<div class="modal-dialog" role="document">'+
      '<div class="modal-content">'+
      '<div class="modal-header">'+
      '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
      '<h4 class="modal-title">'+modalTitle+'</h4>'+
      '</div>'+
      '<div class="modal-body">'+
      '<p>'+modalBody+'</p>'+
      '</div>'+
      '<div class="modal-footer">'+
      '<button type="button" class="btn btn-default" data-dismiss="modal">'+cancelBtn+'</button>'+
      '<button type="button" class="btn btn-primary" id="'+modalId+'_close">'+confirmBtn+'</button>'+
      '</div>'+
      '</div>'+
      '</div>'+
      '</div>';


  $('body').append(modalHtml);

  this.show = function () {
    _m = $('#'+modalId).modal('show');
    _m.one('shown.bs.modal', function () {
      var promise = new Promise(function (res, rej) {
        self.confirm = res;
      });

      $('#'+modalId+'_close').one('click', function(){
        self.confirm(action);
      });

      promise.then(function (res) {
        _m.modal('hide');
        res();
      });

    });
  };

};
