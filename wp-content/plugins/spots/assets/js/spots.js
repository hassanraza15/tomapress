var tb_position, current_spot, WPSetThumbnailHTML, WPSetThumbnailID, WPRemoveThumbnail;
;(function($){
	$( document ).ready( function( ) {

		// If Tiny MCE fails to load we should just jump ship...
		if ( typeof window.tinyMCE === 'undefined' )
			return;

		var bn = setPostThumbnailL10n.basename, // Widget base name
			mi = setPostThumbnailL10n.mceid, // Settings ID
			mb = $( '#wp-' + mi + '-wrap' ).find( '.wp-media-buttons' ), // Media buttons
			re = setPostThumbnailL10n.rich == 1, // Can we rich edit
			rx = new RegExp( '^widget-\\d+_' + bn + '-\\d+$' ), // Match for widget name
			oldVer = window.tinyMCE.majorVersion < 4,
			ICITgetInstance = function( id ) {
				var mce = false;

				mce = oldVer ?
					window.tinyMCE.getInstanceById( id ) :
					window.tinyMCE.get( id );

				return mce === null || mce === undefined ? false : mce;
			},

			startMCE = function( id ) {
				if ( ! re || ( typeof( tinyMCE ) !== 'object' && typeof( tinyMCE.settings ) !== 'object' ) || typeof( id ) == 'undefined'  )
					return; // I expect tiny would have been initiated by now.

				var ta = $( '#' + id ), // The textarea
					content = $.trim( ta.val( ).replace( /^\&nbsp\;(?:[\r\n])+$/m, '' ) ), // remove empty 'paragraph' that appears & trim
					spot_id = ta.parents( '.widget' ).find( '.spot-id' ).val();

				if ( ta.not(':disabled').length && ta.parents( ':not(:hidden)' ).length && !ICITgetInstance( id ) ) {
					if ( typeof( switchEditors.wpautop ) === 'function' )
						ta.val( switchEditors.wpautop( content ) );

					// Create the media buttons if they don't exist already.
					if ( !ta.parent().siblings( '.wp-media-buttons' ).length ) {
						mb.clone()
							.insertBefore( ta.parent() )
							.removeClass( 'hidden' )
							.find( 'a' )
							.data( 'editor', id )
							.bind( 'click.' + bn, function( ) {
								if ( typeof( tinyMCE ) === 'object' && ICITgetInstance( id ) )
									tinyMCE.execCommand( 'mceFocus', false, id );
							} );
					}

					if ( typeof( tinyMCEPreInit.mceInit[mi] ) !== 'undefined' ) {
						settings = tinyMCEPreInit.mceInit[mi]; // Wp3.3+
					}
					else {
						settings = typeof( icit_mce_settings ) !== 'undefined' ? icit_mce_settings[mi] : tinyMCE.settings;
					}

					// Make sure the second row of buttons is hidden
					if ( typeof( setUserSetting ) == 'function' )
						setUserSetting( 'hidetb', '0' );

					try {
						if ( oldVer ) {
							new tinyMCE.Editor( id, settings ).render();
						}
						else {
							new tinyMCE.Editor( id, settings, tinyMCE.EditorManager ).render();
						}

					}
					catch( e ) {
						// No idea why
						if ( typeof( console ) !== 'undefined' )
							console.log( e, id, settings );
					}

					// Toogle the code button
					ta.parents( '.widget-content' )
						.find( '.code-toggle a.visual' )
						.addClass( 'active' )
						.addClass( 'disabled' )
						.end( )
						.find( '.code-toggle a.text' )
						.removeClass( 'active' )
						.removeClass( 'disabled' )

					ta.parents( '.wp-editor-wrap' )
						.addClass( 'active' );

				}
			},
			killMCE = function( id ) {
				if ( typeof( tinyMCE ) !== 'object' || typeof( id ) == 'undefined' )
					return;

				var ta = $( '#' + id );

				if ( ICITgetInstance( id ) ) {
					try {
						tinyMCE.execCommand( 'mceFocus', false, id );
						tinyMCE.execCommand( 'mceCleanup', false, id );
						if ( oldVer ) {
							tinyMCE.triggerSave();
							tinyMCE.execCommand( 'mceRemoveControl', false, id );
						}
						else {
							ICITgetInstance( id ).save();
							ICITgetInstance( id ).destroy();
						}
					}
					catch( e ) {
						if ( typeof( console ) !== 'undefined' )
							console.log( e );

						// We had problems with the focus and cleanup, normally
						// due to a lost mce. Needs to die without save. :(
						if ( oldVer ) {
							tinyMCE.execCommand( 'mceRemoveControl', false, id );
						}
						else {
							ICITgetInstance( id ).destroy();
						}
					}

					// Remove the media buttons
					ta.parent()
						.siblings( '.wp-media-buttons' )
						.remove( );

					ta.parents( '.wp-editor-wrap' )
						.removeClass( 'active' );

					// Toogle the code button
					ta.parents( '.widget-content' )
						.find( '.code-toggle a.text' )
						.addClass( 'active' )
						.addClass( 'disabled' )
						.end( )
						.find( '.code-toggle a.visual' )
						.removeClass( 'active' )
						.removeClass( 'disabled' )
				}

			};

		if ( adminpage == 'widgets-php' ) {

			$( document ).ajaxComplete( function( e, h, o ) {
				var req = o !== undefined ? o.data.split( '&' ) : [],
					data = {}, _tmp, tx, i;

				for ( i in req ) {
					_tmp = req[i].split( '=' );
					data[_tmp[0]] = _tmp[1];
				}

				if ( data.action == 'save-widget' && data.id_base == bn ) {
					tx = $( 'div.widget[id$="' + data[ 'widget-id' ] + '"]' ).find( '.widget-inside textarea.mceme' );
					startMCE( tx.addClass( 'mceEdit' ).attr( 'id' ) );
				}

			} );


			$( '#wpbody' )
				.on( 'click', '.code-toggle .button.text', function( e ) {
					e.preventDefault();
					killMCE( $( this ).data( 'id' ) );
					return false;
				} )
				.on( 'click', '.code-toggle .button.visual', function( e ) {
					e.preventDefault();
					startMCE( $( this ).data( 'id' ) );
					return false;
				} );


			// Kill MCE on widget move
			$( '#wpbody' ).on( 'sortstart.' + bn, '.widgets-sortables', function( e, ui ) {
				var widget = ui.item,
					tx = '', id = widget.attr( 'id' );

				if ( typeof( id ) !== 'undefined' && id.match( rx ) ) {
					tx = widget.find( '.widget-inside textarea.mceme' );
					killMCE( tx.attr( 'id' ) );
					tx.removeClass( 'mceEdit' );
				}
			} );


			// Listen for a click on the widget drop down toggle and init or kill mce.
			$( '#wpbody' ).on( 'click.' + bn, '.widget-title-action a, .widget-title', function( ) {
				var widget = $( this ).parents( '.widget' ),
					tx = '', q;

				if ( widget.attr( 'id' ).match( rx ) ) {
					tx = widget.find( '.widget-inside textarea.mceme' );

					if ( !widget.children( '.widget-inside' ).is( ':hidden' ) ) {
						clearTimeout( q );
						killMCE( tx.attr( 'id' ) );
						tx.removeClass( 'mceEdit' );
					} else {
						// This is horrid. Due to some styling issues I delay the load of mce until the widget animation is most likely to be done.
						clearTimeout( q );
						q = setTimeout( function( ) {
							startMCE( tx.attr( 'id' ) )
							tx.addClass( 'mceEdit' );
						}, 260 );
					}

					// Remove the default save action so we can add our own.
					widget
						.find( 'input.widget-control-save' )
						.off( 'click' )
						.unbind( 'click' )
						.bind( 'click', function( e ) {
							e.preventDefault();

							if ( tx.length == 0 ) // If the textarea wasn't around at the point when this was first attached we need to look again
								tx = widget.find( '.widget-inside textarea.mceme' );

							// Remove MCE
							killMCE( tx.attr( 'id' ) );
							tx.removeClass( 'mceEdit' );

							// Trigger the normal WP widget save.
							wpWidgets.save( widget, 0, 1, 0 );
							return false;
						});
				}

			} );

			// set active editor
			$( document ).on( 'click.focusmce', '.wp-media-buttons a', function() {

				if ( typeof( 'wpActiveEditor' ) !== 'undefined' )
					wpActiveEditor = $( this ).parents( '.wp-editor-wrap' ).find( 'textarea' ).attr( 'id' );

			} );
		}

		WPSetThumbnailHTML = function(html){
			$('.spot-featured-image', current_spot).html(html);
		};

		WPSetThumbnailID = function(id){
			var field = $('input[value="_thumbnail_id"]');
			if ( field.size() > 0 ) {
				$('#meta\\[' + field.attr('id').match(/[0-9]+/) + '\\]\\[value\\]').text(id);
			}
		};

		WPRemoveThumbnail = function( nonce, spot_id ) {
			$.post( ajaxurl, {
				action: "set-spot-thumbnail",
				post_id: spot_id,
				thumbnail_id: -1,
				_ajax_nonce: nonce,
				cookie: encodeURIComponent(document.cookie)
			}, function(str){
				if ( str == '0' ) {
					alert( setPostThumbnailL10n.error );
				} else {
					WPSetThumbnailHTML(str);
				}
			} );
		};

		// create spot handler
		$( document ).on( 'click', '.create-spot', function() {
			current_spot = $(this).parents('.widget');

			// if no title then let them know
			if ( $( '.title-field', current_spot ).val() == '' ) {
				$( '.title-field', current_spot )
					.focus()
					.css( { backgroundColor: '#fee' } )
					.animate( { backgroundColor: '#fff' }, 4000 );
				return false;
			}

			// empty spot selection
			$( '.spot-select', current_spot ).val( '' );

			// click save button
			$( '.widget-control-save', current_spot ).click();

			return false;
		} );

	} );


	tb_position = function() {
		var tbWindow = $('#TB_window'), width = $(window).width(), H = $(window).height(), W = ( 720 < width ) ? 720 : width, adminbar_height = 0;

		if ( $('body.admin-bar').length )
			adminbar_height = 28;

		if ( tbWindow.size() ) {
			tbWindow.width( W - 50 ).height( H - 45 - adminbar_height );
			$('#TB_iframeContent').width( W - 50 ).height( H - 75 - adminbar_height );
			tbWindow.css({'margin-left': '-' + parseInt((( W - 50 ) / 2),10) + 'px'});
			if ( typeof document.body.style.maxWidth != 'undefined' )
				tbWindow.css({'top': 20 + adminbar_height + 'px','margin-top':'0'});
		};

		return $('a.thickbox').each( function() {
			var href = $(this).attr('href');
			if ( ! href ) return;
			href = href.replace(/&width=[0-9]+/g, '');
			href = href.replace(/&height=[0-9]+/g, '');
			$(this).attr( 'href', href + '&width=' + ( W - 80 ) + '&height=' + ( H - 85 - adminbar_height ) );
		});
	};
	$(window).resize(function(){ tb_position(); });

})( jQuery );


// use our own set as featured function
function WPSetAsThumbnail( c, b ) {
	var a = jQuery("a#wp-spot-thumbnail-"+c),
		spot_id = jQuery('.spot-select', current_spot).val();

	a.text( setPostThumbnailL10n.saving );
	jQuery.post( ajaxurl, {
		action: "set-spot-thumbnail",
		post_id: spot_id,
		thumbnail_id: c,
		_ajax_nonce: b,
		cookie: encodeURIComponent( document.cookie )
	},function(e){
		var d = window.dialogArguments || opener || parent || top;

		a.text( setPostThumbnailL10n.setThumbnail );

		if( e=="0" ) {
			alert( setPostThumbnailL10n.error );
		} else {
			jQuery("a.wp-post-thumbnail").show();
			a.text(setPostThumbnailL10n.done);
			a.fadeOut(2000);
			//d.WPSetThumbnailID(c);
			d.WPSetThumbnailHTML(e);
		}
	});
};
