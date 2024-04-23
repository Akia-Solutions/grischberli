jQuery(document).ready(function( $ ) {

    // get qty element.
    var qty_element = '.qty';
  
    // theme compatibilites
    // avada theme
    if( $( '.custom-qty' ).length > 0 ) {
        qty_element = '.custom-qty';
    }
  
    // enfold theme
    if( $( '.custom-qty' ).length > 0 ) {
      qty_element = '.custom-qty';
    }
  
    // erado theme
    if( $( '.tc' ).length > 0 ) {
      qty_element = '.tc';
    }
  
    $( ".single_variation_wrap" ).on( "show_variation", function ( event, variation ) {
      $(qty_element).change();
    } );
  
    // now modify the prices
    $( qty_element ).on('change', function () {
        var id  = $('#current_id').data('id');
        var qty = $(this).val();
  
        // check if variable product
        if( $( '.variation_id' ).length > 0 ) {
          id = $('.variation_id').val();
        }

        // Check if grouped product.
        if( 'woocommerce-grouped-product-list-item__quantity' != $(qty_element).parent().parent().attr("class") ) {
            // get updated price with ajax.
            $.ajax({
              type: 'POST',
              url: bm_update_price.ajax_url,
              data: {'action' : 'update_price', 'id': id, 'qty' : qty, 'nonce' : bm_update_price.nonce },
              dataType: 'json',
              success: function(data) {
                if ( 0 != data ) {

                  if ( data['price_value'] > 0 ) {
                    // price has an sale price
                    if ( $('.summary .price > ins').length > 0 ) {
                      $('.summary .price > ins > .amount bdi').replaceWith(data['price']);
                    } else {
                      $('.summary .price > .amount bdi').replaceWith(data['price']);
                    }
                    // update ppu.
                    $('.summary .price-per-unit .amount bdi').replaceWith(data['ppu']);
                  }
                }
              }
            });   
        }
        return false;
    });
  });
  