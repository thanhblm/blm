/*
 * The table sorter plug-in using to add sorting function to a table
 * Author: dattrinh
 * Date: 16-11-2015 
 * Modified date: 27-12-2016
 */
(function($) {
	$.fn.tablesorter = function(options) {
		// This is default settings and extra options
		var defaults = {
			field : "",
			direction : "asc",
			fieldList : []
		};
		var settings = $.extend(defaults, options);
		// Set field and direction for the table.
		$(this).attr("field", settings.field);
		$(this).attr("direction", settings.direction);
		// Remove all child <i> of th.
		this.find("thead>tr>th").each(function(i) {
			$(this).find("i").remove();
		});
		// Unbind click event handler of th.
		this.find("thead>tr>th").each(function(i) {
			$(this).unbind("click");
		});
		// Add sort-field attribute to header column
		this.find("thead>tr>th").each(function(i) {
			if (settings.fieldList[i] != "") {
				// Add sort-field attribute
				$(this).attr("sort-field", settings.fieldList[i]);
				// Add hand pointer
				$(this).css("cursor", "pointer");
				// Add sorting icon
				if (settings.fieldList[i] == settings.field) {
					if (settings.direction == "asc") {
						$(this).append(" <i class='fa fa-sort-down'></i>");
					} else {
						$(this).append(" <i class='fa fa-sort-up'></i>");
					}
				} else {
					$(this).append(" <i class='fa fa-sort'></i>");
				}
			}
		});
		// Add hand pointer and click to sort event to sorting table column
		this.find("thead>tr>th[sort-field]").click(function(i) {
			var curField = $(this).attr("sort-field");
			var curDirection = settings.direction;
			if (curDirection == "asc") {
				curDirection = "desc";
			} else {
				curDirection = "asc";
			}
			// Call search function
			settings.callback(curField, curDirection);
		});
		return this;
	};
})(jQuery);