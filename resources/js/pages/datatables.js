/*
 *  Document   : datatables.js
 *  Author     : pixelcave
 *  Description: Using custom JS code to init DataTables plugin
 */

// DataTables, for more examples you can check out https://www.datatables.net/
class pageTablesDatatables {
	/*
	 * Init DataTables functionality
	 *
	 */
	static initDataTables() {
		// Override a few default classes
    jQuery.extend(jQuery.fn.dataTable.ext.classes, {
      sWrapper: "dataTables_wrapper dt-bootstrap5",
      sFilterInput: "form-control",
      sLengthSelect: "form-select"
    });

    // Override a few defaults
    jQuery.extend(true, jQuery.fn.dataTable.defaults, {
      processing : false,
      serverSide : false,
      order : [],
      dom: "Blfrtip",
      language: {
        AjaxRequestGeneralError: "Could not complete request. Please check your internet connection",
        lengthMenu: "<span class='seperator'></span>View _MENU_ records",
        search: "_INPUT_",
        searchPlaceholder: "Search..",
        info: "<span class='seperator'></span>Found total _TOTAL_ records",
        paginate: {
          first: '<i class="fa fa-angle-double-left"></i>',
          previous: '<i class="fa fa-angle-left"></i>',
          next: '<i class="fa fa-angle-right"></i>',
          last: '<i class="fa fa-angle-double-right"></i>'
        }
      },
      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
      pageLength: -1,
      buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
      dom: "<'row'<'col-sm-12'<'text-center bg-body-light py-2 mb-2'B>>>" +
              "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
    });

    // Override buttons default classes
    jQuery.extend(true, jQuery.fn.DataTable.Buttons.defaults, {
      dom: {
        button: {
          className: 'btn btn-sm btn-primary'
        },
      }
    });

		// Init full DataTable
		jQuery('.js-dataTable-full').dataTable({
			autoWidth: true
		});

    // Init DataTable with Buttons
    jQuery('.js-dataTable-buttons').DataTable({
      pageLength: 5,
      lengthMenu: [[5, 10, 20], [5, 10, 20]],
      autoWidth: false,
      buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
      dom: "<'row'<'col-sm-12'<'text-center bg-body-light py-2 mb-2'B>>>" +
              "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
    });
	}

	/*
	 * Init functionality
	 *
	 */
	static init() {
		this.initDataTables();
	}
}

// Initialize when page loads
Codebase.onLoad(() => pageTablesDatatables.init());
