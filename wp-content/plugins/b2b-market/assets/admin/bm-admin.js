jQuery(document).ready(function ($) {
	
	/* mobile menu for ui backend menu */
	
    jQuery( '.b2b-market-left-menu .mobile-menu-outer' ).click( function(){
        jQuery( '.mobile-icon' ).toggleClass( 'open' );
		jQuery( '.b2b-market-left-menu ul' ).slideToggle( 'slow' );
    });

    /* toggle if product max is set */

    if ( autocomplete_data['product_max'] == 1 ) {
        $('.b2b-third.selection-products').css('display', 'none');
    }

    /* autocomplete for products */

    var product_data = [];

    $(autocomplete_data['products']).each(function () {
        var product = {
            id: this[1],
            text: this[0] + ' (ID: ' + this[1] + ')',
        }
        product_data.push(product);
    });

    $('#searchable-products').selectWoo({
        data: product_data,
        multiple: true,
    });

    $('#searchable-conditional-products').selectWoo({
        data: product_data,
        multiple: true,
    });

    $('#discount-products').selectWoo({
        data: product_data,
        multiple: true,
    });

    $('#bm_guest_users_product_blacklist').selectWoo({
        data: product_data,
        multiple: true,
    });

    /* autocomplete for categories */

    var cat_data = [];

    $(autocomplete_data['categories']).each(function () {

        var cat = {
            id: this[1],
            text: this[0] + ' (ID: ' + this[1] + ')',
        }

        cat_data.push(cat);

    });

    $('#searchable-categories').selectWoo({
        data: cat_data,
        multiple: true,
    });

    $('#searchable-conditional-categories').selectWoo({
        data: cat_data,
        multiple: true,
    });

    $('#searchable-discount-categories').selectWoo({
        data: cat_data,
        multiple: true,
    });

    $('#discount-categories').selectWoo({
        data: cat_data,
        multiple: true,
    });
        
    $('#bm_guest_users_category_blacklist').selectWoo({
        data: cat_data,
        multiple: true,
    });

    /* custom bm checkbox */

    var do_nothing = false;

    jQuery( '.bm-ui-checkbox.switcher' ).click( function() {

        if ( ! jQuery( this ).hasClass( 'clickable' ) ) {
            return;
        }

        jQuery( this ).parent().find( '.bm-ui-checkbox.switcher' ).toggleClass( 'active' );
        jQuery( this ).parent().find( '.bm-ui-checkbox.switcher' ).toggleClass( 'clickable' );
        do_nothing = true;
        jQuery( this ).parent().parent().find( '.slider' ).trigger( 'click' );
        do_nothing = false;
    });

    jQuery( '.bm-slider' ).click( function() {

        if ( ! do_nothing ) {
             jQuery( this ).parent().parent().find( '.bm-ui-checkbox.switcher' ).toggleClass( 'active' );
             jQuery( this ).parent().parent().find( '.bm-ui-checkbox.switcher' ).toggleClass( 'clickable' );
        }

    });

    /* group tabs in product screen */
      var $beefup = $('.beefup').beefup({
        openSingle: true
      });

     $beefup.click($('#group-price'));
     $beefup.click($('#group-quantity'));

    /* function to check if get parameters set */
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };

    /* modify screen if edit group */
    $('.customer_group span.edit a').click(function (event) {
        event.preventDefault();
        var id = $(this).data("group");

        if ( 'on' === autocomplete_data['nocache'] ) {
            window.location.replace(autocomplete_data.admin_url + "&group_id=" + id + '&nocache=' + new Date().getTime() );
        } else {
            window.location.replace(autocomplete_data.admin_url + "&group_id=" + id );
        }
    });

    /* modify screen if new group */
    $('.new-group').click(function (event) {
        event.preventDefault();
        if ( 'on' === autocomplete_data['nocache'] ) {
            window.location.replace(autocomplete_data.admin_url + "&group_id=new" + '&nocache=' + new Date().getTime() );
        } else {
            window.location.replace(autocomplete_data.admin_url + "&group_id=new" );
        }
    });


    // check URL parameter if edit customer group.
    var group_id = getUrlParameter('group_id');

    $('#new_post').on('submit', function() {
        localStorage.setItem('group_settings', 'saved');
    });

    if ( 'saved' == localStorage.getItem('group_settings') ) {
        var saved_html = '<div class="notice-bm notice-success"><p>' + autocomplete_data.settings_saved + '</p></div>';
        $('.group-box').prepend(saved_html);
        localStorage.removeItem('group_settings');
    }

    console.log(localStorage.getItem('group_settings'));

    if (group_id != undefined) {
        $('.b2b-group-table').toggle();
        $('.group-box').toggle();
    }
 
    if ( 'on' === autocomplete_data['nocache'] ) {
        $('.groups a').on('click', function(e){
        e.preventDefault();
        window.location.href = this.href + '&nocache=' + new Date().getTime();
        });

        $('#backtogroups').on('click', function(e){
            e.preventDefault();
            window.location.href = this.href + '&nocache=' + new Date().getTime();
        });
    }

    /* Warning if name of customer group equals administrator, super admin, editor, author, contributor */
    var native_roles = [ 'Administrator', 'Super Admin', 'Editor', 'Author', 'Contributor' ];

    $('.b2b-group-title').on('focusout',function( e ) {
        
        if ( $.inArray( $(this).val(), native_roles) !== -1 ) {
            $('.b2b-name-warning').show();
            $('#submit').hide();
            return;
        }
        $('#submit').show();
        $('.b2b-name-warning').hide();
    });

    /* Ajax for deleting b2b admin cache */

    /* modal helper */
    function modal_close() {
        $('.modal').fadeOut(1000);
    }
    function modal_destroy() {
        $('.modal').trigger('closeModal');
    }
});
