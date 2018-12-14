(function($){
    $( document ).ready( function( ){

		$( '#insert' ).click( function( ) {
			var st = tinyMCEPopup.getWindowArg( 'selectTxt' ),
				sc = tinyMCEPopup.getWindowArg( 'shortcode' ),
				sv = parseInt( document.getElementById( 'spot_id' ).value, 10 ),
				te = document.getElementById( 'spot_template' ),
				tv = te !== null ? te.value : '',
				op = '';

			if ( sv > 0 ) {
				sc = sc.replace( ' template=%VALUE2%', typeof( tv ) !== 'undefined' && tv !== '' ? ' template="' + tv + '"' : '');
				op = st + sc.replace( '%VALUE1%', sv );

				if ( window.tinyMCE.majorVersion < 4 ) {
					window.tinyMCE.execInstanceCommand( tinyMCE.activeEditor.id, 'mceInsertContent', false, op );
				}
				else {
					window.tinyMCE.execCommand( 'mceInsertContent', false, op );
				}
			}

			// Exit back to tinyMCE.
			tinyMCEPopup.editor.execCommand( 'mceRepaint' );
			tinyMCEPopup.close( );
			return;
		} );

		$( '#spot_selector li:not(.no-click)' ).live( 'click', function( ){
			var v = $( this ).attr( 'data-value' ),
				t = $( this ).text( ),
				d = $( '#current_item_title' ),
				i = $( '#spot_id' );

			i.val( v );
			d.text( t );
			$( this ).addClass( 'current' ).siblings( ).removeClass( 'current' );
		} );

		$( '#spot_id_drop_search' ).autocomplete( {
													url: icitFinderL10.ajaxurl,
													extraParams: { 'action': 'find-spot'},
													showResult: function( value, data ) {
														var l  = $( '#search_results' ),
															li = $( '<li data-value="' + data + '">' + value + '</li>' );

														if ( ! l.has( 'li[data-value="' + data + '"]' ).length ) {
															li.hide().addClass( 'recent' ).prependTo( l ).slideDown( 500 );
														}

														l.find( 'li[data-value="' + data + '"]' ).prependTo( l ).addClass( 'recent' ).each( function( ){
															var w = $( this ),
																q = setTimeout( function( ){
																	w.removeClass( 'recent' );
																}, 5000 );
														} );

														l.find( 'li' ).removeClass( 'alternate' ).end( ).find( 'li:even' ).addClass( 'alternate' );

														return '<span data-value="' + data + '">' + value + '</span>';
													},
													onItemSelect: function( item ) {
														var v = item.data,
															t = item.value,
															d = $( '#current_item_title' ),
															i = $( '#spot_id' );
														i.val( v );
														d.text( t );
														$( '#spot_selector li[data-value=' + v + ']' ).addClass( 'current' ).siblings( ).removeClass( 'current' );
													},

													delay: 200,
													minChars: 2,
													maxCacheLength: 1
												} );
	});
})(jQuery);
