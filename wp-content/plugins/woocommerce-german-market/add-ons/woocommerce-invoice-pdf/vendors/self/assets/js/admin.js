jQuery( document ).ready( function( $ ) {

    $( '#wp_wc_invoice_pdf_image_upload_button_footer, #wp_wc_invoice_pdf_image_upload_button_header, #wp_wc_invoice_pdf_image_upload_button_background' ).click( function() {

		var this_id 		= ( $(this).attr( 'id' ) );
		var formfield_id = this_id.replace( 'wp_wc_invoice_pdf_image_upload_button_', 'wp_wc_invoice_pdf_image_url_' );
		var frame;
		
		// If the media frame already exists, reopen it.
        if ( frame ) {
          frame.open();
          return;
        }
        
        // Create a new media frame
        frame = wp.media({
          multiple: false  // Set to true to allow multiple files to be selected
        });

        // When an image is selected in the media frame...
        frame.on( 'select', function() {
          
          // Get media attachment details from the frame state
          var attachment = frame.state().get( 'selection' ).first().toJSON();
          jQuery( '#' + formfield_id ).val( attachment.url );

        });

        // Finally, open the modal on click
        frame.open();
		
    });
	
	$( '#wp_wc_invoice_pdf_image_remove_button_header, #wp_wc_invoice_pdf_image_remove_button_footer, #wp_wc_invoice_pdf_image_remove_button_background' ).click( function() {
		var this_id 		= ( $(this).attr( 'id' ) );
		var formfield_id = this_id.replace( 'wp_wc_invoice_pdf_image_remove_button_', 'wp_wc_invoice_pdf_image_url_' );
		$( '#' + formfield_id ).val( '' );
    });

    $( '.refund_pdf' ).click( function() {
    	var refund_id = $( this ).attr( 'data-refund-id' );
    	var delete_button = $( this ).next( "[data-refund-id='" + refund_id + "']" ).show();
    });

    $( '.invoice_pdf' ).click( function() {
    	if (  ! $( this ).hasClass( 'always_create_new' ) ) {
    		$( this ).next( '.invoice_pdf_delete_content' ).css( 'display', 'inline-block' );
    	}
    });

    $( '.gm-select-all-refunds' ).click( function() {
    	var checked = $( this ).is( ":checked" );
    	$( '.gm-select-refund, .gm-select-all-refunds' ).prop( 'checked', checked ); 
    });

    if ( $( 'select#wp_wc_invoice_pdf_emails_attachment_format' ).length ) {
        let rows = $( '#wp_wc_invoice_pdf_emails_link_position, #wp_wc_invoice_pdf_emails_link_label_text, #wp_wc_invoice_pdf_emails_link_text, #wp_wc_invoice_pdf_emails_link_download_behaviour, #wp_wc_invoice_pdf_emails_refunds_link_label_text, #wp_wc_invoice_pdf_emails_refunds_link_text' ).closest( 'tr' );
        $( 'select#wp_wc_invoice_pdf_emails_attachment_format' ).on( 'change', function() {
            if ( 'link' == $( this ).val() ) {
                $( rows ).show();
            } else {
                $( rows ).hide();
            }
        });
        $( 'select#wp_wc_invoice_pdf_emails_attachment_format' ).change();
    }

});
