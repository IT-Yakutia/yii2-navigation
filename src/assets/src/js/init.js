(function($){
    function nestedInit(){
      var activeOpen = false;
      $('.box-drag').sortable({
        //distance: 5,
        //delay: 300,
        opacity: 0.6,
        cursor: 'move',
        receive: function(event, ui) { // Change Parent
          //console.log('receive');
          var _this = $(this);
          //var sorted = $(ui.item).attr('id');
          //console.log('move: ' + sorted);

          $('#stbList > .box-drag--item').each(function(index, el) {
            if ($(this).find('.box-drag--item').length > 0) {
              //$(this).css('border', '1px solid red');
              $(this).addClass('cmore'); // active').children('.box-drag').hide();
            } else {
              //$(this).removeAttr('style');
              $(this).removeClass('cmore active').children('.box-drag').show();
            }
          }).promise().done(function() {
            // if(!activeOpen) {
            //   activeOpen = true;
            //   clickOpen();
            // }
            _this.find('.box-drag--title').eq(0).removeClass('evento');
            clickOpen();
            //console.log('conta');
          });
        },
        update: function(event, ui) { // sort on the one level
          var move_area_id = $(event.target).attr('id');
          var current_node_id = $(ui.item).attr('id');
          var parent_id = $(ui.item).parents('.box-drag--item').attr('id');
          
          if(parent_id === undefined){
            // make this node is root
            ajaxSortNested(current_node_id, 'makeRoot', null);
          }else{
            //console.log("Parent node id: " + parent_id);
          }

          var siblings = $(ui.item).parent().children('.box-drag--item');
          var siblings_count = siblings.length;

          $( siblings ).each(function( index ) {
            if(current_node_id == $( this ).attr("id")){
              //console.log('That is me: ' + current_node_id);
              switch (index) {
                case 0:
                  // prepend
                  console.log(move_area_id.replace('model-', ''), parent_id.replace('navitem_', ''));
                  if(move_area_id.replace('model-', '') == parent_id.replace('navitem_', '')){
                    ajaxSortNested(current_node_id, 'prependTo', parent_id);
                  }
                  break;
                case (siblings_count - 1):
                  // append
                  console.log(move_area_id.replace('model-', ''), parent_id.replace('navitem_', ''));
                  if(move_area_id.replace('model-', '') == parent_id.replace('navitem_', '')){
                    ajaxSortNested(current_node_id, 'appendTo', parent_id);
                  }
                  break;
                default:
                  // insert before
                  ajaxSortNested(current_node_id, 'insertBefore', $( this ).next().attr("id"));
              }
            }
            //console.log( index + ": " + $( this ).attr("id") );
          });

        },
        connectWith: '.box-drag'
      }).disableSelection();
      var timeoutClick = null;
    }

    function clickOpen() {
      if ($('.cmore').length > 0) {
        $('.cmore > .box-drag--title').each(function() {
          if (!$(this).hasClass('evento')) {
            $(this).addClass('evento');
            $(this).on('click', function(event) {
              var _that = $(this);
              if (timeoutClick != null) {
                clearTimeout(timeoutClick);
              }

              timeoutClick = setTimeout(function() {
                //console.log('click');
                event.preventDefault();
                var animateIn = _that.closest('.cmore');
                var shownItem = _that.closest('.cmore').children('.box-drag');
                if (!animateIn.hasClass('in')) {
                  animateIn.addClass('in');
                }
                if (shownItem.is(':hidden')) {
                  shownItem.slideDown(function() {
                    animateIn.removeClass('in');
                  });
                  _that.closest('.cmore').removeClass('active');
                } else {
                  shownItem.slideUp(function() {
                    animateIn.removeClass('in');
                  });
                  _that.closest('.cmore').addClass('active');
                }
              }, 10);

            });
          }
        });

      }
    }

    function ajaxSortNested(nodeId, method, target){
      console.log("nodeId: "+nodeId+", method: "+method+", target: "+target);
      var url = '/admin/navigation/back/move';
      var data = {
        'move_node_id':nodeId,
        'move_mode':method,
        'terget_node_id':target,
      }
      $.post( url, data)
        .done(function( data ) {
          console.log( "Data Loaded: " + data );
        });
    }

    $(function(){

      nestedInit();

    });
})(jQuery);
  