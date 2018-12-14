(function() {
	tinymce.create( 'tinymce.plugins.addspotbuttonPlugin', {
		init : function(ed, url) {
			ed.addCommand('mceaddspotbutton', function() {
				ed.windowManager.open({
					file : ajaxurl + '?action=spots_mce_popup',
					width : 500,
					height : 500,
					inline : 1
				}, {
					pluginUrl : url,
					selectTxt : ed.selection.getContent({format : 'html'}),
					shortcode : '[icitspot id="%VALUE1%" template=%VALUE2%]'
				});
			});

			// Register extrabutton button
			ed.addButton('addspotbutton', {
				title	: 'Insert a spot.',
				cmd		: 'mceaddspotbutton'
			});
		},
		createControl : function(n, cm) {
			return null;
		},
		getInfo : function() {
			return {
				longname	: 'Spot shortcode addificationiser',
				author 		: 'James R Whitehead',
				authorurl	: 'http://www.interconnectit.com/',
				infourl		: 'mailto:admin@interconnectit.com',
				version		: "1.0"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('addspotbutton', tinymce.plugins.addspotbuttonPlugin);
})();
