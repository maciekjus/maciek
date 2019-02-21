CKEDITOR.plugins.add( 'simplebox', {
    requires: 'widget',

    icons: 'simplebox',

    init: function( editor ) {
		editor.widgets.add( 'simplebox', {
			button: 'Karta oferty',
			template:
				'<div class="card" style="min-width: 16em; width: 23%; float: left; margin: 6px; min-height: 200px;">' + 
					'<div class="card-body">' + 
						'Zawartość karty %ttt%' + 
					'</div>' + 
				'</div>',
			editables: {
				content: {
					selector: '.card-body'
				}
			},
			upcast: function( element ) {
                return element.name == 'div' && element.hasClass( 'card' );
            }
		} );
    }
} );
