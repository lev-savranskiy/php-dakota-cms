<?
// DEMO, not used
?>

<meta charset="UTF-8" />




	<style type="text/css">
	.ui-autocomplete-loading { background: white url('images/ui-anim_basic_16x16.gif') right center no-repeat; }
	</style>
	<script type="text/javascript">
	$(function() {
		function log(message) {
			$("<div/>").text(message).prependTo("#log");
			$("#log").attr("scrollTop", 0);
		}

		$("#city").autocomplete({
			source: function(request, response) {
				$.ajax({
					url: "http://ws.geonames.org/searchJSON",
					dataType: "jsonp",
					data: {
						featureClass: "P",
						style: "full",
						maxRows: 12,
						name_startsWith: request.term
					},
					success: function(data) {
						response($.map(data.geonames, function(item) {
							return {
								label: item.name + (item.adminName1 ? ", " + item.adminName1 : "") + ", " + item.countryName,
								value: item.name
							}
						}))
					}
				})
			},
			minLength: 2,
			select: function(event, ui) {
				log(ui.item ? ("Selected: " + ui.item.label) : "Nothing selected, input was " + this.value);
			},
			open: function() {
				$(this).removeClass("ui-corner-all").addClass("ui-corner-top");
			},
			close: function() {
				$(this).removeClass("ui-corner-top").addClass("ui-corner-all");
			}
		});
	});
	</script>
	<style>
		.ui-autocomplete-loading { background: url(indicator.gif) no-repeat right; }
		#city { width: 25em; }
	</style>



<div class="demo">

<div class="ui-widget">
	<label for="city">Your city: </label>
	<input id="city" autocomplete="off"/>

</div>

<div class="ui-widget" style="margin-top:2em; font-family:Arial">
	Result:
	<div id="log" style="height: 200px; width: 300px; overflow: auto;" class="ui-widget-content"></div>
</div>

</div><!-- End demo -->
