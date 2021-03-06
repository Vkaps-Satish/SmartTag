jQuery( document ).ready( function ( $ ) {
	var variable_id = jQuery( '[name="product_id"]' ).val();
	var available_ids = [];
	var variable_bulk_table = "";

	function get_table( product_id ) {
		if (typeof jQuery('.wdp_bulk_table_content').attr('data-available-ids') !== 'undefined') {
			available_ids = JSON.parse(jQuery('.wdp_bulk_table_content').attr('data-available-ids'));
		}

		if ( available_ids.indexOf( parseInt( product_id ) ) === -1 ) {
			return;
		}

		if ( product_id === variable_id && variable_bulk_table ) {
			jQuery( '.wdp_bulk_table_content' ).html( variable_bulk_table )
			return true;
		}

		var data = {
			action: 'get_table_with_product_bulk_table',
			product_id: parseInt( product_id ),
		};

		return jQuery.ajax( {
			url: script_data.ajaxurl,
			data: data,
			dataType: 'json',
			type: 'POST',
			success: function ( response ) {
				if ( response.success ) {
					jQuery( '.wdp_bulk_table_content' ).html( response.data )
					if ( product_id === variable_id ) {
						variable_bulk_table = response.data;
					}
				} else {
					get_table( variable_id );
				}
			},
			error: function ( response ) {
				get_table( variable_id );
			}
		} );
	}

	function init_events() {
		if ( jQuery( '.wdp_bulk_table_content' ).length > 0 ) {
			jQuery('.variations_form').on('found_variation', {variationForm: this},
				function (event, variation) {
					if (typeof variation === 'undefined') {
						get_table(variable_id);
						return false;
					}
					get_table(variation.variation_id);
					return false;
				})
				.on('click', '.reset_variations',
					{variationForm: this},
					function (event, variation) {
						get_table(variable_id);
						return false;
					})
				.on('reset_data',
					function (event) {
						get_table(variable_id);
						return false;
					});

			jQuery('.wdp_bulk_table_content').on('get_table', function (e, $obj_id) {
				if (typeof $obj_id === 'undefined' || !$obj_id) {
					get_table(variable_id);
				} else {
					get_table($obj_id);
				}
			});
		}

	}

	if ( script_data.js_init_trigger ) {
		$( document ).on( script_data.js_init_trigger, function () {
			init_events();
		} );
	}

	init_events();
} );